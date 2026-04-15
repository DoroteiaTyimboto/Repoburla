<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestadorLinkController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\CursoController;

// API Routes - Públicas
Route::get('/denuncias', [DenunciaController::class, 'index']);
Route::get('/denuncias/{denuncia}', [DenunciaController::class, 'show']);
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{curso}', [CursoController::class, 'show']);

// API Routes - Autenticadas
Route::middleware('auth:api')->group(function () {
    // Testador de Links
    Route::post('/testador-links/testar', [TestadorLinkController::class, 'test']);
    Route::get('/testador-links', [TestadorLinkController::class, 'index']);
    Route::get('/testador-links/{testador}', [TestadorLinkController::class, 'show']);
    Route::delete('/testador-links/{testador}', [TestadorLinkController::class, 'delete']);

    // Denúncias
    Route::post('/denuncias', [DenunciaController::class, 'store']);
    Route::put('/denuncias/{denuncia}', [DenunciaController::class, 'update']);
    Route::post('/denuncias/{denuncia}/comentario', [DenunciaController::class, 'addComment']);
    Route::post('/denuncias/{denuncia}/avaliar', [DenunciaController::class, 'rate']);
    Route::get('/meu-relatorios', [DenunciaController::class, 'myReports']);

    // Cursos
    Route::post('/cursos/{curso}/inscrever', [CursoController::class, 'enroll']);
    Route::post('/cursos/{curso}/desinscrever', [CursoController::class, 'unenroll']);
    Route::post('/cursos/{curso}/progresso', [CursoController::class, 'updateProgress']);
    Route::post('/cursos/{curso}/comentario', [CursoController::class, 'addComment']);
    Route::post('/cursos/{curso}/avaliar', [CursoController::class, 'rate']);
    Route::get('/meus-cursos', [CursoController::class, 'myCourses']);
});
