@extends('layouts.app')

@section('title', 'Eventos de K-POP')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Eventos de K-POP</h1>
        @can('create', App\Models\Event::class)
            <a href="{{ route('events.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Evento
            </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('events.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nome do evento...">
                </div>
                <div class="col-md-3">
                    <label for="group_id" class="form-label">Grupo</label>
                    <select class="form-select" id="group_id" name="group_id">
                        <option value="">Todos os grupos</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                        <option value="past" {{ request('status') === 'past' ? 'selected' : '' }}>Passados</option>
                        <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Cancelados</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($events as $event)
            @include('components.event-card', ['event' => $event])
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhum evento encontrado.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $events->appends(request()->query())->links() }}
    </div>
</div>
@endsection