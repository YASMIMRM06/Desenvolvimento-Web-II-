@extends('layouts.app')

@section('title', 'Grupos de K-POP')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Grupos de K-POP</h1>
        @can('create', App\Models\Group::class)
            <a href="{{ route('groups.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Grupo
            </a>
        @endcan
    </div>

    <div class="row">
        @foreach($groups as $group)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $group->photo }}" class="card-img-top" alt="{{ $group->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $group->name }}</h5>
                        <p class="card-text">
                            <strong>Empresa:</strong> {{ $group->company }}<br>
                            <strong>Debut:</strong> {{ $group->debut_date->format('d/m/Y') }}<br>
                            <strong>Músicas:</strong> {{ $group->musics_count }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('groups.show', $group->id) }}" class="btn btn-primary btn-sm">
                            Ver Detalhes
                        </a>
                        @can('update', $group)
                            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-secondary btn-sm">
                                Editar
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $groups->links() }}
    </div>
</div>
@endsection