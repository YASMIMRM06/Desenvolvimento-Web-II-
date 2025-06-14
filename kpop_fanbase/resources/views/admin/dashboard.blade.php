@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="container">
    <h1 class="mb-4">Painel Administrativo</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text display-6">{{ $userCount }}</p>
                    <a href="{{ route('admin.users') }}" class="text-white">Ver todos</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Grupos</h5>
                    <p class="card-text display-6">{{ $groupCount }}</p>
                    <a href="{{ route('groups.index') }}" class="text-white">Ver todos</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Músicas</h5>
                    <p class="card-text display-6">{{ $musicCount }}</p>
                    <a href="{{ route('musics.index') }}" class="text-white">Ver todas</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Eventos</h5>
                    <p class="card-text display-6">{{ $eventCount }}</p>
                    <a href="{{ route('events.index') }}" class="text-white">Ver todos</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Atividade Recente</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($recentActivities as $activity)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $activity->description }}</h6>
                                    <small>{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                <small>Por: {{ $activity->causer->name ?? 'Sistema' }}</small>
                            </div>
                        @empty
                            <div class="list-group-item">Nenhuma atividade recente</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Estatísticas</h5>
                </div>
                <div class="card-body">
                    <canvas id="statsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Usuários', 'Grupos', 'Músicas', 'Eventos', 'Trocas'],
                datasets: [{
                    label: 'Registros',
                    data: [
                        {{ $userCount }}, 
                        {{ $groupCount }}, 
                        {{ $musicCount }}, 
                        {{ $eventCount }}, 
                        {{ $tradeCount }}
                    ],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.7)',
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(13, 202, 240, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgba(13, 202, 240, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection