@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-fire"></i> Grupos em Destaque</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($grupos as $grupo)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $grupo->foto) }}" class="card-img-top" alt="{{ $grupo->nome }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $grupo->nome }}</h5>
                                <p class="card-text">{{ $grupo->empresa_formatada }}</p>
                                <a href="{{ route('grupos.show', $grupo->id) }}" class="btn btn-sm btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3><i class="fas fa-music"></i> Novas Músicas</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($musicas as $musica)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $musica->titulo }}</strong>
                            <br>
                            <small class="text-muted">{{ $musica->grupo->nome }}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $musica->duracao_formatada }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3><i class="fas fa-calendar-alt"></i> Próximos Eventos</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($eventos as $evento)
                    <li class="list-group-item">
                        <h5>{{ $evento->nome }}</h5>
                        <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $evento->localizacao }}</p>
                        <p class="mb-1"><i class="fas fa-clock"></i> {{ $evento->data_evento->format('d/m/Y H:i') }}</p>
                        <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-sm btn-info mt-2">Detalhes</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection