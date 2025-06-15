@extends('layouts.app', ['title' => 'Minha Coleção'])

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-collection"></i> Minha Coleção</h3>
            <div>
                <a href="{{ route('itens.create') }}" class="btn btn-light me-2">
                    <i class="fas fa-plus"></i> Adicionar Item
                </a>
                <a href="{{ route('itens.disponiveis') }}" class="btn btn-light">
                    <i class="fas fa-exchange-alt"></i> Itens para Troca
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($itens->count() > 0)
        <div class="row">
            @foreach($itens as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->nome }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nome }}</h5>
                        <p class="card-text">
                            <strong>Tipo:</strong> {{ ucfirst($item->tipo) }}<br>
                            <strong>Estado:</strong> {{ ucfirst($item->estado) }}<br>
                            <strong>Disponível para troca:</strong> 
                            {!! $item->disponivel_para_troca ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-secondary">Não</span>' !!}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('itens.show', $item->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Detalhes
                        </a>
                        <a href="{{ route('itens.edit', $item->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $itens->links() }}
        @else
        <div class="alert alert-info">
            Você ainda não possui itens em sua coleção. <a href="{{ route('itens.create') }}">Adicione seu primeiro item</a>!
        </div>
        @endif
    </div>
</div>
@endsection