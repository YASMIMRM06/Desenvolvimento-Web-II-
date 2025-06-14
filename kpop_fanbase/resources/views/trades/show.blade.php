@extends('layouts.app')

@section('title', $item->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <img src="{{ $item->photo }}" class="card-img-top" alt="{{ $item->name }}">
                <div class="card-body">
                    <h2 class="card-title">{{ $item->name }}</h2>
                    <p class="card-text">
                        <strong>Grupo:</strong> <a href="{{ route('groups.show', $item->group_id) }}">{{ $item->group->name }}</a><br>
                        <strong>Tipo:</strong> {{ ucfirst($item->type) }}<br>
                        <strong>Condição:</strong> {{ ucfirst($item->condition) }}<br>
                        <strong>Data de Aquisição:</strong> {{ $item->acquired_date->format('d/m/Y') }}
                    </p>
                    <p class="card-text">{{ $item->description }}</p>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <img src="{{ $item->owner->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($item->owner->name).'&size=50' }}" 
                                 class="rounded-circle me-2" width="30" height="30" alt="{{ $item->owner->name }}">
                            <span>{{ $item->owner->name }}</span>
                        </div>
                        <span class="badge bg-{{ $item->status === 'available' ? 'success' : 'secondary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ofertas de Troca</h5>
                </div>
                <div class="card-body">
                    @if($item->tradeOffers->isEmpty())
                        <p class="text-muted">Nenhuma oferta de troca ainda.</p>
                    @else
                        <div class="list-group">
                            @foreach($item->tradeOffers as $offer)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <img src="{{ $offer->sender->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($offer->sender->name).'&size=50' }}" 
                                                 class="rounded-circle me-2" width="30" height="30" alt="{{ $offer->sender->name }}">
                                            <strong>{{ $offer->sender->name }}</strong>
                                        </div>
                                        <span class="badge bg-{{ $offer->status === 'pending' ? 'warning' : ($offer->status === 'accepted' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1"><strong>Oferece:</strong> {{ $offer->offered_item }}</p>
                                    <p class="mb-1"><strong>Por:</strong> {{ $offer->requested_item }}</p>
                                    <small class="text-muted">Enviado em: {{ $offer->created_at->format('d/m/Y H:i') }}</small>
                                    
                                    @if($item->owner_id === auth()->id() && $offer->status === 'pending')
                                        <div class="mt-2 d-flex gap-2">
                                            <form method="POST" action="{{ route('trades.accept', $offer->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Aceitar</button>
                                            </form>
                                            <form method="POST" action="{{ route('trades.reject', $offer->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Recusar</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            @if(auth()->id() !== $item->owner_id && $item->status === 'available')
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Propor Troca</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('trades.store') }}">
                            @csrf
                            <input type="hidden" name="requested_item_id" value="{{ $item->id }}">
                            
                            <div class="mb-3">
                                <label for="offered_item_id" class="form-label">Seu item para troca</label>
                                <select class="form-control @error('offered_item_id') is-invalid @enderror" id="offered_item_id" name="offered_item_id" required>
                                    <option value="">Selecione seu item...</option>
                                    @foreach($myItems as $myItem)
                                        <option value="{{ $myItem->id }}" {{ old('offered_item_id') == $myItem->id ? 'selected' : '' }}>
                                            {{ $myItem->name }} ({{ $myItem->group->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('offered_item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensagem (opcional)</label>
                                <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Enviar Proposta</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection