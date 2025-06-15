<?php

namespace Database\Seeders;

use App\Models\ItemColecionavel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemColecionavelSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Cada usuário terá entre 1-5 itens
            $numItens = rand(1, 5);
            
            for ($i = 0; $i < $numItens; $i++) {
                ItemColecionavel::create([
                    'user_id' => $user->id,
                    'nome' => $this->generateItemName(),
                    'descricao' => $this->generateItemDescription(),
                    'tipo' => $this->getRandomType(),
                    'estado' => $this->getRandomCondition(),
                    'disponivel_para_troca' => (bool)rand(0, 1),
                    'foto' => 'default_item.jpg',
                ]);
            }
        }
    }

    private function generateItemName()
    {
        $types = ['Álbum', 'Photocard', 'Poster', 'Lightstick', 'Polaroid'];
        $groups = ['BTS', 'BLACKPINK', 'TWICE', 'EXO', 'Stray Kids'];
        $editions = ['Edição Normal', 'Edição Limitada', 'First Press', 'Edição de Aniversário'];

        return $types[array_rand($types)] . ' ' . 
               $groups[array_rand($groups)] . ' - ' . 
               $editions[array_rand($editions)];
    }

    private function generateItemDescription()
    {
        $descriptions = [
            'Item em ótimo estado, cuidadosamente preservado.',
            'Pouco usado, sem arranhões ou danos visíveis.',
            'Novo, ainda na embalagem original.',
            'Item raro, difícil de encontrar no mercado.',
            'Pequenos sinais de uso, mas em bom estado geral.',
        ];

        return $descriptions[array_rand($descriptions)];
    }

    private function getRandomType()
    {
        $types = ['album', 'photocard', 'merchandising', 'outro'];
        return $types[array_rand($types)];
    }

    private function getRandomCondition()
    {
        $conditions = ['novo', 'seminovo', 'usado'];
        return $conditions[array_rand($conditions)];
    }
}