<?php

namespace App\Http\Resources\Api\V1\Entidade;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cnpj_cpf' => $this->cnpj_cpf,
            'status' => $this->status,
            // 'criado_em' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
