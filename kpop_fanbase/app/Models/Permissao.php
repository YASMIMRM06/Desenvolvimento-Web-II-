<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao'
    ];

    // Relacionamento N:N com User
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_permissoes');
    }
}