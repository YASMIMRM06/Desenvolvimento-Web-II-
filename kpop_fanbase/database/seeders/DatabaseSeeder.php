<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissaoSeeder::class,
            UsuarioSeeder::class,
            PerfilExtendidoSeeder::class,
            GrupoSeeder::class,
            MusicaSeeder::class,
            EventoSeeder::class,
            ItemColecionavelSeeder::class,
            TrocaSeeder::class,
        ]);
    }
}