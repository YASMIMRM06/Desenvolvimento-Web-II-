<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_debut',
        'empresa',
        'descricao',
        'foto'
    ];

    // Relacionamento 1:N com Musica
    public function musicas()
    {
        return $this->hasMany(Musica::class);
    }

    // Acessor para a empresa formatada
    public function getEmpresaFormatadaAttribute()
    {
        $empresas = [
            'SH' => 'SM Entertainment',
            'YG' => 'YG Entertainment',
            'JP' => 'JYP Entertainment'
        ];
        
        return $empresas[$this->empresa] ?? $this->empresa;
    }
}