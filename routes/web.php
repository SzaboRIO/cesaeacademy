<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormadorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cursos', [CourseController::class, 'index'])->name('courses.index');
Route::get('/curso/{slug}', [CourseController::class, 'showBySlug'])->name('courses.showBySlug');
//Route::get('/curso/{id}', [CourseController::class, 'showById'])->name('courses.showById');
Route::get('/area/{area}', [CourseController::class, 'showByArea'])->name('courses.area');
Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/colaborar', [HomeController::class, 'collaborate'])->name('collaborate');

// Perfil (rotas privadas)
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
});


// Rotas para alunos
Route::middleware(['auth', CheckRole::class.':aluno'])->group(function () {
    Route::get('/aluno/cursos-em-andamento', [CourseController::class, 'studentIndex'])->name('aluno.courses');
    Route::get('/aluno/favoritos', [CourseController::class, 'studentFavorites'])->name('aluno.favorites');
    Route::post('/curso/{id}/favorito', [CourseController::class, 'toggleFavorite'])->name('course.toggle-favorite');
    Route::get('/aluno/cursos-concluidos', [CourseController::class, 'studentCompletedCourses'])->name('aluno.completed');
    Route::post('/aluno/completar-licao', [EnrollmentController::class, 'markAsCompleted'])->name('student.complete-lesson');
    Route::post('/curso/{courseId}/matricular', [EnrollmentController::class, 'enroll'])->name('enroll');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Rotas para formadores
Route::middleware(['auth', CheckRole::class.':formador'])->group(function () {
    Route::get('/novo-curso-formador', [CourseController::class, 'formadorCreate'])->name('courses.create.formador');
    Route::post('/novo-curso-formador', [CourseController::class, 'store'])->name('courses.store.formador');
    Route::get('/editar-curso/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/editar-curso/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('/formador/cursos', [CourseController::class, 'formadorIndex'])->name('formador.courses');
});

// // Rotas para administradores
Route::middleware(['auth', CheckRole::class.':admin'])->group(function () {
    // Gerenciamento de usuários
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/novo-utilizador', [AdminController::class, 'createUser'])->name('admin.create_user');
    Route::post('/novo-utilizador', [AdminController::class, 'storeUser'])->name('admin.store_user');
    Route::get('/editar-utilizador/{id}', [AdminController::class, 'editUser'])->name('admin.edit_user');
    Route::put('/editar-utilizador/{id}', [AdminController::class, 'updateUser'])->name('admin.update_user');
    Route::delete('/excluir-utilizador/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

    // Gerenciamento de cursos
    Route::get('/novo-curso-admin', [CourseController::class, 'adminCreate'])->name('courses.create.admin');
    Route::post('/novo-curso-admin', [CourseController::class, 'store'])->name('courses.store.admin');
    Route::get('/admin/cursos', [CourseController::class, 'adminIndex'])->name('admin.courses');
    Route::get('/editar-curso/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/editar-curso/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('/curso/{id}/approve', [CourseController::class, 'approveCourse'])->name('courses.approve');
    Route::delete('/curso/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('/curso/{id}', [AdminController::class, 'showCourse'])->name('admin.course.show');
    Route::get('/rejeitar-curso/{id}', [AdminController::class, 'rejectCourse'])->name('admin.course.reject');
    Route::delete('/excluir-curso/{id}', [AdminController::class, 'deleteCourse'])->name('admin.course.delete');

    // Previsualização
    Route::get('/preview/aluno', [AdminController::class, 'previewAluno'])->name('admin.preview.aluno');
    Route::get('/preview/formador', [AdminController::class, 'previewFormador'])->name('admin.preview.formador');

 });
