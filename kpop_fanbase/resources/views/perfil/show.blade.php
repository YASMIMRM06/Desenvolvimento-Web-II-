@extends('layouts.app', ['title' => 'Meu Perfil'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user-circle"></i> Meu Perfil</h3>
            </div>
            <div class="card-body text-center">
                @if(Auth::user()->foto_perfil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                        <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <h4>{{ Auth::user()->nome }}</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <p>
                    <span class="badge bg-{{ Auth::user()->tipo == 'admin' ? 'danger' : (Auth::user()->tipo == 'gerente' ? 'warning text-dark' : 'primary') }}">
                        {{ ucfirst(Auth::user()->tipo) }}
                    </span>
                </p>
                <p><i class="fas fa-calendar-alt"></i> Membro desde {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
            </div>
        </div>
        
        @if(Auth::user()->perfilExtendido)
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0"><i class="fas fa-info-circle"></i> Informações Adicionais</h3>
            </div>
            <div class="card-body">
                @if(Auth::user()->perfilExtendido->bio)
                    <h5>Biografia</h5>
                    <p>{{ Auth::user()->perfilExtendido->bio }}</p>
                @endif
                
                @if(Auth::user()->perfilExtendido->redes_sociais)
                    <h5>Redes Sociais</h5>
                    <p><a href="{{ Auth::user()->perfilExtendido->redes_sociais }}" target="_blank">{{ Auth::user()->perfilExtendido->redes_sociais }}</a></p>
                @endif
                
                @if(Auth::user()->perfilExtendido->interesses)
                    <h5>Interesses</h5>
                    <p>{{ Auth::user()->perfilExtendido->interesses }}</p>
                @endif
                
                @if(Auth::user()->perfilExtendido->genero_favorito)
                    <h5>Gênero Favorito</h5>
                    <p>{{ Auth::user()->perfilExtendido->genero_favorito }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="fas fa-music"></i> Minhas Avaliações Recentes</h3>
            </div>
            <div class="card-body">
                @if(Auth::user()->musicasAvaliadas->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Música</th>
                                    <th>Grupo</th>
                                    <th>Avaliação</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->musicasAvaliadas->sortByDesc('pivot.created_at')->take(5) as $avaliacao)
                                <tr>
                                    <td><a href="{{ route('musicas.show', $avaliacao->id) }}">{{ $avaliacao->titulo }}</a></td>
                                    <td>{{ $avaliacao->grupo->nome }}</td>
                                    <td>
                                        <div class="star-rating" data-rating="{{ $avaliacao->pivot->nota }}">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $avaliacao->pivot->nota ? '' : '-empty' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ $avaliacao->pivot->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn btn-sm btn-primary">Ver Todas</a>
                @else
                    <div class="alert alert-info">
                        Você ainda não avaliou nenhuma música. <a href="{{ route('musicas.index') }}">Explore as músicas</a> e deixe sua avaliação!
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0"><i class="fas fa-calendar-check"></i> Meus Próximos Eventos</h3>
            </div>
            <div class="card-body">
                @if(Auth::user()->eventos->where('data_evento', '>=', now())->count() > 0)
                    <div class="list-group">
                        @foreach(Auth::user()->eventos->where('data_evento', '>=', now())->sortBy('data_evento')->take(3) as $evento)
                        <a href="{{ route('eventos.show', $evento->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $evento->nome }}</h5>
                                <small>{{ $evento->data_evento->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $evento->localizacao }}</p>
                            <small>Status: 
                                <span class="badge bg-{{ $evento->pivot->confirmado ? 'success' : 'warning text-dark' }}">
                                    {{ $evento->pivot->confirmado ? 'Confirmado' : 'Pendente' }}
                                </span>
                            </small>
                        </a>
                        @endforeach
                    </div>
                    <a href="#" class="btn btn-sm btn-primary mt-3">Ver Todos</a>
                @else
                    <div class="alert alert-info">
                        Você não está participando de nenhum evento em breve. <a href="{{ route('eventos.index') }}">Confira os próximos eventos</a> e participe!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .star-rating {
        color: #ffc107;
    }
</style>
@endpush