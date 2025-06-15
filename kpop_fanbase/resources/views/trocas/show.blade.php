@extends('layouts.app', ['title' => 'Detalhes da Troca'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-exchange-alt"></i> Detalhes da Troca</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Item Oferecido</h5>
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $troca->itemOfertante->foto) }}" class="img-fluid mb-2" style="max-height: 150px;">
                                <h6>{{ $troca->itemOfertante->nome }}</h6>
                                <p><small>Dono: {{ $troca->ofertante->nome }}</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Item Desejado</h5>
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $troca->itemDesejado->foto) }}" class="img-fluid mb-2" style="max-height: 150px;">
                                <h6>{{ $troca->itemDesejado->nome }}</h6>
                                <p><small>Dono: {{ $troca->receptor->nome }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h5>Status</h5>
                    <p>
                        <span class="badge bg-{{ $troca->status == 'aceito' ? 'success' : ($troca->status == 'pendente' ? 'warning text-dark' : ($troca->status == 'recusado' ? 'danger' : 'secondary')) }}">
                            {{ ucfirst($troca->status) }}
                        </span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <h5>Data da Proposta</h5>
                    <p>{{ $troca->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($troca->data_conclusao)
                <div class="mb-3">
                    <h5>Data da Conclusão</h5>
                    <p>{{ $troca->data_conclusao->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                
                @if($troca->mensagem)
                <div class="mb-3">
                    <h5>Mensagem</h5>
                    <p>{{ $troca->mensagem }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('trocas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                
                @if($troca->status == 'pendente')
                    @if(Auth::id() == $troca->user_receptor_id)
                        <form action="{{ route('trocas.aceitar', $troca->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja aceitar esta troca?')">
                                <i class="fas fa-check"></i> Aceitar Troca
                            </button>
                        </form>
                        <form action="{{ route('trocas.recusar', $troca->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja recusar esta troca?')">
                                <i class="fas fa-times"></i> Recusar Troca
                            </button>
                        </form>
                    @else
                        <form action="{{ route('trocas.cancelar', $troca->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja cancelar esta troca?')">
                                <i class="fas fa-times"></i> Cancelar Troca
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="fas fa-user"></i> Informações do {{
                    Auth::id() == $troca->user_ofertante_id ? 'Receptor' : 'Ofertante'
                }}</h3>
            </div>
            <div class="card-body text-center">
                @php
                    $usuario = Auth::id() == $troca->user_ofertante_id ? $troca->receptor : $troca->ofertante;
                @endphp
                
                @if($usuario->foto_perfil)
                    <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; margin: 0 auto;">
                        <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                    </div>
                @endif
                
                <h5>{{ $usuario->nome }}</h5>
                <p class="text-muted">Membro desde {{ $usuario->created_at->format('d/m/Y') }}</p>
                
                @if($usuario->perfilExtendido && $usuario->perfilExtendido->redes_sociais)
                    <a href="{{ $usuario->perfilExtendido->redes_sociais }}" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-external-link-alt"></i> Contatar
                    </a>
                @endif
                
                <hr>
                
                <h5 class="mt-3">Outros Itens Disponíveis</h5>
                @php
                    $outrosItens = $usuario->itensColecionaveis()
                        ->where('disponivel_para_troca', true)
                        ->where('id', '!=', Auth::id() == $troca->user_ofertante_id ? $troca->item_desejado_id : $troca->item_ofertante_id)
                        ->take(3)
                        ->get();
                @endphp
                
                @if($outrosItens->count() > 0)
                    <div class="row mt-3">
                        @foreach($outrosItens as $item)
                        <div class="col-md-4 mb-2">
                            <div class="card">
                                <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" style="height: 80px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-0">{{ Str::limit($item->nome, 10) }}</h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('itens.disponiveis') }}?user_id={{ $usuario->id }}" class="btn btn-sm btn-primary mt-2">
                        Ver Todos
                    </a>
                @else
                    <p class="text-muted">Nenhum outro item disponível para troca.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection