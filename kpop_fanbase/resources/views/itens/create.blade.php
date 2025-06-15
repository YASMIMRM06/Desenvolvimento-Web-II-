@extends('layouts.app', ['title' => 'Adicionar Item'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Adicionar Item à Coleção</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('itens.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('itens._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Adicionar Item</button>
                        <a href="{{ route('itens.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection