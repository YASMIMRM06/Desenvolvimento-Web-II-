<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'criador_id',
        'nome',
        'descricao',
        'data_evento',
        'localizacao',
        'capacidade',
        'status'
    ];

    protected $casts = [
        'data_evento' => 'datetime',
    ];

    // Relacionamento N:1 com User (criador)
    public function criador()
    {
        return $this->belongsTo(User::class, 'criador_id');
    }

    // Relacionamento N:N com User (participantes)
    public function participantes()
    {
        return $this->belongsToMany(User::class, 'participacao_eventos')
                    ->withTimestamps()
                    ->withPivot('confirmado');
    }

    // Verifica se o evento está lotado
    public function estaLotado()
    {
        return $this->participantes()->count() >= $this->capacidade;
    }

    // Verifica se um usuário específico está participando
    public function usuarioEstaParticipando($userId)
    {
        return $this->participantes()->where('user_id', $userId)->exists();
    }
}