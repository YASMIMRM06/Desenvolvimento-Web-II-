<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Musica;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::withCount('musicas')->paginate(10);
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'empresa' => 'required|in:SH,YG,JP,Outra',
            'data_debut' => 'required|date',
            'foto' => 'nullable|image|max:2048',
            'descricao' => 'nullable|string',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('grupos', 'public');
            $data['foto'] = $path;
        }

        Grupo::create($data);

        return redirect()->route('grupos.index')->with('success', 'Grupo criado com sucesso!');
    }

    public function show(Grupo $grupo)
    {
        $musicas = $grupo->musicas()->paginate(10);
        return view('grupos.show', compact('grupo', 'musicas'));
    }

    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'empresa' => 'required|in:SH,YG,JP,Outra',
            'data_debut' => 'required|date',
            'foto' => 'nullable|image|max:2048',
            'descricao' => 'nullable|string',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Remover foto antiga se existir
            if ($grupo->foto) {
                Storage::disk('public')->delete($grupo->foto);
            }
            
            $path = $request->file('foto')->store('grupos', 'public');
            $data['foto'] = $path;
        }

        $grupo->update($data);

        return redirect()->route('grupos.index')->with('success', 'Grupo atualizado com sucesso!');
    }

    public function destroy(Grupo $grupo)
    {
        if ($grupo->foto) {
            Storage::disk('public')->delete($grupo->foto);
        }
        
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo removido com sucesso!');
    }
}