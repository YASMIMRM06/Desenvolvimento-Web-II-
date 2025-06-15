@extends('layouts.app', ['title' => 'Minhas Trocas'])

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0"><i class="fas fa-exchange-alt"></i> Minhas Trocas</h3>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs mb-4" id="trocasTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="enviadas-tab" data-bs-toggle="tab" data-bs-target="#enviadas" type="button" role="tab">
                    Propostas Enviadas
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="recebidas-tab" data-bs-toggle="tab" data-bs-target="#recebidas" type="button" role="tab">
                    Propostas Recebidas
                </button>
            </li>
        </ul>
        
        <div class="tab-content" id="trocasTabContent">
            <div class="tab-pane fade show active" id="enviadas" role="tabpanel">
                @if($trocasEnviadas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item Oferecido</th>
                                    <th>Item Desejado</th>
                                    <th>Para</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trocasEnviadas as $troca)
                                <tr>
                                    <td>{{ $troca->itemOfertante->nome }}</td>
                                    <td>{{ $troca->itemDesejado->nome }}</td>
                                    <td>{{ $troca->receptor->nome }}</td>
                                    <td>
                                        <span class="badge bg-{{ $troca->status == 'aceito' ? 'success' : ($troca->status == 'pendente' ? 'warning text-dark' : ($troca->status == 'recusado' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($troca->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $troca->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('trocas.show', $troca->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($troca->status == 'pendente')
                                        <form action="{{ route('trocas.cancelar', $troca->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja cancelar esta troca?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $trocasEnviadas->links() }}
                @else
                    <div class="alert alert-info">
                        Você ainda não enviou nenhuma proposta de troca. <a href="{{ route('itens.disponiveis') }}">Veja os itens disponíveis para troca</a>!
                    </div>
                @endif
            </div>
            
            <div class="tab-pane fade" id="recebidas" role="tabpanel">
                @if($trocasRecebidas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item Oferecido</th>
                                    <th>Item Desejado</th>
                                    <th>De</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trocasRecebidas as $troca)
                                <tr>
                                    <td>{{ $troca->itemOfertante->nome }}</td>
                                    <td>{{ $troca->itemDesejado->nome }}</td>
                                    <td>{{ $troca->ofertante->nome }}</td>
                                    <td>
                                        <span class="badge bg-{{ $troca->status == 'aceito' ? 'success' : ($troca->status == 'pendente' ? 'warning text-dark' : ($troca->status == 'recusado' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($troca->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $troca->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('trocas.show', $troca->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($troca->status == 'pendente')
                                        <form action="{{ route('trocas.aceitar', $troca->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Tem certeza que deseja aceitar esta troca?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('trocas.recusar', $troca->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja recusar esta troca?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $trocasRecebidas->links() }}
                @else
                    <div class="alert alert-info">
                        Você não tem nenhuma proposta de troca recebida.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection