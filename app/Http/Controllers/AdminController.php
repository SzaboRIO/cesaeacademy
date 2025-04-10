<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Course;

class AdminController extends Controller
{
    /**
     * Exibe a lista de usuários.
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Aplicar filtros
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

            // **Nova parte**: ordenar
        $sortableColumns = ['id', 'firstname', 'email', 'created_at']; // colunas permitidas p/ sort
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc'; // default asc

        if (in_array($sort, $sortableColumns)) {
            // Se for 'id', 'firstname', 'email', etc.
            $query->orderBy($sort, $direction);
        } else {
            // Ordenação padrão se não tiver 'sort'
            $query->orderBy('id', 'asc');
        }

        $users = $query->paginate(10);

        return view('admin.users', compact('users'));
    }

    /**
     * Atualiza um usuário.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validação dos dados
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,formador,aluno',
            'profession' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable', 'image',
            'biography' => 'nullable', 'string',
        ]);

        // Atualizar dados básicos
        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->profession = $validated['profession'];
        $user->biography = $validated['biography'];

        if (isset($validated['avatar'])) {
            $avatarPath = $validated['avatar']->store('avatars', 'public');

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $avatarPath;
        }

        // Atualizar senha, se fornecida
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utilizador atualizado com sucesso!');
    }

    public function createUser()
    {
        return view('admin.new_user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string|in:admin,formador,aluno',
            'biography' => ['nullable', 'string'],
            'profession' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => ['nullable', 'image'],
        ]);

        // Cria nova instância de User
        $user = new User();
        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->profession = $validated['profession'] ?? null;
        $user->biography = $validated['biography'];

        $user->password = Hash::make($validated['password']);

        // Se houver avatar, salva e atribui
        if (isset($validated['avatar'])) {
            $avatarPath = $validated['avatar']->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utilizador criado com sucesso!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    /**
     * Remove um usuário.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Verificar se não está tentando excluir a si mesmo
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Não é possível excluir seu próprio usuário.');
        }

        // Excluir avatar do usuário
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Excluir o usuário
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Exibe a lista de cursos.
     */
    public function courses(Request $request)
    {
        $query = Course::with('instructor');

        // Aplicar filtros
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('updated_at', $request->date);
        }

        $courses = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('dashboard.admin.courses', compact('courses'));
    }

    /**
     * Atualiza um curso.
     */
    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Validação dos dados
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'area' => 'required|string|in:Development,IT Network,Media Design,People',
            'tags' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:draft,pending,published,rejected',
        ]);

        // Atualizar dados básicos
        $course->title = $validated['title'];
        $course->area = $validated['area'];
        $course->tags = $validated['tags'];
        $course->description = $validated['description'];
        $course->status = $validated['status'];

        $course->save();

        return redirect()->route('admin.courses')->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Aprova um curso.
     */
    public function approveCourse($id)
    {
        $course = Course::findOrFail($id);

        // Verificar se o curso está pendente
        if ($course->status != 'pending') {
            return redirect()->route('admin.courses')->with('error', 'Apenas cursos pendentes podem ser aprovados.');
        }

        $course->status = 'published';
        $course->save();

        return redirect()->route('admin.courses')->with('success', 'Curso aprovado e publicado com sucesso!');
    }

    /**
     * Rejeita um curso.
     */
    public function rejectCourse($id)
    {
        $course = Course::findOrFail($id);

        // Verificar se o curso está pendente
        if ($course->status != 'pending') {
            return redirect()->route('admin.courses')->with('error', 'Apenas cursos pendentes podem ser rejeitados.');
        }

        $course->status = 'rejected';
        $course->save();

        return redirect()->route('admin.courses')->with('success', 'Curso rejeitado com sucesso!');
    }

    /**
     * Remove um curso.
     */
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);

        // Excluir imagem do curso
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        // Excluir o curso
        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Curso excluído com sucesso!');
    }
}
