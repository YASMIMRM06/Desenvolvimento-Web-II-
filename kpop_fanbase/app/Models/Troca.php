<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troca extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_ofertante_id',
        'user_receptor_id',
        'item_ofertante_id',
        'item_desejado_id',
        'status',
        'data_proposta',
        'data_conclusao'
    ];

    protected $casts = [
        'data_proposta' => 'datetime',
        'data_conclusao' => 'datetime',
    ];

    // Status possíveis para uma troca
    const STATUS_PENDENTE = 'pendente';
    const STATUS_ACEITO = 'aceito';
    const STATUS_RECUSADO = 'recusado';
    const STATUS_CANCELADO = 'cancelado';
    const STATUS_CONCLUIDO = 'concluido';

    // Relacionamento N:1 com User (ofertante)
    public function ofertante()
    {
        return $this->belongsTo(User::class, 'user_ofertante_id');
    }

    // Relacionamento N:1 com User (receptor)
    public function receptor()
    {
        return $this->belongsTo(User::class, 'user_receptor_id');
    }

    // Relacionamento N:1 com ItemColecionavel (item ofertado)
    public function itemOfertante()
    {
        return $this->belongsTo(ItemColecionavel::class, 'item_ofertante_id');
    }

    // Relacionamento N:1 com ItemColecionavel (item desejado)
    public function itemDesejado()
    {
        return $this->belongsTo(ItemColecionavel::class, 'item_desejado_id');
    }

    // Verifica se a troca pode ser aceita
    public function podeSerAceita()
    {
        return $this->status === self::STATUS_PENDENTE && 
               $this->itemOfertante->disponivel_para_troca &&
               $this->itemDesejado->disponivel_para_troca;
    }
}