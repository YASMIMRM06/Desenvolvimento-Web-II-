<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'data_nascimento',
        'tipo',
        'foto_perfil',
        'email_verificado'
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected $casts = [
        'email_verificado_at' => 'datetime',
        'email_verificado' => 'boolean',
    ];

    // Relacionamento 1:1 com PerfilExtendido
    public function perfilExtendido()
    {
        return $this->hasOne(PerfilExtendido::class);
    }

    // Relacionamento N:N com Evento (participação)
    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'participacao_eventos')
                    ->withTimestamps()
                    ->withPivot('confirmado');
    }

    // Relacionamento N:N com Permissao (RBAC)
    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class, 'usuario_permissoes');
    }

    // Relacionamento N:N com Musica através de Avaliacao
    public function musicasAvaliadas()
    {
        return $this->belongsToMany(Musica::class, 'avaliacoes')
                    ->withPivot('nota', 'comentario', 'data_avaliacao')
                    ->withTimestamps();
    }

    // Eventos criados pelo usuário (1:N)
    public function eventosCriados()
    {
        return $this->hasMany(Evento::class, 'criador_id');
    }

    // Verifica se usuário tem uma permissão específica
    public function temPermissao($permissao)
    {
        return $this->permissoes()->where('nome', $permissao)->exists();
    }

    // Verifica se usuário é admin
    public function isAdmin()
    {
        return $this->tipo === 'admin' || $this->temPermissao('admin');
    }
}