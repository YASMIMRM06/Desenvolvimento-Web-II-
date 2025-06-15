@extends('layouts.app', ['title' => 'Editar Usuário'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user-edit"></i> Editar Usuário</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('usuarios._form')
                    
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Usuário</label>
                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                            <option value="fã" {{ old('tipo', $user->tipo) == 'fã' ? 'selected' : '' }}>Fã</option>
                            <option value="gerente" {{ old('tipo', $user->tipo) == 'gerente' ? 'selected' : '' }}>Gerente</option>
                            <option value="admin" {{ old('tipo', $user->tipo) == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0"><i class="fas fa-key"></i> Permissões</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update-permissions', $user->id) }}">
                    @csrf
                    @foreach($permissoes as $permissao)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissoes[]" value="{{ $permissao->id }}" id="permissao_{{ $permissao->id }}" 
                                {{ $user->permissoes->contains($permissao->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permissao_{{ $permissao->id }}">
                                {{ $permissao->nome }} - {{ $permissao->descricao }}
                            </label>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-sm btn-primary mt-3">Atualizar Permissões</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection