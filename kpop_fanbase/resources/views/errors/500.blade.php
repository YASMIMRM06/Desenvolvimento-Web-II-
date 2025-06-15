@extends('layouts.app', ['title' => 'Erro no Servidor'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card">
            <div class="card-body">
                <h1 class="display-1 text-danger">500</h1>
                <h2 class="mb-4">Erro no Servidor</h2>
                <p class="lead">Ocorreu um erro interno no servidor. Por favor, tente novamente mais tarde.</p>
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