<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Review;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StudentProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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

    public function showBySlug($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'aprovado')
            ->with(['modules.lessons', 'user', 'category']) // Carrega módulos, lições, autor e categoria
            ->firstOrFail();

        // >>> NOVO: Consulta para cursos sugeridos: últimos cursos da mesma área que o curso atual, exceto o próprio
        $suggestedCourses = Course::where('status', 'aprovado')
            ->where('id', '<>', $course->id)  // Exclui o curso atual
            ->whereHas('category', function($query) use ($course) {
                $query->where('area', $course->category->area);
            })
            ->orderBy('created_at', 'desc')  // Os mais recentes primeiro
            ->take(4)                        // Limita a 4 cursos
            ->get();

        // CALCULA A MÉDIA DAS REVIEWS
        $averageRating = Review::where('course_id', $course->id)->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        // Carregar os reviews para o curso (ordenados dos mais recentes para os mais antigos)
        $reviews = Review::where('course_id', $course->id)
            ->latest()  // ou ->orderBy('created_at', 'desc')
            ->paginate(3);

        // Calcular número de cursos que o formador criou e estão aprovados
        $approvedCoursesCount = Course::where('user_id', $course->user->id)
            ->where('status', 'aprovado')
            ->count();

        // Calcular o número total de alunos inscritos em todos os cursos aprovados do formador:
        // Usamos withCount para cada curso e somamos o campo enrollments_count
        $totalEnrolled = Course::where('user_id', $course->user->id)
            ->where('status', 'aprovado')
            ->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');

        // Verificar se o usuário está autenticado
        if (Auth::check()) {
            // Verificar se o usuário está matriculado neste curso
            $enrollment = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first();

            // Carregar o progresso do aluno se estiver matriculado
            if ($enrollment) {
                // Carregar todas as lições que o aluno já concluiu
                $completedLessons = StudentProgress::where('enrollment_id', $enrollment->id)
                    ->where('completed', true)
                    ->pluck('lesson_id')
                    ->toArray();

                // Calcular a porcentagem de progresso
                $totalLessons = 0;
                foreach ($course->modules as $module) {
                    $totalLessons += $module->lessons->count();
                }

                $progressPercentage = $totalLessons > 0
                    ? round(count($completedLessons) / $totalLessons * 100)
                    : 0;

                return view('courses.show', compact('course', 'enrollment', 'completedLessons', 'progressPercentage', 'averageRating', 'reviews', 'approvedCoursesCount', 'totalEnrolled', 'suggestedCourses'));
            }
        }

        // Se o usuário não estiver matriculado, apenas mostra o curso
        return view('courses.show', compact('course', 'averageRating', 'reviews', 'approvedCoursesCount', 'totalEnrolled', 'suggestedCourses'));
    }

    public function showById($id)
    {

        $course = Course::where('id', $id)
            ->where('status', 'aprovado')
            ->with(['modules.lessons', 'user', 'category']) // Carrega módulos, lições, autor e categoria
            ->firstOrFail();

        // Se o usuário estiver autenticado, verifica a inscrição
        if (Auth::check()) {
            $enrollment = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first();

            // Se o usuário estiver matriculado, calcula o progresso
            if ($enrollment) {
                $completedLessons = \App\Models\StudentProgress::where('enrollment_id', $enrollment->id)
                    ->where('completed', true)
                    ->pluck('lesson_id')
                    ->toArray();

                $totalLessons = 0;
                foreach ($course->modules as $module) {
                    $totalLessons += $module->lessons->count();
                }

                $progressPercentage = $totalLessons > 0
                    ? round((count($completedLessons) / $totalLessons) * 100)
                    : 0;

                return view('courses.show', compact('course', 'enrollment', 'completedLessons', 'progressPercentage'));
            }
        }

        // Se o usuário não estiver matriculado, apenas mostra o curso
        return view('courses.show', compact('course'));
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

    public function AdminCreate()
    {
        $categories = Category::all();
        return view('admin.new_course', compact('categories'));
    }

    public function FormadorCreate()
    {
        $categories = Category::all();
        return view('formador.new_course', compact('categories'));
    }

    public function store(Request $request)
    {

        // Validação básica para todos
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'level' => 'required|in:Iniciante,Intermédio,Avançado',
            'duration' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'video_url' => 'required|string|max:255',
        ];

        // Se for admin, adiciona validação para status
        if (Auth::user()->isAdmin() && $request->has('status')) {
            $validationRules['status'] = 'required|in:pendente,aprovado,rejeitado';
        }

        $validated = $request->validate($validationRules);

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

        // Definir status com base no papel do usuário
        if (!Auth::user()->isAdmin() || !isset($validated['status'])) {
            $validated['status'] = 'pendente';
        }

        // Se o status for aprovado, defina a data de publicação
        if (isset($validated['status']) && $validated['status'] == 'aprovado') {
            $validated['published_at'] = now();
        }

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

            return back()->withInput()
                ->with('success', 'Curso criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()
                ->with('error', 'Ocorreu um erro ao criar o curso: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Buscar o curso junto com os módulos e as aulas
        $course = Course::with('modules.lessons')->findOrFail($id);

        // Opcional: Verificar permissão (ex.: só admin ou o formador pode editar)
        if (Auth::id() !== $course->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para editar este curso.');
        }

        // Carregar categorias para exibir no <select>
        $categories = Category::all();

        // Retornar a view de edição
        return view('courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // 1. Achar o curso
        $course = Course::with('modules.lessons')->findOrFail($id);

        // 2. Se quiser, verifique permissão
        if (Auth::id() !== $course->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para editar este curso.');
        }

        // 3. Validar dados básicos
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'level' => 'required|in:Iniciante,Intermédio,Avançado',
            'duration' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'required|string|max:255',
        ];

        // Se for admin, adiciona validação para status
        if (Auth::user()->isAdmin() && $request->has('status')) {
            $validationRules['status'] = 'required|in:pendente,aprovado,rejeitado';
        }

        $validated = $request->validate($validationRules);

        // Processar tags
        if (!empty($validated['tags'])) {
            $tagArray = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = json_encode($tagArray);
        } else {
            $validated['tags'] = json_encode([]);
        }

        // Atualizar imagem se foi enviada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image'] = $imagePath;
        }

        // Se for admin e o status foi fornecido
        if (Auth::user()->isAdmin() && $request->has('status')) {
            // Se o status foi alterado para aprovado, definir a data de publicação
            if ($validated['status'] == 'aprovado' && $course->status != 'aprovado') {
                $validated['published_at'] = now();
            }
        } else {
            // Se não for admin, não permite alterar o status
            // Remover o status do array para não atualizar
            if (isset($validated['status'])) {
                unset($validated['status']);
            }
        }

        // 4. Atualizar o curso
        DB::beginTransaction();
        try {
            $course->update($validated);

            // 5. Atualizar módulos e aulas
            //    Aqui fica complicado se quiser remover/editar em massa.
            //    Simplesmente "apagar tudo e recriar" ou "comparar"?
            //    Aqui vai um exemplo simplificado:

            // Apagar TODOS os módulos e aulas atuais (opcional) e recriar do zero
            // Se não quiser isso, tem de fazer um "diff" do que existia vs. o que veio
            $course->modules()->delete();

            if ($request->has('modules')) {
                foreach ($request->modules as $moduleData) {
                    $module = new Module([
                        'title' => $moduleData['title'],
                        'order' => $moduleData['order'],
                        'course_id' => $course->id
                    ]);
                    $module->save();

                    if (isset($moduleData['lessons'])) {
                        foreach ($moduleData['lessons'] as $lessonData) {
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
            return back()->withInput()
                ->with('success', 'Curso atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->with('error', 'Ocorreu um erro ao atualizar o curso: ' . $e->getMessage());
        }
    }



    public function adminIndex(Request $request)
    {
        // Inicia a query de courses
        $query = Course::query();


        // 1. FILTROS DE PESQUISA

        // Filtro de busca por título ou descrição
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por status (ex.: pendente, aprovado etc.)
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // 2. ORDENAÇÃO

        // Colunas válidas para 'sort'
        $sortableColumns = ['id', 'title', 'status', 'created_at', 'formador'];

        // Pega parâmetros de ordenação
        $sort = $request->get('sort', 'id');  // se não vier nada, ordena por id
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc'; // default asc

        // SEMPRE fazer join e selecionar o alias:
        $query->leftJoin('users', 'users.id', '=', 'courses.user_id')
            ->select('courses.*', DB::raw("CONCAT(users.firstname, ' ', users.lastname) as formador"));

        // Aí depois trata a ordenação
        if ($sort === 'formador') {
            $query->orderBy('formador', $direction);
        } elseif (in_array($sort, ['id','title','status','created_at'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('id', 'asc'); // ordenação padrão
        }

        // 3. PAGINAÇÃO

        $courses = $query->paginate(10);


        return view('admin.courses', compact('courses'));
    }

    public function formadorIndex(Request $request)
    {
        // Verificar se o user é formador
        if (Auth::user()->role !== 'formador') {
            return redirect('/'); // ou abort(403), etc.
        }

        $query = Course::where('user_id', Auth::id());

        // Filtro de busca por título ou descrição
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Ordenação
        $sortableColumns = ['id', 'title', 'status', 'created_at'];
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        if (!in_array($sort, $sortableColumns)) {
            $sort = 'id';
        }

        $query->orderBy($sort, $direction);

        $courses = $query->paginate(10);

        // Retornar uma Blade parecida com a do admin, só que para o formador
        return view('formador.courses', compact('courses'));
    }

    public function studentIndex(Request $request)
    {
        $user = Auth::user();

        // Buscando as inscrições do aluno, trazendo também o curso com seus relacionamentos 'user' e 'category'
        $enrollments = Enrollment::with(['course.user', 'course.category'])
            ->where('user_id', $user->id)
            ->whereNull('completed_at') // Apenas cursos em andamento (não finalizados)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('course', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('area'), function ($query) use ($request) {
                $query->whereHas('course', function ($q) use ($request) {
                    $q->where('category_id', $request->area);
                });
            })

            ->paginate(10);

        return view('aluno.courses', compact('enrollments'));
    }

    public function studentFavorites(Request $request)
    {
        $user = Auth::user();


        // Buscando os favoritos do aluno, trazendo também o curso com seus relacionamentos
        $favorites = Favorite::with(['course.user', 'course.category'])
            ->where('user_id', $user->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('course', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('area'), function ($query) use ($request) {
                $area = $request->area;
                $query->whereHas('course.category', function ($q) use ($area) {
                    $q->where('area', $area);
                });
            })
            ->paginate(10);

        return view('aluno.favorites', compact('favorites'));
    }

    public function studentCompletedCourses(Request $request)
    {
        $user = Auth::user();

        // Buscando as matrículas concluídas do aluno
        $completedEnrollments = Enrollment::with(['course.user', 'course.category'])
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('course', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('area'), function ($query) use ($request) {
                $area = $request->area;
                $query->whereHas('course.category', function ($q) use ($area) {
                    $q->where('area', $area);
                });
            })
            ->paginate(10);

        return view('aluno.completed', compact('completedEnrollments'));
    }

    public function approveCourse($id)
    {
        $course = Course::findOrFail($id);

        // Verificar se o usuário tem permissão (admin)
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para aprovar cursos.');
        }

        // Verificar se o curso está pendente
        if ($course->status == 'aprovado') {
            return redirect()->back()->with('error', 'Este curso não está pendente de aprovação.');
        }

        // Atualizar o status para aprovado
        $course->status = 'aprovado';
        $course->published_at = now(); // Define a data de publicação
        $course->save();

        return redirect()->back()->with('success', 'Curso aprovado com sucesso!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->back()->with('success', 'Curso excluído com sucesso!');
    }

    public function toggleFavorite($course_id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($course_id);

        // Verificar se o usuário já está matriculado neste curso
        $isEnrolled = \App\Models\Enrollment::where('user_id', $user->id)
                        ->where('course_id', $course_id)
                        ->exists();

        if ($isEnrolled) {
            return redirect()->back()->with('error', 'Você já está matriculado neste curso, não é possível favoritá-lo.');
        }

        // Verificar se o curso já está nos favoritos
        $existingFavorite = Favorite::where('user_id', $user->id)
                            ->where('course_id', $course_id)
                            ->first();

        if ($existingFavorite) {
            // Se já existe, remover dos favoritos
            $existingFavorite->delete();
            return redirect()->back()->with('success', 'Curso removido dos favoritos.');
        } else {
            // Se não existe, adicionar aos favoritos
            Favorite::create([
                'user_id' => $user->id,
                'course_id' => $course_id
            ]);
            return redirect()->back()->with('success', 'Curso adicionado aos favoritos.');
        }
    }

    public function removeFromFavoritesWhenEnrolled($course_id, $user_id)
    {
        // Este método é para ser chamado quando um usuário se matricula em um curso
        // Verificar se o curso está nos favoritos e remover
        Favorite::where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->delete();
    }
}
