<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Musica;
use App\Models\Evento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $grupos = Grupo::withCount('musicas')->orderByDesc('musicas_count')->limit(5)->get();
        $musicas = Musica::with('grupo')->orderByDesc('created_at')->limit(5)->get();
        $eventos = Evento::where('data_evento', '>', now())->orderBy('data_evento')->limit(5)->get();

        return view('home', compact('grupos', 'musicas', 'eventos'));
    }

    public function sobre()
    {
        return view('sobre');
    }

    public function buscar(Request $request)
    {
        $termo = $request->input('q');

        $grupos = Grupo::where('nome', 'like', "%{$termo}%")->get();
        $musicas = Musica::where('titulo', 'like', "%{$termo}%")->with('grupo')->get();
        $eventos = Evento::where('nome', 'like', "%{$termo}%")->get();

        return view('busca', compact('grupos', 'musicas', 'eventos', 'termo'));
    }
}