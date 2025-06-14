<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ratings = $user->ratings()->with('music.group')->latest()->take(5)->get();
        $participatedEvents = $user->events()->latest()->take(5)->get();
        $trades = $user->trades()->latest()->take(5)->get();

        return view('profile.index', compact('user', 'ratings', 'participatedEvents', 'trades'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }
            $validated['profile_photo'] = $request->file('photo')->store('profile-photos');
        }

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Senha atual incorreta']);
            }
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function extended()
    {
        return view('profile.extended', [
            'user' => Auth::user(),
            'extendedProfile' => Auth::user()->extendedProfile ?? null
        ]);
    }

    public function storeExtended(Request $request)
    {
        $validated = $request->validate([
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'favorite_group' => 'nullable|string|max:100',
        ]);

        Auth::user()->extendedProfile()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('profile.index')->with('success', 'Dados adicionais atualizados!');
    }
}