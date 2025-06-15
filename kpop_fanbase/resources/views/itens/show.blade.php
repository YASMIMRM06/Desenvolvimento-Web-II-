@extends('layouts.app', ['title' => 'Detalhes do Item'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-info-circle"></i> Detalhes do Item</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                
                <h4>{{ $item->nome }}</h4>
                <p><strong>Tipo:</strong> {{ ucfirst($item->tipo) }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($item->estado) }}</p>
                <p><strong>Disponível para troca:</strong> {!! $item->disponivel_para_troca ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-secondary">Não</span>' !!}</p>
                <p><strong>Data de Cadastro:</strong> {{ $item->created_at->format('d/m/Y') }}</p>
                
                @if($item->descricao)
                <hr>
                <h5>Descrição</h5>
                <p>{{ $item->descricao }}</p>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('itens.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <div>
                        <a href="{{ route('itens.edit', $item->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('itens.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este item?')">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0"><i class="fas fa-user"></i> Dono do Item</h3>
            </div>
            <div class="card-body text-center">
                @if($item->dono->foto_perfil)
                    <img src="{{ asset('storage/' . $item->dono->foto_perfil) }}" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; margin: 0 auto;">
                        <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                    </div>
                @endif
                <h5>{{ $item->dono->nome }}</h5>
                <p class="text-muted">Membro desde {{ $item->dono->created_at->format('d/m/Y') }}</p>
                
                @if($item->dono->perfilExtendido && $item->dono->perfilExtendido->redes_sociais)
                    <a href="{{ $item->dono->perfilExtendido->redes_sociais }}" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-external-link-alt"></i> Contatar
                    </a>
                @endif
            </div>
        </div>
        
        @if($item->trocasComoOfertante->count() > 0 || $item->trocasComoDesejado->count() > 0)
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="fas fa-exchange-alt"></i> Histórico de Trocas</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($item->trocasComoOfertante as $troca)
                    <li class="list-group-item">
                        <strong>Oferecido por:</strong> {{ $troca->ofertante->nome }}<br>
                        <strong>Item desejado:</strong> {{ $troca->itemDesejado->nome }}<br>
                        <strong>Status:</strong> <span class="badge bg-{{ $troca->status == 'aceito' ? 'success' : ($troca->status == 'pendente' ? 'warning text-dark' : ($troca->status == 'recusado' ? 'danger' : 'secondary')) }}">
                            {{ ucfirst($troca->status) }}
                        </span>
                    </li>
                    @endforeach
                    
                    @foreach($item->trocasComoDesejado as $troca)
                    <li class="list-group-item">
                        <strong>Recebido de:</strong> {{ $troca->receptor->nome }}<br>
                        <strong>Item oferecido:</strong> {{ $troca->itemOfertante->nome }}<br>
                        <strong>Status:</strong> <span class="badge bg-{{ $troca->status == 'aceito' ? 'success' : ($troca->status == 'pendente' ? 'warning text-dark' : ($troca->status == 'recusado' ? 'danger' : 'secondary')) }}">
                            {{ ucfirst($troca->status) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection