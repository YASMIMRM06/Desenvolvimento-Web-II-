@extends('layouts.app', ['title' => 'Detalhes do Usuário'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user"></i> Perfil</h3>
            </div>
            <div class="card-body text-center">
                @if($user->foto_perfil)
                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                        <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <h4>{{ $user->nome }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <p>
                    <span class="badge bg-{{ $user->tipo == 'admin' ? 'danger' : ($user->tipo == 'gerente' ? 'warning text-dark' : 'primary') }}">
                        {{ ucfirst($user->tipo) }}
                    </span>
                </p>
                <p><i class="fas fa-calendar-alt"></i> Membro desde {{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0"><i class="fas fa-info-circle"></i> Informações</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Dados Básicos</h5>
                        <p><strong>Nome:</strong> {{ $user->nome }}</p>
                        <p><strong>E-mail:</strong> {{ $user->email }}</p>
                        <p><strong>Data de Nascimento:</strong> {{ $user->data_nascimento ? $user->data_nascimento->format('d/m/Y') : 'Não informada' }}</p>
                        <p><strong>E-mail verificado:</strong> {!! $user->email_verificado ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>' !!}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Permissões</h5>
                        @if($user->permissoes->count() > 0)
                            <ul>
                                @foreach($user->permissoes as $permissao)
                                    <li>{{ $permissao->nome }} - {{ $permissao->descricao }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Nenhuma permissão especial atribuída</p>
                        @endif
                    </div>
                </div>
                
                @if($user->perfilExtendido)
                <hr>
                <h5>Informações Adicionais</h5>
                <div class="row">
                    @if($user->perfilExtendido->bio)
                        <div class="col-md-6">
                            <p><strong>Biografia:</strong> {{ $user->perfilExtendido->bio }}</p>
                        </div>
                    @endif
                    @if($user->perfilExtendido->redes_sociais)
                        <div class="col-md-6">
                            <p><strong>Redes Sociais:</strong> <a href="{{ $user->perfilExtendido->redes_sociais }}" target="_blank">{{ $user->perfilExtendido->redes_sociais }}</a></p>
                        </div>
                    @endif
                    @if($user->perfilExtendido->interesses)
                        <div class="col-md-6">
                            <p><strong>Interesses:</strong> {{ $user->perfilExtendido->interesses }}</p>
                        </div>
                    @endif
                    @if($user->perfilExtendido->genero_favorito)
                        <div class="col-md-6">
                            <p><strong>Gênero Favorito:</strong> {{ $user->perfilExtendido->genero_favorito }}</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="fas fa-chart-bar"></i> Estatísticas</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->musicasAvaliadas->count() }}</h5>
                                <p class="card-text">Músicas Avaliadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->eventos->count() }}</h5>
                                <p class="card-text">Eventos Participados</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->itensColecionaveis->count() }}</h5>
                                <p class="card-text">Itens na Coleção</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection