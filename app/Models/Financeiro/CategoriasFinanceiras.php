<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasFinanceiras extends Model
{

    protected $table = 'categorias_financeiras';

    protected $fillable = [
        'nome',
        'cor',
        'icone',
        'tipo'
    ];

    public function movimentacoes()
    {
        return $this->hasMany(MovimentacoesFinanceiras::class, 'categoria_id');
    }
}