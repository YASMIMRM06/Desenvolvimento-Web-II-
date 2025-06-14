<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('musics')->latest()->paginate(10);
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|in:HYBE,SM Entertainment,YG Entertainment,JYP Entertainment,Outra',
            'debut_date' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('group-photos');
        }

        Group::create($validated);

        return redirect()->route('groups.index')->with('success', 'Grupo criado com sucesso!');
    }

    public function show(Group $group)
    {
        $group->load(['musics' => function($query) {
            $query->withAvg('ratings', 'rating');
        }, 'upcomingEvents']);

        return view('groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|in:HYBE,SM Entertainment,YG Entertainment,JYP Entertainment,Outra',
            'debut_date' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'remove_photo' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($group->photo) {
                Storage::delete($group->photo);
            }
            $validated['photo'] = $request->file('photo')->store('group-photos');
        } elseif ($request->remove_photo && $group->photo) {
            Storage::delete($group->photo);
            $validated['photo'] = null;
        }

        $group->update($validated);

        return redirect()->route('groups.show', $group)->with('success', 'Grupo atualizado com sucesso!');
    }

    public function destroy(Group $group)
    {
        if ($group->photo) {
            Storage::delete($group->photo);
        }
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Grupo removido com sucesso!');
    }
}