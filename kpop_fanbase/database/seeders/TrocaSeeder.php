<?php

namespace Database\Seeders;

use App\Models\ItemColecionavel;
use App\Models\Troca;
use Illuminate\Database\Seeder;

class TrocaSeeder extends Seeder
{
    public function run()
    {
        $itensDesejados = ItemColecionavel::where('disponivel_para_troca', true)->get();

        foreach ($itensDesejados as $itemDesejado) {
            // Criar 1-3 propostas de troca para cada item disponível
            $numTrocas = rand(1, 3);
            
            // Itens que podem ser oferecidos (de outros usuários e disponíveis para troca)
            $itensOfertantes = ItemColecionavel::where('disponivel_para_troca', true)
                ->where('user_id', '!=', $itemDesejado->user_id)
                ->get();
            
            if ($itensOfertantes->count() > 0) {
                for ($i = 0; $i < min($numTrocas, $itensOfertantes->count()); $i++) {
                    $itemOfertante = $itensOfertantes->random();
                    
                    Troca::create([
                        'user_ofertante_id' => $itemOfertante->user_id,
                        'user_receptor_id' => $itemDesejado->user_id,
                        'item_ofertante_id' => $itemOfertante->id,
                        'item_desejado_id' => $itemDesejado->id,
                        'status' => $this->getRandomStatus(),
                        'mensagem' => $this->getRandomMessage(),
                        'data_proposta' => now()->subDays(rand(1, 30)),
                        'data_conclusao' => rand(0, 1) ? now()->subDays(rand(1, 10)) : null,
                    ]);
                }
            }
        }
    }

    private function getRandomStatus()
    {
        $statuses = ['pendente', 'aceito', 'recusado', 'cancelado', 'concluido'];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomMessage()
    {
        $messages = [
            'Gostaria de propor esta troca. O que acha?',
            'Tenho interesse no seu item. Aceita esta troca?',
            'Estou completando minha coleção. Podemos negociar?',
            'Vi que você tem este item disponível. Interessado na minha oferta?',
            'Tenho este item em ótimo estado para trocar pelo seu.',
        ];

        return $messages[array_rand($messages)];
    }
}