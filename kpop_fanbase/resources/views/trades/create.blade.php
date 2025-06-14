@extends('layouts.app')

@section('title', 'Propor Troca')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Propor Troca</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('trades.store') }}">
                        @csrf
                        
                        @if(isset($requestedItem))
                            <input type="hidden" name="requested_item_id" value="{{ $requestedItem->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Item que você deseja</label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <img src="{{ $requestedItem->photo }}" class="rounded me-3" width="80" height="80" style="object-fit: cover;">
                                            <div>
                                                <h5 class="mb-1">{{ $requestedItem->name }}</h5>
                                                <p class="mb-1"><small>Grupo: {{ $requestedItem->group->name }}</small></p>
                                                <p class="mb-1"><small>Dono: {{ $requestedItem->owner->name }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="requested_item_id" class="form-label">Item que você deseja</label>
                                <select class="form-control @error('requested_item_id') is-invalid @enderror" id="requested_item_id" name="requested_item_id" required>
                                    <option value="">Selecione o item desejado...</option>
                                    @foreach($availableItems as $item)
                                        <option value="{{ $item->id }}" {{ old('requested_item_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} ({{ $item->group->name }}) - {{ $item->owner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('requested_item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="offered_item_id" class="form-label">Seu item para troca</label>
                            <select class="form-control @error('offered_item_id') is-invalid @enderror" id="offered_item_id" name="offered_item_id" required>
                                <option value="">Selecione seu item...</option>
                                @foreach($myItems as $item)
                                    <option value="{{ $item->id }}" {{ old('offered_item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->group->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('offered_item_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensagem para o dono do item (opcional)</label>
                            <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Enviar Proposta</button>
                            <a href="{{ route('trades.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection