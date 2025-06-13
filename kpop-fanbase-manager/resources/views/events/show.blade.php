@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="event-detail">
    <h1>{{ $event->name }}</h1>
    <p class="meta">Organized by: {{ $event->creator->name }}</p>
    <p class="meta">Date: {{ $event->event_date->format('F j, Y \a\t g:i A') }}</p>
    <p class="meta">Location: {{ $event->location }}</p>
    <p class="meta">Status: {{ ucfirst($event->status) }}</p>
    <p class="meta">Capacity: {{ $event->participants->count() }} / {{ $event->capacity }}</p>
    
    <div class="description">
        <h3>Description</h3>
        <p>{{ $event->description }}</p>
    </div>
    
    @auth
    <div class="participation">
        @if($event->participants->contains(auth()->id()))
            <p>You are registered for this event!</p>
        @elseif($event->available_spots > 0)
            <form action="{{ route('events.participate', $event) }}" method="POST">
                @csrf
                <button type="submit">Register for Event</button>
            </form>
        @else
            <p>This event is full!</p>
        @endif
    </div>
    @endauth
    
    <div class="participants">
        <h3>Participants ({{ $event->participants->count() }})</h3>
        <ul>
            @foreach($event->participants as $participant)
            <li>{{ $participant->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection