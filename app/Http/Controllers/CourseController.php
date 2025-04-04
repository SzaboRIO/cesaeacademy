<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::where('status', 'aprovado');

        // Filtros
        if ($request->has('area')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('area', $request->area);
            });
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->paginate(10);
        $categories = Category::all();

        return view('cursos', compact('courses', 'categories'));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'aprovado')
            ->firstOrFail();

        return view('curso.show', compact('course'));
    }

    public function showByArea($area)
    {
        $courses = Course::whereHas('category', function($query) use ($area) {
            $query->where('area', $area);
        })->where('status', 'aprovado')->paginate(12);

        return view('cursos', compact('courses', 'area'));
    }

    public function createModule($courseId)
    {
        $course = Course::findOrFail($courseId);

        // Verificar se o usuário tem permissão (é o formador do curso ou é admin)
        if (Auth::id() != $course->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar módulos a este curso.');
        }

        return view('courses.modules.create', compact('course'));
    }

    public function storeModule(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        // Verificar permissão
        if (Auth::id() != $course->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar módulos a este curso.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $module = new Module();
        $module->title = $validated['title'];
        $module->order = $validated['order'];
        $module->course_id = $course->id;
        $module->save();

        return redirect()->route('courses.edit', $course->id)
            ->with('success', 'Módulo adicionado com sucesso!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {

        // Validar dados do curso
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'level' => 'required|in:Iniciante,Intermédio,Avançado',
            'duration' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'video_url' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        

        // Processar tags
        if (!empty($validated['tags'])) {
            $tagArray = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = json_encode($tagArray);
        } else {
            $validated['tags'] = json_encode([]);
        }

        // Processar imagem
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image'] = $imagePath;
        }

        // Criar slug
        $validated['slug'] = Str::slug($validated['title']);

        // Definir user_id como o usuário atual
        $validated['user_id'] = Auth::id();

        // Definir status como pendente
        $validated['status'] = 'pendente';

        // Iniciar transação para garantir consistência
        DB::beginTransaction();

        try {
            // Criar o curso
            $course = Course::create($validated);

            // Processar módulos e aulas
            if ($request->has('modules')) {
                foreach ($request->modules as $moduleData) {
                    // Criar módulo
                    $module = new Module([
                        'title' => $moduleData['title'],
                        'order' => $moduleData['order'],
                        'course_id' => $course->id
                    ]);
                    $module->save();

                    // Processar aulas deste módulo
                    if (isset($moduleData['lessons'])) {
                        foreach ($moduleData['lessons'] as $lessonData) {
                            // Criar aula
                            $lesson = new Lesson([
                                'title' => $lessonData['title'],
                                'video_url' => $lessonData['video_url'],
                                'order' => $lessonData['order'],
                                'module_id' => $module->id
                            ]);
                            $lesson->save();
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('courses.index')
                ->with('success', 'Curso criado com sucesso! Aguardando aprovação do administrador.');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()
                ->with('error', 'Ocorreu um erro ao criar o curso: ' . $e->getMessage());
        }


    }
}
