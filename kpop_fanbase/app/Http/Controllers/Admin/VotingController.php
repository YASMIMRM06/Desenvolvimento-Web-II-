<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\VotingOption;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index()
    {
        $votings = Voting::withCount('options')
            ->filter(request(['search', 'status']))
            ->latest()
            ->paginate(10);

        return view('admin.votings.index', compact('votings'));
    }

    public function create()
    {
        return view('admin.votings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $voting = Voting::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'pending',
        ]);

        foreach ($validated['options'] as $option) {
            $voting->options()->create(['name' => $option]);
        }

        return redirect()->route('admin.votings.index')->with('success', 'Votação criada com sucesso!');
    }

    public function show(Voting $voting)
    {
        $voting->load('options');
        return view('admin.votings.show', compact('voting'));
    }

    public function edit(Voting $voting)
    {
        if ($voting->status !== 'pending') {
            return back()->with('error', 'Só é possível editar votações pendentes!');
        }

        $voting->load('options');
        return view('admin.votings.edit', compact('voting'));
    }

    public function update(Request $request, Voting $voting)
    {
        if ($voting->status !== 'pending') {
            return back()->with('error', 'Só é possível editar votações pendentes!');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $voting->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        // Atualizar opções
        $voting->options()->delete();
        foreach ($validated['options'] as $option) {
            $voting->options()->create(['name' => $option]);
        }

        return redirect()->route('admin.votings.index')->with('success', 'Votação atualizada com sucesso!');
    }

    public function destroy(Voting $voting)
    {
        $voting->delete();
        return redirect()->route('admin.votings.index')->with('success', 'Votação removida com sucesso!');
    }

    public function start(Voting $voting)
    {
        if ($voting->status !== 'pending') {
            return back()->with('error', 'Só é possível iniciar votações pendentes!');
        }

        $voting->update([
            'status' => 'active',
            'started_at' => now(),
        ]);

        return back()->with('success', 'Votação iniciada com sucesso!');
    }

    public function close(Voting $voting)
    {
        if ($voting->status !== 'active') {
            return back()->with('error', 'Só é possível encerrar votações ativas!');
        }

        $voting->update([
            'status' => 'closed',
            'ended_at' => now(),
        ]);

        return back()->with('success', 'Votação encerrada com sucesso!');
    }
}