<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentacoesFinanceiras extends Model
{

    protected $table = 'movimentacoes_financeiras';

    protected $fillable = [
        'categoria_id',
        'descricao',
        'observacao',
        'valor',
        'tipo',
        'data_movimentacao',
        'recorrente'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_movimentacao' => 'date',
        'recorrente' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriasFinanceiras::class, 'categoria_id');
    }
}
