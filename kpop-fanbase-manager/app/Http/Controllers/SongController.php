<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateSongRequest;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::with('group')->orderBy('release_date', 'desc')->paginate(10);
        return view('songs.index', compact('songs'));
    }

    public function show(Song $song)
    {
        $song->load('group', 'ratings.user');
        return view('songs.show', compact('song'));
    }

    public function rate(RateSongRequest $request, Song $song)
    {
        $existingRating = $song->ratings()->where('user_id', auth()->id())->first();

        if ($existingRating) {
            return back()->with('error', 'You have already rated this song!');
        }

        $song->ratings()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $song->updateAverageRating();

        return back()->with('success', 'Thank you for your rating!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $songs = Song::where('title', 'like', "%$query%")
                    ->orWhereHas('group', function($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->paginate(10);

        return view('songs.search', compact('songs', 'query'));
    }
}