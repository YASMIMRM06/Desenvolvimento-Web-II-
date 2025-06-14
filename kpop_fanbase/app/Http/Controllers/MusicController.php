<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Music;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller
{
    public function index()
    {
        $musics = Music::with(['group', 'ratings'])
            ->withAvg('ratings', 'rating')
            ->filter(request(['search', 'group_id']))
            ->latest()
            ->paginate(10);

        $groups = Group::all();

        return view('musics.index', compact('musics', 'groups'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('musics.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
            'duration' => 'required|string',
            'release_date' => 'required|date',
            'youtube_url' => 'nullable|url',
            'description' => 'nullable|string',
            'composer' => 'nullable|string|max:255',
            'lyricist' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:100',
        ]);

        Music::create($validated);

        return redirect()->route('musics.index')->with('success', 'Música adicionada com sucesso!');
    }

    public function show(Music $music)
    {
        $music->load(['group', 'ratings.user'])
            ->loadAvg('ratings', 'rating');

        $userRating = Auth::check() 
            ? $music->ratings()->where('user_id', Auth::id())->first()
            : null;

        return view('musics.show', compact('music', 'userRating'));
    }

    public function edit(Music $music)
    {
        $groups = Group::all();
        return view('musics.edit', compact('music', 'groups'));
    }

    public function update(Request $request, Music $music)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
            'duration' => 'required|string',
            'release_date' => 'required|date',
            'youtube_url' => 'nullable|url',
            'description' => 'nullable|string',
            'composer' => 'nullable|string|max:255',
            'lyricist' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:100',
        ]);

        $music->update($validated);

        return redirect()->route('musics.show', $music)->with('success', 'Música atualizada com sucesso!');
    }

    public function destroy(Music $music)
    {
        $music->delete();
        return redirect()->route('musics.index')->with('success', 'Música removida com sucesso!');
    }

    public function showRateForm(Music $music)
    {
        $alreadyRated = $music->ratings()->where('user_id', Auth::id())->exists();
        return view('musics.rate', compact('music', 'alreadyRated'));
    }

    public function rate(Request $request, Music $music)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'music_id' => $music->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        return redirect()->route('musics.show', $music)->with('success', 'Avaliação registrada!');
    }
}