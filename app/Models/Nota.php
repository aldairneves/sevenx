<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nota
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $conteudo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Nota extends Model
{
    protected $table = 'notas';

    protected $fillable = [
        'titulo',
        'conteudo'
    ];
}
