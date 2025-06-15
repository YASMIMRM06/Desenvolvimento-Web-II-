@extends('layouts.app', ['title' => 'Editar Música'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-music"></i> Editar Música: {{ $musica->titulo }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('musicas.update', $musica->id) }}">
                    @csrf
                    @method('PUT')
                    @include('musicas._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Atualizar Música</button>
                        <a href="{{ route('musicas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection