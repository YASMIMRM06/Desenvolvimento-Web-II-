<?php

namespace Database\Seeders;

use App\Models\Permissao;
use Illuminate\Database\Seeder;

class PermissaoSeeder extends Seeder
{
    public function run()
    {
        $permissoes = [
            [
                'nome' => 'admin',
                'descricao' => 'Acesso total ao sistema'
            ],
            [
                'nome' => 'gerente',
                'descricao' => 'Pode gerenciar grupos e eventos'
            ],
            [
                'nome' => 'moderador',
                'descricao' => 'Pode moderar conteúdo e avaliações'
            ],
            [
                'nome' => 'criar_eventos',
                'descricao' => 'Permissão para criar eventos'
            ],
            [
                'nome' => 'gerenciar_grupos',
                'descricao' => 'Permissão para adicionar/editar grupos'
            ],
        ];

        foreach ($permissoes as $permissao) {
            Permissao::create($permissao);
        }
    }
}