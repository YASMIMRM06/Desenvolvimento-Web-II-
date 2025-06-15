@extends('layouts.app', ['title' => 'Editar Item'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-edit"></i> Editar Item: {{ $item->nome }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('itens.update', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('itens._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Atualizar Item</button>
                        <a href="{{ route('itens.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection