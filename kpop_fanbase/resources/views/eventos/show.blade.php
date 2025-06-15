@extends('layouts.app')

@section('title', $evento->nome)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title">{{ $evento->nome }}</h1>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><i class="fas fa-calendar-alt"></i> <strong>Data:</strong> {{ $evento->data_evento->format('d/m/Y H:i') }}</p>
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Local:</strong> {{ $evento->localizacao }}</p>
                        <p><i class="fas fa-users"></i> <strong>Capacidade:</strong> {{ $evento->participantes->count() }}/{{ $evento->capacidade }}</p>
                        <p><i class="fas fa-user"></i> <strong>Criador:</strong> {{ $evento->criador->nome }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="fas fa-info-circle"></i> <strong>Status:</strong> 
                            <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : ($evento->status == 'cancelado' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($evento->status) }}
                            </span>
                        </p>
                        <p><i class="fas fa-clock"></i> <strong>Criado em:</strong> {{ $evento->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <hr>
                
                <h3>Descrição</h3>
                <p class="card-text">{{ $evento->descricao }}</p>
                
                @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->id == $evento->criador_id))
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-warning">Editar</a>
                    @if($evento->status == 'ativo')
                    <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja cancelar este evento?')">Cancelar</button>
                    </form>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-users"></i> Participantes</h3>
            </div>
            <div class="card-body">
                @if($evento->participantes->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Status</th>
                                @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->id == $evento->criador_id))
                                <th>Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evento->participantes as $participante)
                            <tr>
                                <td>{{ $participante->nome }}</td>
                                <td>
                                    @if($participante->pivot->confirmado)
                                        <span class="badge bg-success">Confirmado</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    @endif
                                </td>
                                @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->id == $evento->criador_id))
                                <td>
                                    <form action="{{ route('eventos.cancelar', $evento->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $participante->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    Nenhum participante confirmado ainda.
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3><i class="fas fa-user-check"></i> Minha Participação</h3>
            </div>
            <div class="card-body text-center">
                @auth
                    @if($estaParticipando)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Você está participando deste evento!
                        </div>
                        <form action="{{ route('eventos.cancelar', $evento->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cancelar Participação</button>
                        </form>
                    @else
                        @if($evento->estaLotado())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> Este evento está lotado!
                            </div>
                        @elseif($evento->status != 'ativo')
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Este evento não está mais ativo.
                            </div>
                        @else
                            <form action="{{ route('eventos.participar', $evento->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Confirmar Presença</button>
                            </form>
                        @endif
                    @endif
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}">Faça login</a> para participar deste evento.
                    </div>
                @endauth
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3><i class="fas fa-calendar-week"></i> Próximos Eventos</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($proximosEventos as $proximoEvento)
                    <li class="list-group-item">
                        <a href="{{ route('eventos.show', $proximoEvento->id) }}">{{ $proximoEvento->nome }}</a>
                        <br>
                        <small><i class="fas fa-clock"></i> {{ $proximoEvento->data_evento->format('d/m/Y H:i') }}</small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection