@extends('layouts.app')

@section('title', 'Gerenciar Votações')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Votações</h1>
        <a href="{{ route('admin.votings.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nova Votação
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.votings.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Título da votação...">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativa</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Encerrada</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                    <a href="{{ route('admin.votings.index') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($votings as $voting)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $voting->title }}</h5>
                        <span class="badge bg-{{ $voting->status === 'active' ? 'success' : ($voting->status === 'closed' ? 'secondary' : 'warning') }}">
                            {{ ucfirst($voting->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $voting->description }}</p>
                        
                        <div class="mb-3">
                            <strong>Período:</strong> 
                            {{ $voting->start_date->format('d/m/Y H:i') }} - 
                            {{ $voting->end_date->format('d/m/Y H:i') }}
                        </div>
                        
                        @if($voting->status !== 'pending')
                            <div class="mb-3">
                                <strong>Resultado Parcial:</strong>
                                <ul class="list-group mt-2">
                                    @foreach($voting->options as $option)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $option->name }}
                                            <span class="badge bg-primary rounded-pill">{{ $option->votes_count }} votos</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.votings.show', $voting->id) }}" class="btn btn-primary btn-sm">
                                Detalhes
                            </a>
                            
                            @if($voting->status === 'pending')
                                <form method="POST" action="{{ route('admin.votings.start', $voting->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Iniciar</button>
                                </form>
                            @elseif($voting->status === 'active')
                                <form method="POST" action="{{ route('admin.votings.close', $voting->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Encerrar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhuma votação encontrada.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $votings->appends(request()->query())->links() }}
    </div>
</div>
@endsection