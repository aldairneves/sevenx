<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Users\UsersController;

// Grupo de rotas da API versão 1 (v1)
// Todas as rotas aqui serão prefixadas com /api/v1
// Segue o padrão REST: GET, POST, PUT/PATCH, DELETE
// Usando Route::prefix para versionamento e organização
Route::prefix('v1')->group(function () {
    Route::get('usuarios', [UsersController::class, 'index']);
    Route::post('usuarios', [UsersController::class, 'store']);
    Route::get('usuarios/{usuario}', [UsersController::class, 'show']);
    Route::put('usuarios/{usuario}', [UsersController::class, 'update']);
    // Route::patch('usuarios/{usuario}', [UsersController::class, 'update']);
    Route::delete('usuarios/{usuario}', [UsersController::class, 'destroy']);
});
