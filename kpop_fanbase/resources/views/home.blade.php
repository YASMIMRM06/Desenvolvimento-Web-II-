@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Grupos Favoritos</h5>
                <p class="card-text">{{ $favoriteGroupsCount ?? 0 }} grupos</p>
                <a href="{{ route('groups.index') }}" class="text-white">Ver todos</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Próximos Eventos</h5>
                <p class="card-text">{{ $upcomingEventsCount ?? 0 }} eventos</p>
                <a href="{{ route('events.index') }}" class="text-white">Ver agenda</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Itens para Troca</h5>
                <p class="card-text">{{ $availableTradesCount ?? 0 }} itens</p>
                <a href="{{ route('trades.index') }}" class="text-white">Explorar</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Recomendações de Músicas</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($recommendedMusics as $music)
                        @include('components.music-card', ['music' => $music])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Suas Conquistas</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($achievements as $achievement)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $achievement->name }}
                            <span class="badge bg-primary rounded-pill">{{ $achievement->progress }}%</span>
                        </li>
                    @empty
                        <li class="list-group-item">Nenhuma conquista ainda</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection