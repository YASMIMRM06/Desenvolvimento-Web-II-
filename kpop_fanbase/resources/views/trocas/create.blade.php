@extends('layouts.app')

@section('title', 'Propor Troca')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-gift"></i> Item Desejado</h3>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $itemDesejado->foto) }}" class="img-fluid mb-3" style="max-height: 300px;">
                <h4>{{ $itemDesejado->nome }}</h4>
                <p><strong>Dono:</strong> {{ $itemDesejado->dono->nome }}</p>
                <p><strong>Tipo:</strong> {{ ucfirst($itemDesejado->tipo) }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($itemDesejado->estado) }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3><i class="fas fa-exchange-alt"></i> Propor Troca</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('trocas.store', $itemDesejado->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="item_ofertante_id" class="form-label">Meu Item para Troca</label>
                        <select class="form-select" id="item_ofertante_id" name="item_ofertante_id" required>
                            <option value="">Selecione um item</option>
                            @foreach($meusItens as $item)
                            <option value="{{ $item->id }}">{{ $item->nome }} ({{ ucfirst($item->tipo) }}, {{ ucfirst($item->estado) }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mensagem" class="form-label">Mensagem (opcional)</label>
                        <textarea class="form-control" id="mensagem" name="mensagem" rows="3" placeholder="Escreva uma mensagem para o dono do item..."></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Enviar Proposta
                        </button>
                        <a href="{{ route('itens.disponiveis') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection