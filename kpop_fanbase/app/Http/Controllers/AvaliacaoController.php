<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Musica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Musica $musica)
    {
        $request->validate([
            'nota' => 'required|integer|between:1,5',
            'comentario' => 'nullable|string|max:500',
        ]);

        // Verifica se o usuário já avaliou esta música
        if ($musica->avaliacoes()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Você já avaliou esta música!');
        }

        $avaliacao = new Avaliacao([
            'user_id' => Auth::id(),
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        $musica->avaliacoes()->save($avaliacao);

        // Recalcula a média da música
        $musica->calcularMedia();
        $musica->save();

        return back()->with('success', 'Avaliação registrada com sucesso!');
    }

    public function update(Request $request, Avaliacao $avaliacao)
    {
        $this->authorize('update', $avaliacao);

        $request->validate([
            'nota' => 'required|integer|between:1,5',
            'comentario' => 'nullable|string|max:500',
        ]);

        $avaliacao->update([
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        // Recalcula a média da música relacionada
        $musica = $avaliacao->musica;
        $musica->calcularMedia();
        $musica->save();

        return back()->with('success', 'Avaliação atualizada com sucesso!');
    }

    public function destroy(Avaliacao $avaliacao)
    {
        $this->authorize('delete', $avaliacao);

        $musica = $avaliacao->musica;
        $avaliacao->delete();

        // Recalcula a média da música
        $musica->calcularMedia();
        $musica->save();

        return back()->with('success', 'Avaliação removida com sucesso!');
    }
}