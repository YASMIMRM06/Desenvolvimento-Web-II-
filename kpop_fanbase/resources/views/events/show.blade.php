@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                @if($event->photo)
                    <img src="{{ $event->photo }}" class="card-img-top" alt="{{ $event->name }}" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h1 class="card-title">{{ $event->name }}</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-{{ $event->status === 'canceled' ? 'danger' : ($event->is_past ? 'secondary' : 'success') }}">
                                {{ ucfirst($event->status) }}
                            </span>
                            @if($event->group)
                                <span class="badge bg-primary">
                                    {{ $event->group->name }}
                                </span>
                            @endif
                        </div>
                        
                        @can('update', $event)
                            <div>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            </div>
                        @endcan
                    </div>
                    
                    <div class="mb-4">
                        <p><i class="fas fa-calendar-alt me-2"></i> {{ $event->date_event->format('d/m/Y H:i') }}</p>
                        <p><i class="fas fa-map-marker-alt me-2"></i> {{ $event->location }}</p>
                        <p><i class="fas fa-users me-2"></i> {{ $event->participants_count }} / {{ $event->capacity }} participantes</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>Descrição</h4>
                        <p>{{ $event->description ?? 'Nenhuma descrição disponível.' }}</p>
                    </div>
                    
                    @if($event->youtube_url)
                        <div class="mb-4">
                            <h4>Vídeo Relacionado</h4>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $event->youtube_id }}" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
                
                @auth
                    <div class="card-footer">
                        @if($event->status !== 'canceled' && !$event->is_past)
                            @if($isParticipating)
                                <form method="POST" action="{{ route('events.participate.cancel', $event->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Cancelar Participação</button>
                                </form>
                            @elseif(!$event->is_full)
                                <form method="POST" action="{{ route('events.participate', $event->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirmar Presença</button>
                                </form>
                            @else
                                <button class="btn btn-secondary" disabled>Evento Lotado</button>
                            @endif
                        @endif
                    </div>
                @endauth
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Participantes ({{ $event->participants_count }})</h5>
                </div>
                <div class="card-body">
                    @if($event->participants->isEmpty())
                        <p class="text-muted">Nenhum participante confirmado ainda.</p>
                    @else
                        <div class="row">
                            @foreach($event->participants as $participant)
                                <div class="col-md-3 mb-3 text-center">
                                    <img src="{{ $participant->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($participant->name).'&size=100' }}" 
                                         class="rounded-circle mb-2" width="50" height="50" alt="{{ $participant->name }}">
                                    <p class="mb-0">{{ $participant->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Criado por:</span>
                            <strong>{{ $event->creator->name }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Data de criação:</span>
                            <strong>{{ $event->created_at->format('d/m/Y') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Tipo:</span>
                            <strong>{{ ucfirst($event->type) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Preço:</span>
                            <strong>{{ $event->price ? 'R$ ' . number_format($event->price, 2) : 'Gratuito' }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
            
            @if($event->group && $event->group->upcomingEvents->count() > 1)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Outros eventos de {{ $event->group->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($event->group->upcomingEvents->where('id', '!=', $event->id)->take(3) as $relatedEvent)
                                <a href="{{ route('events.show', $relatedEvent->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $relatedEvent->name }}</h6>
                                        <small>{{ $relatedEvent->date_event->format('d/m') }}</small>
                                    </div>
                                    <small>{{ $relatedEvent->location }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection