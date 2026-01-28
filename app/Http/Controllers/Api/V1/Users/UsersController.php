<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\StoreUserRequest;
use App\Http\Requests\Api\V1\Users\UpdateUserRequest;
use App\Http\Resources\Api\V1\Users\UsersResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min($request->integer('per_page', 15), 50);

        $usuarios = User::query()
            ->select(['id', 'name', 'email', 'created_at'])
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        return UsersResource::collection($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $usuario = User::create($data);

        return new UsersResource($usuario);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        return new UsersResource($usuario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $usuario)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $usuario->update($data);

        return new UsersResource($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        try {
            $usuario->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário excluído com sucesso.'
            ], 200);
        } catch (QueryException $e) {

            if ($e->getCode() === '23000') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Este usuário possui vínculos ativos e não pode ser removido.'
                ], 409);
            }

            Log::critical('Erro de banco ao excluir usuário', [
                'id' => $usuario->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro interno do sistema.'
            ], 500);
        } catch (Throwable $e) {

            Log::error('Erro inesperado ao excluir usuário', [
                'id' => $usuario->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro interno.'
            ], 500);
        }
    }
}
