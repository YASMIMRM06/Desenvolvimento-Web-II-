<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Musica;
use Illuminate\Http\Request;

class MusicaController extends Controller
{
    public function index()
    {
        $musicas = Musica::with('grupo')->paginate(10);
        return view('musicas.index', compact('musicas'));
    }

    public function create()
    {
        $grupos = Grupo::all();
        return view('musicas.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'titulo' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
            'data_lancamento' => 'required|date',
            'youtube_id' => 'nullable|string|max:255',
        ]);

        Musica::create($request->all());

        return redirect()->route('musicas.index')->with('success', 'Música adicionada com sucesso!');
    }

    public function show(Musica $musica)
    {
        $avaliacoes = $musica->avaliacoes()->with('usuario')->paginate(10);
        return view('musicas.show', compact('musica', 'avaliacoes'));
    }

    public function edit(Musica $musica)
    {
        $grupos = Grupo::all();
        return view('musicas.edit', compact('musica', 'grupos'));
    }

    public function update(Request $request, Musica $musica)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'titulo' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
            'data_lancamento' => 'required|date',
            'youtube_id' => 'nullable|string|max:255',
        ]);

        $musica->update($request->all());

        return redirect()->route('musicas.index')->with('success', 'Música atualizada com sucesso!');
    }

    public function destroy(Musica $musica)
    {
        $musica->delete();
        return redirect()->route('musicas.index')->with('success', 'Música removida com sucesso!');
    }

    public function avaliar(Request $request, Musica $musica)
    {
        $request->validate([
            'nota' => 'required|integer|between:1,5',
            'comentario' => 'nullable|string|max:500',
        ]);

        // Verifica se o usuário já avaliou esta música
        if ($musica->avaliacoes()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Você já avaliou esta música!');
        }

        $musica->avaliacoes()->attach(auth()->id(), [
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Avaliação registrada com sucesso!');
    }
}