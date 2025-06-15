@extends('layouts.app', ['title' => 'Criar Evento'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-calendar-plus"></i> Criar Novo Evento</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('eventos.store') }}">
                    @csrf
                    @include('eventos._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Criar Evento</button>
                        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection