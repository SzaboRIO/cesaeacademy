<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FormadorController extends Controller
{
    public function index()
    {
        $courses = Auth::user()->instructorCourses()->get();
        return view('dashboard.formador.index', compact('courses'));
    }

    public function courses()
    {
        $courses = Auth::user()->instructorCourses()->get();
        return view('dashboard.formador.cursos', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.formador.criar-curso', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'level' => 'required|in:Iniciante,Intermediário,Avançado',
            'duration' => 'required|integer|min:1',
            'what_you_will_learn' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Processar imagem
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image'] = $imagePath;
        }

        // Criar slug
        $validated['slug'] = Str::slug($validated['title']);

        // Adicionar instructor_id
        $validated['instructor_id'] = Auth::id();

        // Criar o curso
        $course = Course::create($validated);

        return redirect()->route('formador.course.edit', $course->id)
            ->with('success', 'Curso criado com sucesso! Agora adicione as aulas.');
    }

    public function edit($id)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $categories = Category::all();

        return view('dashboard.formador.editar-curso', compact('course', 'categories'));
    }

    // app/Http/Controllers/FormadorController.php (continuação)
    public function update(Request $request, $id)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'level' => 'required|in:Iniciante,Intermediário,Avançado',
            'duration' => 'required|integer|min:1',
            'what_you_will_learn' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Processar imagem
        if ($request->hasFile('image')) {
            // Excluir imagem antiga se existir
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }

            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image'] = $imagePath;
        }

        // Atualizar slug se o título foi alterado
        if ($course->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Atualizar status para pendente se estiver editando um curso já aprovado
        if ($course->status === 'aprovado') {
            $validated['status'] = 'pendente';
        }

        // Atualizar o curso
        $course->update($validated);

        return redirect()->route('formador.courses')
            ->with('success', 'Curso atualizado com sucesso! Aguarde aprovação do administrador.');
    }

    public function createLesson($courseId)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $courseId)
            ->firstOrFail();

        return view('dashboard.formador.criar-aula', compact('course'));
    }

    public function storeLesson(Request $request, $courseId)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $courseId)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:255',
            'module' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
        ]);

        $validated['course_id'] = $course->id;

        // Criar a aula
        Lesson::create($validated);

        return redirect()->route('formador.course.edit', $course->id)
            ->with('success', 'Aula adicionada com sucesso!');
    }

    public function editLesson($courseId, $lessonId)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $courseId)
            ->firstOrFail();

        $lesson = Lesson::where('course_id', $course->id)
            ->where('id', $lessonId)
            ->firstOrFail();

        return view('dashboard.formador.editar-aula', compact('course', 'lesson'));
    }

    public function updateLesson(Request $request, $courseId, $lessonId)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $courseId)
            ->firstOrFail();

        $lesson = Lesson::where('course_id', $course->id)
            ->where('id', $lessonId)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:255',
            'module' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
        ]);

        // Atualizar a aula
        $lesson->update($validated);

        return redirect()->route('formador.course.edit', $course->id)
            ->with('success', 'Aula atualizada com sucesso!');
    }

    public function deleteLesson($courseId, $lessonId)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->where('id', $courseId)
            ->firstOrFail();

        $lesson = Lesson::where('course_id', $course->id)
            ->where('id', $lessonId)
            ->firstOrFail();

        // Excluir a aula
        $lesson->delete();

        return redirect()->route('formador.course.edit', $course->id)
            ->with('success', 'Aula excluída com sucesso!');
    }

    public function statistics()
    {
        $courses = Auth::user()->instructorCourses()->with('enrollments')->get();

        return view('dashboard.formador.estatisticas', compact('courses'));
    }
}
