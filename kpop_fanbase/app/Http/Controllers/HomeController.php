<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\Music;
use App\Models\Trade;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'favoriteGroupsCount' => auth()->user()->favoriteGroups()->count(),
            'upcomingEventsCount' => Event::upcoming()->count(),
            'availableTradesCount' => Trade::available()->count(),
            'recommendedMusics' => Music::with('group')
                ->withAvg('ratings', 'rating')
                ->orderBy('ratings_avg_rating', 'desc')
                ->take(5)
                ->get(),
            'achievements' => auth()->user()->achievements()->get()
        ];

        return view('home', $data);
    }
}