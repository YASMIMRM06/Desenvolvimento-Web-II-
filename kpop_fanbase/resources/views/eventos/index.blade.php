@extends('layouts.app', ['title' => 'Eventos de K-POP'])

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-calendar-alt"></i> Eventos de K-POP</h3>
            @can('create', App\Models\Evento::class)
            <a href="{{ route('eventos.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i> Novo Evento
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($eventos as $evento)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $evento->nome }}</h5>
                            <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : ($evento->status == 'cancelado' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($evento->status) }}
                            </span>
                        </div>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $evento->localizacao }}<br>
                            <i class="fas fa-clock"></i> {{ $evento->data_evento->format('d/m/Y H:i') }}<br>
                            <i class="fas fa-users"></i> {{ $evento->participantes->count() }}/{{ $evento->capacidade }} participantes
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-primary btn-sm">Detalhes</a>
                            <small>Criado por: {{ $evento->criador->nome }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $eventos->links() }}
    </div>
</div>
@endsection