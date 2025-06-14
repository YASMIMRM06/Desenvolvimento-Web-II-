@props(['event'])

<div class="col-md-6 mb-4">
    <div class="card h-100">
        @if($event->photo)
            <img src="{{ $event->photo }}" class="card-img-top" alt="{{ $event->name }}" style="height: 180px; object-fit: cover;">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $event->name }}</h5>
            <p class="card-text">
                <i class="fas fa-calendar-alt me-2"></i> {{ $event->date_event->format('d/m/Y H:i') }}<br>
                <i class="fas fa-map-marker-alt me-2"></i> {{ $event->location }}<br>
                <i class="fas fa-users me-2"></i> {{ $event->participants_count }} / {{ $event->capacity }} participantes
            </p>
            <span class="badge bg-{{ $event->status === 'canceled' ? 'danger' : ($event->is_past ? 'secondary' : 'success') }}">
                {{ ucfirst($event->status) }}
            </span>
            @if($event->group)
                <span class="badge bg-primary">{{ $event->group->name }}</span>
            @endif
        </div>
        <div class="card-footer bg-white">
            <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">
                Detalhes
            </a>
            @auth
                @if($event->status !== 'canceled' && !$event->is_past)
                    @if($event->isParticipating(auth()->id()))
                        <span class="badge bg-success float-end mt-1">Você está participando</span>
                    @elseif(!$event->is_full)
                        <a href="{{ route('events.participate', $event->id) }}" class="btn btn-success btn-sm float-end">
                            Participar
                        </a>
                    @else
                        <span class="badge bg-danger float-end mt-1">Lotado</span>
                    @endif
                @endif
            @endauth
        </div>
    </div>
</div>