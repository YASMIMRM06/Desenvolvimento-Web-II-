<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilExtendido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'redes_sociais',
        'interesses',
        'genero_favorito'
    ];

    // Relacionamento 1:1 com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}