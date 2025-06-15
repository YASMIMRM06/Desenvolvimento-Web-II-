@extends('layouts.app', ['title' => 'Acesso Negado'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card">
            <div class="card-body">
                <h1 class="display-1 text-danger">403</h1>
                <h2 class="mb-4">Acesso Negado</h2>
                <p class="lead">Você não tem permissão para acessar esta página.</p>
                <a href="{{ url()->previous() }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Página Inicial
                </a>
            </div>
        </div>
    </div>
</div>
@endsection