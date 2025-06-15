@extends('layouts.app', ['title' => 'Verificar E-mail'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-envelope"></i> Verificar E-mail</h3>
            </div>
            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Um novo link de verificação foi enviado para o seu e-mail.
                    </div>
                @endif
                <p>Antes de continuar, por favor verifique seu e-mail com o link de confirmação.</p>
                <p>Se você não recebeu o e-mail:</p>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Clique aqui para reenviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection