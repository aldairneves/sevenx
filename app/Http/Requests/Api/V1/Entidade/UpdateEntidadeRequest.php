<?php

namespace App\Http\Requests\Api\V1\Entidade;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntidadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:propriedade,instituicao',
            'cnpj_cpf' => 'required|string|max:20',
            'status' => 'required|in:ativo,inativo',
        ];
    }
}
