@extends('layouts.app')

@section('title', 'Músicas de K-POP')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Músicas de K-POP</h1>
        @can('create', App\Models\Music::class)
            <a href="{{ route('musics.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nova Música
            </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('musics.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Título da música ou grupo...">
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
                    <a href="{{ route('musics.index') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Grupo</th>
                    <th>Duração</th>
                    <th>Avaliação Média</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($musics as $music)
                    <tr>
                        <td>{{ $music->title }}</td>
                        <td>{{ $music->group->name }}</td>
                        <td>{{ $music->duration }}</td>
                        <td>
                            @if($music->average_rating)
                                @include('components.rating-stars', ['rating' => $music->average_rating])
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('musics.show', $music->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('update', $music)
                                <a href="{{ route('musics.edit', $music->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma música encontrada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $musics->appends(request()->query())->links() }}
    </div>
</div>
@endsection
