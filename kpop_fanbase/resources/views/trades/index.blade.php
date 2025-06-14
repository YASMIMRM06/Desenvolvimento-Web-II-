@extends('layouts.app')

@section('title', 'Itens para Troca')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Itens para Troca</h1>
        <a href="{{ route('trades.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Propor Troca
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('trades.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nome do item...">
                </div>
                <div class="col-md-4">
                    <label for="group_id" class="form-label">Grupo</label>
                    <select class="form-select" id="group_id" name="group_id">
                        <option value="">Todos os grupos</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                    <a href="{{ route('trades.index') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($items as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $item->photo }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">
                            <strong>Grupo:</strong> {{ $item->group->name }}<br>
                            <strong>Tipo:</strong> {{ ucfirst($item->type) }}<br>
                            <strong>Dono:</strong> {{ $item->owner->name }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('trades.show', $item->id) }}" class="btn btn-primary btn-sm">
                            Ver Detalhes
                        </a>
                        @if(auth()->id() !== $item->owner_id)
                            <a href="{{ route('trades.create', ['item_id' => $item->id]) }}" class="btn btn-success btn-sm">
                                Propor Troca
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhum item disponível para troca.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $items->appends(request()->query())->links() }}
    </div>
</div>
@endsection