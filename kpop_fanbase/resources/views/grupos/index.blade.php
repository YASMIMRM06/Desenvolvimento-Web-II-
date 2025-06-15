@extends('layouts.app', ['title' => 'Grupos de K-POP'])

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-users"></i> Grupos de K-POP</h3>
            @can('create', App\Models\Grupo::class)
            <a href="{{ route('grupos.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i> Novo Grupo
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($grupos as $grupo)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $grupo->foto) }}" class="card-img-top" alt="{{ $grupo->nome }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $grupo->nome }}</h5>
                        <p class="card-text">
                            <strong>Empresa:</strong> {{ $grupo->empresa_formatada }}<br>
                            <strong>Debut:</strong> {{ $grupo->data_debut->format('d/m/Y') }}
                        </p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('grupos.show', $grupo->id) }}" class="btn btn-primary">Ver Detalhes</a>
                            <span class="badge bg-secondary">
                                {{ $grupo->musicas->count() }} músicas
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $grupos->links() }}
    </div>
</div>
@endsection