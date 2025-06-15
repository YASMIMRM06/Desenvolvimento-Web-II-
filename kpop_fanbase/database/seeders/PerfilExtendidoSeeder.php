<?php

namespace Database\Seeders;

use App\Models\PerfilExtendido;
use App\Models\User;
use Illuminate\Database\Seeder;

class PerfilExtendidoSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Apenas 40% dos usuários terão perfil extendido (como na regra de negócio)
            if (rand(1, 100) <= 40) {
                PerfilExtendido::create([
                    'user_id' => $user->id,
                    'bio' => $this->generateBio(),
                    'redes_sociais' => $this->generateSocialMedia(),
                    'interesses' => $this->generateInterests(),
                    'genero_favorito' => $this->generateFavoriteGenre(),
                ]);
            }
        }
    }

    private function generateBio()
    {
        $bios = [
            'Fã de K-POP desde 2010! Amo BTS e Blackpink!',
            'Colecionador de photocards e álbuns raros.',
            'Sempre acompanho os comeback dos meus grupos favoritos!',
            'Organizo meetups de K-POP na minha cidade.',
            'Aprendendo coreografias de K-POP no meu tempo livre.',
        ];

        return $bios[array_rand($bios)];
    }

    private function generateSocialMedia()
    {
        $handles = ['@kpopfan123', '@kpopcollector', '@kpopdancer', '@kpoplover', '@kpopstan'];
        return 'instagram.com/' . $handles[array_rand($handles)];
    }

    private function generateInterests()
    {
        $interests = [
            'Música, Dança, Coreografias',
            'Colecionáveis, Photocards, Álbuns',
            'Idols, Grupos, Solistas',
            'Concursos, Eventos, Meetups',
            'Cultura Coreana, Idioma',
        ];

        return $interests[array_rand($interests)];
    }

    private function generateFavoriteGenre()
    {
        $genres = ['K-POP', 'K-HipHop', 'K-R&B', 'K-Indie', 'K-Rock'];
        return $genres[array_rand($genres)];
    }
}