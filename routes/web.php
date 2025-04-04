<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormadorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cursos', [CourseController::class, 'index'])->name('courses.index');
Route::get('/curso/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/area/{area}', [CourseController::class, 'showByArea'])->name('courses.area');
Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/colaborar', [HomeController::class, 'collaborate'])->name('collaborate');

// Dashboard (rota protegida)
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
});


// Rotas para alunos
Route::middleware(['auth', 'role:aluno'])->prefix('dashboard/aluno')->group(function () {
    Route::get('/', [DashboardController::class, 'aluno'])->name('dashboard.aluno');
    Route::get('/meus-cursos', [EnrollmentController::class, 'index'])->name('aluno.courses');
    Route::get('/curso/{id}', [EnrollmentController::class, 'show'])->name('aluno.course.show');
    Route::get('/curso/{enrollmentId}/aula/{lessonId}', [EnrollmentController::class, 'watchLesson'])->name('aluno.lesson.watch');
    Route::post('/curso/marcar-concluido', [EnrollmentController::class, 'markAsCompleted'])->name('aluno.lesson.complete');
    Route::get('/certificados', [EnrollmentController::class, 'certificates'])->name('aluno.certificates');
    Route::get('/avaliacoes', [EnrollmentController::class, 'reviews'])->name('aluno.reviews');
    Route::post('/curso/{courseId}/inscrever', [EnrollmentController::class, 'enroll'])->name('aluno.course.enroll');
});

// Rotas para formadores
Route::middleware(['auth', 'role:formador'])->prefix('dashboard/formador')->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/', [DashboardController::class, 'formador'])->name('dashboard.formador');
    Route::get('/meus-cursos', [FormadorController::class, 'courses'])->name('formador.courses');
    Route::get('/criar-curso', [FormadorController::class, 'create'])->name('formador.course.create');
    Route::post('/criar-curso', [FormadorController::class, 'store'])->name('formador.course.store');
    Route::get('/editar-curso/{id}', [FormadorController::class, 'edit'])->name('formador.course.edit');
    Route::put('/editar-curso/{id}', [FormadorController::class, 'update'])->name('formador.course.update');

    // Aulas
    Route::get('/curso/{courseId}/criar-aula', [FormadorController::class, 'createLesson'])->name('formador.lesson.create');
    Route::post('/curso/{courseId}/criar-aula', [FormadorController::class, 'storeLesson'])->name('formador.lesson.store');
    Route::get('/curso/{courseId}/editar-aula/{lessonId}', [FormadorController::class, 'editLesson'])->name('formador.lesson.edit');
    Route::put('/curso/{courseId}/editar-aula/{lessonId}', [FormadorController::class, 'updateLesson'])->name('formador.lesson.update');
    Route::delete('/curso/{courseId}/excluir-aula/{lessonId}', [FormadorController::class, 'deleteLesson'])->name('formador.lesson.delete');

    Route::get('/estatisticas', [FormadorController::class, 'statistics'])->name('formador.statistics');
});

// Rotas para administradores
Route::middleware(['auth', CheckRole::class.':admin'])->prefix('dashboard/admin')->group(function () {
    Route::get('/', [DashboardController::class, 'admin'])->name('dashboard.admin');

    // Gerenciamento de usuários
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/novo-utilizador', [AdminController::class, 'createUser'])->name('admin.create_user');
    Route::post('/novo-utilizador', [AdminController::class, 'storeUser'])->name('admin.store_user');
    Route::get('/utilizador/{id}', [AdminController::class, 'showUser'])->name('admin.user.show');
    Route::get('/editar-utilizador/{id}', [AdminController::class, 'editUser'])->name('admin.edit_user');
    Route::put('/editar-utilizador/{id}', [AdminController::class, 'updateUser'])->name('admin.update_user');
    Route::delete('/excluir-utilizador/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

    // Gerenciamento de cursos
    Route::get('/gerir-cursos', [AdminController::class, 'courses'])->name('admin.courses');
    Route::get('/curso/{id}', [AdminController::class, 'showCourse'])->name('admin.course.show');
    Route::get('/aprovar-curso/{id}', [AdminController::class, 'approveCourse'])->name('admin.course.approve');
    Route::get('/rejeitar-curso/{id}', [AdminController::class, 'rejectCourse'])->name('admin.course.reject');
    Route::get('/editar-curso/{id}', [AdminController::class, 'editCourse'])->name('admin.course.edit');
    Route::put('/editar-curso/{id}', [AdminController::class, 'updateCourse'])->name('admin.course.update');
    Route::delete('/excluir-curso/{id}', [AdminController::class, 'deleteCourse'])->name('admin.course.delete');

    // Gerenciamento de categorias
    Route::get('/categorias', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/criar-categoria', [AdminController::class, 'createCategory'])->name('admin.category.create');
    Route::post('/criar-categoria', [AdminController::class, 'storeCategory'])->name('admin.category.store');
    Route::get('/editar-categoria/{id}', [AdminController::class, 'editCategory'])->name('admin.category.edit');
    Route::put('/editar-categoria/{id}', [AdminController::class, 'updateCategory'])->name('admin.category.update');
    Route::delete('/excluir-categoria/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');

    // Previsualização
    Route::get('/preview/aluno', [AdminController::class, 'previewAluno'])->name('admin.preview.aluno');
    Route::get('/preview/formador', [AdminController::class, 'previewFormador'])->name('admin.preview.formador');

    // Gerenciamento de módulos
    Route::get('/courses/{courseId}/modules/create', [CourseController::class, 'createModule'])->name('courses.modules.create');
    Route::post('/courses/{courseId}/modules', [CourseController::class, 'storeModule'])->name('courses.modules.store');
    Route::get('/courses/{courseId}/modules/{moduleId}/edit', [CourseController::class, 'editModule'])->name('courses.modules.edit');
    Route::put('/courses/{courseId}/modules/{moduleId}', [CourseController::class, 'updateModule'])->name('courses.modules.update');
    Route::delete('/courses/{courseId}/modules/{moduleId}', [CourseController::class, 'destroyModule'])->name('courses.modules.destroy');
});
