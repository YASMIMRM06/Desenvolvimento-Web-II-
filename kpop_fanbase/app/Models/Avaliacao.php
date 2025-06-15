<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'user_id',
        'musica_id',
        'nota',
        'comentario'
    ];

    protected $casts = [
        'data_avaliacao' => 'datetime',
    ];

    // Relacionamento N:1 com User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento N:1 com Musica
    public function musica()
    {
        return $this->belongsTo(Musica::class);
    }
}