<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    public function run()
    {
        $grupos = [
            [
                'nome' => 'BTS',
                'empresa' => 'SH',
                'data_debut' => '2013-06-13',
                'descricao' => 'Também conhecidos como Bangtan Sonyeondan, são um grupo sul-coreano formado pela Big Hit Entertainment.',
                'foto' => 'bts.jpg',
            ],
            [
                'nome' => 'BLACKPINK',
                'empresa' => 'YG',
                'data_debut' => '2016-08-08',
                'descricao' => 'Grupo feminino formado pela YG Entertainment, conhecido por hits como "DDU-DU DDU-DU" e "Kill This Love".',
                'foto' => 'blackpink.jpg',
            ],
            [
                'nome' => 'TWICE',
                'empresa' => 'JP',
                'data_debut' => '2015-10-20',
                'descricao' => 'Grupo feminino formado através do programa Sixteen, conhecido por músicas cativantes.',
                'foto' => 'twice.jpg',
            ],
            [
                'nome' => 'EXO',
                'empresa' => 'SH',
                'data_debut' => '2012-04-08',
                'descricao' => 'Grupo masculino conhecido por seus conceitos únicos e poderosas performances vocais.',
                'foto' => 'exo.jpg',
            ],
            [
                'nome' => 'Stray Kids',
                'empresa' => 'JP',
                'data_debut' => '2018-03-25',
                'descricao' => 'Grupo masculino autoprodutor conhecido por suas letras inspiradoras e performances energéticas.',
                'foto' => 'straykids.jpg',
            ],
        ];

        foreach ($grupos as $grupo) {
            Grupo::create($grupo);
        }
    }
}