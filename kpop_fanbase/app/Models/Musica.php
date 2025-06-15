<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musica extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'titulo',
        'duracao',
        'data_lancamento',
        'youtube_id'
    ];

    protected $appends = ['media_avaliacoes'];

    // Relacionamento N:1 com Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    // Relacionamento N:N com User através de Avaliacao
    public function avaliacoes()
    {
        return $this->belongsToMany(User::class, 'avaliacoes')
                    ->withPivot('nota', 'comentario', 'data_avaliacao')
                    ->withTimestamps();
    }

    // Calcula a média das avaliações
    public function calcularMedia()
    {
        return $this->avaliacoes()->avg('nota') ?? 0;
    }

    // Acessor para a média formatada
    public function getMediaAvaliacoesAttribute()
    {
        return number_format($this->calcularMedia(), 1);
    }

    // Formata a duração para mm:ss
    public function getDuracaoFormatadaAttribute()
    {
        $minutes = floor($this->duracao / 60);
        $seconds = $this->duracao % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}