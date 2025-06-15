<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemColecionavel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'tipo',
        'estado',
        'disponivel_para_troca',
        'foto'
    ];

    // Relacionamento N:1 com User (dono)
    public function dono()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento 1:N com Troca (como item oferecido)
    public function trocasComoOfertante()
    {
        return $this->hasMany(Troca::class, 'item_ofertante_id');
    }

    // Relacionamento 1:N com Troca (como item desejado)
    public function trocasComoDesejado()
    {
        return $this->hasMany(Troca::class, 'item_desejado_id');
    }

    // Escopo para itens disponíveis para troca
    public function scopeDisponiveisParaTroca($query)
    {
        return $query->where('disponivel_para_troca', true);
    }
}