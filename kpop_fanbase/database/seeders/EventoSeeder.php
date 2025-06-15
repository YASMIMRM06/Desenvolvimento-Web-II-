<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@kpopfanbase.com')->first();
        $gerente = User::where('email', 'gerente@kpopfanbase.com')->first();

        $eventos = [
            [
                'criador_id' => $admin->id,
                'nome' => 'Meetup de Fãs de BTS',
                'descricao' => 'Encontro para fãs de BTS assistirem aos vídeos juntos e trocarem photocards.',
                'data_evento' => Carbon::now()->addDays(10),
                'localizacao' => 'Parque Central, São Paulo',
                'capacidade' => 50,
            ],
            [
                'criador_id' => $gerente->id,
                'nome' => 'Concurso de Dança K-POP',
                'descricao' => 'Tragam suas melhores coreografias de K-POP para competir por prêmios!',
                'data_evento' => Carbon::now()->addDays(20),
                'localizacao' => 'Centro Cultural, Rio de Janeiro',
                'capacidade' => 100,
            ],
            [
                'criador_id' => $admin->id,
                'nome' => 'Troca de Álbuns e Photocards',
                'descricao' => 'Evento para troca de itens colecionáveis de K-POP.',
                'data_evento' => Carbon::now()->addDays(15),
                'localizacao' => 'Shopping Norte, Belo Horizonte',
                'capacidade' => 30,
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }

        // Adicionar participantes aleatórios aos eventos
        $eventos = Evento::all();
        $users = User::where('tipo', 'fã')->get();

        foreach ($eventos as $evento) {
            $participantes = $users->random(rand(5, 15));
            
            foreach ($participantes as $participante) {
                $evento->participantes()->attach($participante->id, [
                    'confirmado' => (bool)rand(0, 1)
                ]);
            }
        }
    }
}