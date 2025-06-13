<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:create,App\Models\Event')->only(['create', 'store']);
    }

    public function index()
    {
        $events = Event::with('creator')
                      ->where('status', 'scheduled')
                      ->orderBy('event_date')
                      ->paginate(10);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(EventRequest $request)
    {
        $event = Event::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => 'scheduled',
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        $event->load('creator', 'participants');
        return view('events.show', compact('event'));
    }

    public function participate(Request $request, Event $event)
    {
        if ($event->participants()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You are already registered for this event!');
        }

        if ($event->available_spots <= 0) {
            return back()->with('error', 'This event is already full!');
        }

        $event->participants()->attach(auth()->id(), ['status' => 'confirmed']);

        return back()->with('success', 'You have successfully registered for the event!');
    }
}