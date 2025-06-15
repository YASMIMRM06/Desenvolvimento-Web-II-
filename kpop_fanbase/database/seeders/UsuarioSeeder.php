<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Usuário admin
        User::create([
            'nome' => 'Admin KPOP',
            'email' => 'admin@kpopfanbase.com',
            'senha' => Hash::make('admin123'),
            'tipo' => 'admin',
            'email_verificado' => true,
        ]);

        // Usuário gerente
        User::create([
            'nome' => 'Gerente Eventos',
            'email' => 'gerente@kpopfanbase.com',
            'senha' => Hash::make('gerente123'),
            'tipo' => 'gerente',
            'email_verificado' => true,
        ]);

        // Usuários comuns (fãs)
        User::factory()->count(20)->create([
            'tipo' => 'fã',
            'email_verificado' => true,
        ]);

        // Atribuir permissões
        $admin = User::where('email', 'admin@kpopfanbase.com')->first();
        $admin->permissoes()->attach([1, 2, 3]); // Todas as permissões

        $gerente = User::where('email', 'gerente@kpopfanbase.com')->first();
        $gerente->permissoes()->attach([2]); // Permissão de gerente
    }
}