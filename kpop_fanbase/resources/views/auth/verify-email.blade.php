@extends('layouts.app')

@section('title', 'Verificar Email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Verificação de Email</h4>
            </div>
            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Um novo link de verificação foi enviado para seu email.
                    </div>
                @endif

                <p>Antes de continuar, por favor verifique seu email com o link de confirmação.</p>
                <p>Se você não recebeu o email,</p>
                
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-info">Clique aqui para solicitar outro</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection