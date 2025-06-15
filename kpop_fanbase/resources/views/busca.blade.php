@extends('layouts.app', ['title' => 'Busca: ' . $termo])

@section('content')
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h2><i class="fas fa-search"></i> Resultados para: "{{ $termo }}"</h2>
    </div>
</div>

@if($grupos->count() > 0)
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h3><i class="fas fa-users"></i> Grupos</h3>
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
                        <a href="{{ route('grupos.show', $grupo->id) }}" class="btn btn-primary">Ver Grupo</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($musicas->count() > 0)
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h3><i class="fas fa-music"></i> Músicas</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Grupo</th>
                        <th>Duração</th>
                        <th>Avaliação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($musicas as $musica)
                    <tr>
                        <td>{{ $musica->titulo }}</td>
                        <td>{{ $musica->grupo->nome }}</td>
                        <td>{{ $musica->duracao_formatada }}</td>
                        <td>
                            <div class="star-rating" data-rating="{{ $musica->media_avaliacoes }}">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $musica->media_avaliacoes ? '' : '-empty' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('musicas.show', $musica->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($eventos->count() > 0)
<div class="card mb-4">
    <div class="card-header bg-warning text-dark">
        <h3><i class="fas fa-calendar-alt"></i> Eventos</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($eventos as $evento)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $evento->nome }}</h5>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $evento->localizacao }}<br>
                            <i class="fas fa-clock"></i> {{ $evento->data_evento->format('d/m/Y H:i') }}<br>
                            <i class="fas fa-users"></i> {{ $evento->participantes->count() }}/{{ $evento->capacidade }} participantes
                        </p>
                        <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-primary">Detalhes</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($grupos->count() == 0 && $musicas->count() == 0 && $eventos->count() == 0)
<div class="alert alert-warning">
    Nenhum resultado encontrado para "{{ $termo }}".
</div>
@endif
@endsection