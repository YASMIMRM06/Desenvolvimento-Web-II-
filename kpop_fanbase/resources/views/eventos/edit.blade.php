@extends('layouts.app', ['title' => 'Editar Evento'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-calendar-edit"></i> Editar Evento: {{ $evento->nome }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('eventos.update', $evento->id) }}">
                    @csrf
                    @method('PUT')
                    @include('eventos._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Atualizar Evento</button>
                        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection