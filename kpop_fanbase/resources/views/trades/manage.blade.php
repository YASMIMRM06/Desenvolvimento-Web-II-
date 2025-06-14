@extends('layouts.app')

@section('title', 'Gerenciar Trocas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Trocas</h1>
    </div>

    <ul class="nav nav-tabs mb-4" id="tradesTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#received" type="button" role="tab">Recebidas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab">Enviadas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">Concluídas</button>
        </li>
    </ul>

    <div class="tab-content" id="tradesTabContent">
        <div class="tab-pane fade show active" id="received" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    @if($receivedTrades->isEmpty())
                        <p class="text-muted">Nenhuma proposta de troca recebida.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>De</th>
                                        <th>Oferece</th>
                                        <th>Por</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receivedTrades as $trade)
                                        <tr>
                                            <td>
                                                <img src="{{ $trade->sender->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($trade->sender->name).'&size=50' }}" 
                                                     class="rounded-circle me-2" width="30" height="30" alt="{{ $trade->sender->name }}">
                                                {{ $trade->sender->name }}
                                            </td>
                                            <td>{{ $trade->offered_item }}</td>
                                            <td>{{ $trade->requested_item }}</td>
                                            <td>
                                                <span class="badge bg-{{ $trade->status === 'pending' ? 'warning' : ($trade->status === 'accepted' ? 'success' : 'secondary') }}">
                                                    {{ ucfirst($trade->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $trade->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($trade->status === 'pending')
                                                    <div class="d-flex gap-2">
                                                        <form method="POST" action="{{ route('trades.accept', $trade->id) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">Aceitar</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('trades.reject', $trade->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">Recusar</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="sent" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    @if($sentTrades->isEmpty())
                        <p class="text-muted">Nenhuma proposta de troca enviada.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Para</th>
                                        <th>Oferece</th>
                                        <th>Por</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sentTrades as $trade)
                                        <tr>
                                            <td>
                                                <img src="{{ $trade->receiver->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($trade->receiver->name).'&size=50' }}" 
                                                     class="rounded-circle me-2" width="30" height="30" alt="{{ $trade->receiver->name }}">
                                                {{ $trade->receiver->name }}
                                            </td>
                                            <td>{{ $trade->offered_item }}</td>
                                            <td>{{ $trade->requested_item }}</td>
                                            <td>
                                                <span class="badge bg-{{ $trade->status === 'pending' ? 'warning' : ($trade->status === 'accepted' ? 'success' : 'secondary') }}">
                                                    {{ ucfirst($trade->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $trade->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($trade->status === 'pending')
                                                    <form method="POST" action="{{ route('trades.cancel', $trade->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    @if($completedTrades->isEmpty())
                        <p class="text-muted">Nenhuma troca concluída.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Participantes</th>
                                        <th>Itens Trocados</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedTrades as $trade)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center mb-1">
                                                    <img src="{{ $trade->sender->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($trade->sender->name).'&size=50' }}" 
                                                         class="rounded-circle me-2" width="30" height="30" alt="{{ $trade->sender->name }}">
                                                    {{ $trade->sender->name }} (ofereceu)
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $trade->receiver->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($trade->receiver->name).'&size=50' }}" 
                                                         class="rounded-circle me-2" width="30" height="30" alt="{{ $trade->receiver->name }}">
                                                    {{ $trade->receiver->name }} (recebeu)
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-1">{{ $trade->offered_item }}</div>
                                                <div>por {{ $trade->requested_item }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $trade->status === 'accepted' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($trade->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $trade->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection