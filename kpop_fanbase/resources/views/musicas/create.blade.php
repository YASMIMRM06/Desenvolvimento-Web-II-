@extends('layouts.app', ['title' => 'Adicionar Música'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-music"></i> Adicionar Nova Música</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('musicas.store') }}">
                    @csrf
                    @include('musicas._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Cadastrar Música</button>
                        <a href="{{ route('musicas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection