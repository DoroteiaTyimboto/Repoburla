<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TestadorLinkController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre', [HomeController::class, 'sobre'])->name('sobre');
Route::get('/contato', [HomeController::class, 'contato'])->name('contato');
Route::get('/mapa', [HomeController::class, 'mapa'])->name('mapa');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [AuthController::class, 'profile'])->name('profile');
    Route::post('/perfil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Denúncias
    Route::get('/denuncias', [DenunciaController::class, 'index'])->name('denuncias.index');
    Route::get('/denuncias/criar', [DenunciaController::class, 'create'])->name('denuncias.create');
    Route::post('/denuncias', [DenunciaController::class, 'store'])->name('denuncias.store');
    Route::get('/denuncias/{denuncia}', [DenunciaController::class, 'show'])->name('denuncias.show');
    Route::get('/denuncias/{denuncia}/editar', [DenunciaController::class, 'edit'])->name('denuncias.edit');
    Route::put('/denuncias/{denuncia}', [DenunciaController::class, 'update'])->name('denuncias.update');
    Route::post('/denuncias/{denuncia}/comentario', [DenunciaController::class, 'addComment'])->name('denuncias.comment');
    Route::post('/denuncias/{denuncia}/avaliar', [DenunciaController::class, 'rate'])->name('denuncias.rate');
    Route::get('/minhas-denuncias', [DenunciaController::class, 'myReports'])->name('my-denuncias');

    // Moderator Denuncias
    Route::post('/denuncias/{denuncia}/aprovar', [DenunciaController::class, 'approve'])
        ->name('denuncias.approve')->middleware('can:moderate');
    Route::post('/denuncias/{denuncia}/resolver', [DenunciaController::class, 'resolve'])
        ->name('denuncias.resolve')->middleware('can:moderate');
    Route::post('/denuncias/{denuncia}/rejeitar', [DenunciaController::class, 'reject'])
        ->name('denuncias.reject')->middleware('can:moderate');

    // Cursos
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/filtrar', [CursoController::class, 'filter'])->name('cursos.filter');
    Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
    Route::post('/cursos/{curso}/inscrever', [CursoController::class, 'enroll'])->name('cursos.enroll');
    Route::post('/cursos/{curso}/desinscrever', [CursoController::class, 'unenroll'])->name('cursos.unenroll');
    Route::post('/cursos/{curso}/progresso', [CursoController::class, 'updateProgress'])->name('cursos.progress');
    Route::post('/cursos/{curso}/comentario', [CursoController::class, 'addComment'])->name('cursos.comment');
    Route::post('/cursos/{curso}/avaliar', [CursoController::class, 'rate'])->name('cursos.rate');
    Route::get('/meus-cursos', [CursoController::class, 'myCourses'])->name('my-cursos');

    // Testador de Links
    Route::get('/testador-links', [TestadorLinkController::class, 'index'])->name('testador.index');
    Route::post('/testador-links/testar', [TestadorLinkController::class, 'test'])->name('testador.test');
    Route::get('/testador-links/{testador}', [TestadorLinkController::class, 'show'])->name('testador.show');
    Route::delete('/testador-links/{testador}', [TestadorLinkController::class, 'delete'])->name('testador.delete');
});

// Admin Routes
Route::middleware(['auth', 'can:moderate'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/denuncias', [AdminController::class, 'denuncias'])->name('denuncias');
    Route::get('/denuncias/filtrar', [AdminController::class, 'denunciaFilter'])->name('denuncias.filter');

    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/{user}/editar', [AdminController::class, 'usuarioEdit'])->name('usuarios.edit');
    Route::put('/usuarios/{user}', [AdminController::class, 'usuarioUpdate'])->name('usuarios.update');
    Route::delete('/usuarios/{user}', [AdminController::class, 'usuarioDelete'])->name('usuarios.delete');

    Route::get('/cursos', [CursoController::class, 'admin'])->name('cursos');
    Route::get('/cursos/criar', [CursoController::class, 'adminCreate'])->name('cursos.create');
    Route::post('/cursos', [CursoController::class, 'adminStore'])->name('cursos.store');
    Route::get('/cursos/{curso}/editar', [CursoController::class, 'adminEdit'])->name('cursos.edit');
    Route::put('/cursos/{curso}', [CursoController::class, 'adminUpdate'])->name('cursos.update');
    Route::delete('/cursos/{curso}', [CursoController::class, 'adminDestroy'])->name('cursos.delete');

    Route::get('/relatorios', [AdminController::class, 'relatorios'])->name('relatorios');
    Route::get('/notificacoes', [AdminController::class, 'notificacoes'])->name('notificacoes');
    Route::post('/notificacoes/enviar', [AdminController::class, 'enviarNotificacao'])->name('notificacoes.send');
    Route::get('/configuracoes', [AdminController::class, 'configuracoes'])->name('configuracoes');
});
