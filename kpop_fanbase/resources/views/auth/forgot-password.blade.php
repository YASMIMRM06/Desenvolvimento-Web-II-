@extends('layouts.app')

@section('title', 'Recuperar Senha')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Recuperar Senha</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Enviar Link de Recuperação</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Voltar ao login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection