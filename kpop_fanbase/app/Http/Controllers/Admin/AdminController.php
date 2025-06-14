<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use App\Models\Music;
use App\Models\Event;
use App\Models\Trade;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'userCount' => User::count(),
            'groupCount' => Group::count(),
            'musicCount' => Music::count(),
            'eventCount' => Event::count(),
            'tradeCount' => Trade::count(),
            'recentActivities' => \Activity::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $stats);
    }
}