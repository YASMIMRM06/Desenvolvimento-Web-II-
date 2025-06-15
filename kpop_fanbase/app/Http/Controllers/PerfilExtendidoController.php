<?php

namespace App\Http\Controllers;

use App\Models\PerfilExtendido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilExtendidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = Auth::user();
        $perfil = $user->perfilExtendido ?? new PerfilExtendido();
        
        return view('perfil.extendido', compact('perfil'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'bio' => 'nullable|string|max:500',
            'redes_sociais' => 'nullable|string|max:255',
            'interesses' => 'nullable|string|max:255',
            'genero_favorito' => 'nullable|string|max:100',
            'foto_perfil' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto_perfil');

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('perfis', 'public');
            $data['foto_perfil'] = $path;
        }

        if ($user->perfilExtendido) {
            $user->perfilExtendido->update($data);
        } else {
            $data['user_id'] = $user->id;
            PerfilExtendido::create($data);
        }

        return redirect()->route('profile.show')->with('success', 'Perfil atualizado com sucesso!');
    }
}