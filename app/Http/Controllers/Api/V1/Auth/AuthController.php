<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login
     */
    public function login(LoginRequest $request)
    {
        // Valida dados
        $credentials = $request->validated();

        // Busca o usuário
        $user = User::where('email', $credentials['email'])->first();

        // Verifica se o usuário
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        // Cria um token
        $token = $user->createToken('api-token')->plainTextToken;

        // Retorna os dados do usuário e o token
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200); // OK
    }

    /**
     * Logout do usuário.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ], 200);
    }
}
