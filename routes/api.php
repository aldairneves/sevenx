<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Users\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // Logout do usuário autenticado
    Route::post('logout', [AuthController::class, 'logout']);

    // Rotas de usuários
    Route::get('usuarios', [UsersController::class, 'index']);
    Route::post('usuarios', [UsersController::class, 'store']);
    Route::get('usuarios/{usuario}', [UsersController::class, 'show']);
    Route::put('usuarios/{usuario}', [UsersController::class, 'update']);
    // Route::patch('usuarios/{usuario}', [UsersController::class, 'update']);
    Route::delete('usuarios/{usuario}', [UsersController::class, 'destroy']);
});
