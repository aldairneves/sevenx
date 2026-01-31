<?php

namespace App\Http\Controllers\Api\V1\Entidade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Entidade\StoreEntidadeRequest;
use App\Http\Requests\Api\V1\Entidade\UpdateEntidadeRequest;
use App\Http\Resources\Api\V1\Entidade\EntidadeResource;
use App\Models\Entidade\Entidade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class EntidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min($request->integer('per_page', 15), 50);

        $entidades = Entidade::query()
            ->select(['id', 'nome', 'status', 'created_at'])
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        return EntidadeResource::collection($entidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntidadeRequest $request)
    {
        $data = $request->validated();

        $entidade = Entidade::create($data);

        return new EntidadeResource($entidade);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entidade $entidade)
    {
        return new EntidadeResource($entidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntidadeRequest $request, Entidade $entidade)
    {
        $data = $request->validated();

        $entidade->update($data);

        return new EntidadeResource($entidade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entidade $entidade)
    {
        try {
            $entidade->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Entidade excluída com sucesso.'
            ], 200);
        } catch (QueryException $e) {

            if ($e->getCode() === '23000') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Esta Entidade possui vínculos ativos e não pode ser removido.'
                ], 409);
            }

            Log::critical('Erro de banco ao excluir entidade', [
                'id' => $entidade->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro interno do sistema.'
            ], 500);
        } catch (Throwable $e) {

            Log::error('Erro inesperado ao excluir entidade', [
                'id' => $entidade->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro interno.'
            ], 500);
        }
    }
}
