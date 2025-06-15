@extends('layouts.app', ['title' => 'Adicionar Grupo'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-users"></i> Adicionar Novo Grupo</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('grupos.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('grupos._form')
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Cadastrar Grupo</button>
                        <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection