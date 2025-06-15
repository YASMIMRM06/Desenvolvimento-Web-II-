@extends('layouts.app', ['title' => 'Editar Perfil Extendido'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user-edit"></i> Editar Perfil Extendido</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('perfil-extendido.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">Biografia</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $perfil->bio ?? '') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="redes_sociais" class="form-label">Redes Sociais (URL)</label>
                        <input type="url" class="form-control @error('redes_sociais') is-invalid @enderror" id="redes_sociais" name="redes_sociais" value="{{ old('redes_sociais', $perfil->redes_sociais ?? '') }}">
                        @error('redes_sociais')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="interesses" class="form-label">Interesses</label>
                        <input type="text" class="form-control @error('interesses') is-invalid @enderror" id="interesses" name="interesses" value="{{ old('interesses', $perfil->interesses ?? '') }}">
                        @error('interesses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="genero_favorito" class="form-label">Gênero Favorito</label>
                        <select class="form-select @error('genero_favorito') is-invalid @enderror" id="genero_favorito" name="genero_favorito">
                            <option value="">Selecione um gênero</option>
                            <option value="K-POP" {{ old('genero_favorito', $perfil->genero_favorito ?? '') == 'K-POP' ? 'selected' : '' }}>K-POP</option>
                            <option value="K-HipHop" {{ old('genero_favorito', $perfil->genero_favorito ?? '') == 'K-HipHop' ? 'selected' : '' }}>K-HipHop</option>
                            <option value="K-R&B" {{ old('genero_favorito', $perfil->genero_favorito ?? '') == 'K-R&B' ? 'selected' : '' }}>K-R&B</option>
                            <option value="K-Indie" {{ old('genero_favorito', $perfil->genero_favorito ?? '') == 'K-Indie' ? 'selected' : '' }}>K-Indie</option>
                            <option value="K-Rock" {{ old('genero_favorito', $perfil->genero_favorito ?? '') == 'K-Rock' ? 'selected' : '' }}>K-Rock</option>
                        </select>
                        @error('genero_favorito')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection