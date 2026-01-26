<?php

namespace App\Models\Entidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'entidade';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'tipo',
        'cnpj_cpf',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'tipo'   => 'string',
        'status' => 'string',
    ];

    public static function getNotFoundMessage()
    {
        return 'A entidade solicitada não existe.';
    }
}
