<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['group', 'participants'])
            ->filter(request(['search', 'group_id', 'status']))
            ->latest()
            ->paginate(10);

        $groups = Group::all();

        return view('events.index', compact('events', 'groups'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('events.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'nullable|exists:groups,id',
            'type' => 'required|in:show,meet,fanmeeting,other',
            'date_event' => 'required|date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
            'youtube_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('event-photos');
        }

        $validated['creator_id'] = auth()->id();
        $validated['status'] = 'scheduled';

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    public function show(Event $event)
    {
        $event->load(['group', 'creator', 'participants']);
        $isParticipating = auth()->check() 
            ? $event->participants()->where('user_id', auth()->id())->exists()
            : false;

        return view('events.show', compact('event', 'isParticipating'));
    }

    public function edit(Event $event)
    {
        $groups = Group::all();
        return view('events.edit', compact('event', 'groups'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'nullable|exists:groups,id',
            'type' => 'required|in:show,meet,fanmeeting,other',
            'date_event' => 'required|date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
            'youtube_url' => 'nullable|url',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,canceled,completed',
            'remove_photo' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($event->photo) {
                Storage::delete($event->photo);
            }
            $validated['photo'] = $request->file('photo')->store('event-photos');
        } elseif ($request->remove_photo && $event->photo) {
            Storage::delete($event->photo);
            $validated['photo'] = null;
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        if ($event->photo) {
            Storage::delete($event->photo);
        }
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento removido com sucesso!');
    }

    public function participate(Request $request, Event $event)
    {
        if ($event->is_full) {
            return back()->with('error', 'Este evento está lotado!');
        }

        if ($event->participants()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Você já está participando deste evento!');
        }

        $event->participants()->attach(auth()->id(), [
            'payment_method' => $request->payment_method,
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Participação confirmada!');
    }

    public function cancelParticipation(Event $event)
    {
        $event->participants()->detach(auth()->id());
        return back()->with('success', 'Participação cancelada!');
    }
}