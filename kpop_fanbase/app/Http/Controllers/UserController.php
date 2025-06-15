<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('perfilExtendido')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $permissoes = Permissao::all();
        return view('users.create', compact('permissoes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'senha' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => 'required|in:fan,gerente,admin',
        ]);

        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'tipo' => $request->tipo,
        ]);

        if ($request->permissoes) {
            $user->permissoes()->attach($request->permissoes);
        }

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $permissoes = Permissao::all();
        return view('users.edit', compact('user', 'permissoes'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'tipo' => 'required|in:fan,gerente,admin',
        ]);

        $user->update($request->only(['nome', 'email', 'tipo']));

        if ($request->permissoes) {
            $user->permissoes()->sync($request->permissoes);
        } else {
            $user->permissoes()->detach();
        }

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
    }
}