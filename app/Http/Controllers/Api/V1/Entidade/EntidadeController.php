<?php

namespace App\Http\Controllers\Api\V1\Entidade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Entidade\StoreEntidadeRequest;
use App\Http\Requests\Api\V1\Entidade\UpdateEntidadeRequest;
use App\Http\Resources\Api\V1\Entidade\EntidadeResource;
use App\Models\Entidade\Entidade;
use Illuminate\Http\Request;

class EntidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dadosEntidade = Entidade::all();

        return EntidadeResource::collection($dadosEntidade);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntidadeRequest $request)
    {
        $data = $request->validated();

        $Entidade = Entidade::create($data);

        return new EntidadeResource($Entidade);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entidade $Entidade)
    {
        return new EntidadeResource($Entidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntidadeRequest $request, Entidade $Entidade)
    {
        $data = $request->validated();

        $Entidade->update($data);

        return new EntidadeResource($Entidade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entidade $Entidade)
    {
        $Entidade->delete();

        return response()->json(null, 204);
    }
}
