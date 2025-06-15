<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Musica;
use Illuminate\Database\Seeder;

class MusicaSeeder extends Seeder
{
    public function run()
    {
        $grupos = Grupo::all();

        foreach ($grupos as $grupo) {
            $musicas = $this->getMusicasPorGrupo($grupo->nome);

            foreach ($musicas as $musica) {
                Musica::create([
                    'grupo_id' => $grupo->id,
                    'titulo' => $musica['titulo'],
                    'duracao' => $musica['duracao'],
                    'data_lancamento' => $musica['data_lancamento'],
                    'youtube_id' => $musica['youtube_id'],
                ]);
            }
        }
    }

    private function getMusicasPorGrupo($grupoNome)
    {
        $musicas = [
            'BTS' => [
                [
                    'titulo' => 'Dynamite',
                    'duracao' => 217,
                    'data_lancamento' => '2020-08-21',
                    'youtube_id' => 'gdZLi9oWNZg',
                ],
                [
                    'titulo' => 'Butter',
                    'duracao' => 164,
                    'data_lancamento' => '2021-05-21',
                    'youtube_id' => 'WMweEpGlu_U',
                ],
            ],
            'BLACKPINK' => [
                [
                    'titulo' => 'DDU-DU DDU-DU',
                    'duracao' => 209,
                    'data_lancamento' => '2018-06-15',
                    'youtube_id' => 'IHNzOHi8sJs',
                ],
                [
                    'titulo' => 'How You Like That',
                    'duracao' => 182,
                    'data_lancamento' => '2020-06-26',
                    'youtube_id' => 'ioNng23DkIM',
                ],
            ],
            'TWICE' => [
                [
                    'titulo' => 'Fancy',
                    'duracao' => 201,
                    'data_lancamento' => '2019-04-22',
                    'youtube_id' => 'kOHB85vDuow',
                ],
                [
                    'titulo' => 'Feel Special',
                    'duracao' => 195,
                    'data_lancamento' => '2019-09-23',
                    'youtube_id' => '3ymwOvzhwHs',
                ],
            ],
            'EXO' => [
                [
                    'titulo' => 'Love Shot',
                    'duracao' => 203,
                    'data_lancamento' => '2018-12-13',
                    'youtube_id' => 'pSudEWBAYRE',
                ],
                [
                    'titulo' => 'Tempo',
                    'duracao' => 239,
                    'data_lancamento' => '2018-11-02',
                    'youtube_id' => 'kmntW56R6aY',
                ],
            ],
            'Stray Kids' => [
                [
                    'titulo' => 'God\'s Menu',
                    'duracao' => 165,
                    'data_lancamento' => '2020-06-17',
                    'youtube_id' => 'jzYxbnHHhY4',
                ],
                [
                    'titulo' => 'Back Door',
                    'duracao' => 195,
                    'data_lancamento' => '2020-09-14',
                    'youtube_id' => 'X-uJtV8ScYk',
                ],
            ],
        ];

        return $musicas[$grupoNome] ?? [];
    }
}