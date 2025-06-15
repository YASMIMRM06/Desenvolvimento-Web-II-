<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->except(['index', 'show', 'participar']);
    }

    public function index()
    {
        $eventos = Evento::with('criador')->paginate(10);
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_evento' => 'required|date|after:now',
            'localizacao' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
        ]);

        $evento = Evento::create([
            'criador_id' => Auth::id(),
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_evento' => $request->data_evento,
            'localizacao' => $request->localizacao,
            'capacidade' => $request->capacidade,
            'status' => 'ativo',
        ]);

        return redirect()->route('eventos.show', $evento)->with('success', 'Evento criado com sucesso!');
    }

    public function show(Evento $evento)
    {
        $participantes = $evento->participantes()->paginate(10);
        $estaParticipando = $evento->participantes()->where('user_id', auth()->id())->exists();
        
        return view('eventos.show', compact('evento', 'participantes', 'estaParticipando'));
    }

    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_evento' => 'required|date|after:now',
            'localizacao' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:' . $evento->participantes()->count(),
            'status' => 'required|in:ativo,cancelado,concluido',
        ]);

        $evento->update($request->all());

        return redirect()->route('eventos.show', $evento)->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento removido com sucesso!');
    }

    public function participar(Evento $evento)
    {
        if ($evento->estaLotado()) {
            return back()->with('error', 'Este evento já está lotado!');
        }

        if ($evento->participantes()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Você já está participando deste evento!');
        }

        $evento->participantes()->attach(auth()->id(), ['confirmado' => true]);

        return back()->with('success', 'Participação confirmada com sucesso!');
    }

    public function cancelarParticipacao(Evento $evento)
    {
        $evento->participantes()->detach(auth()->id());
        return back()->with('success', 'Participação cancelada com sucesso!');
    }
}