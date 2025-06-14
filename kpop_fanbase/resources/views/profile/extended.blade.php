@extends('layouts.app')

@section('title', 'Dados Adicionais')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Dados Adicionais do Perfil</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.extended.store') }}">
                    @csrf
                    
                    <div class="row mb-3">
                        <label for="birth_date" class="col-md-4 col-form-label text-md-end">Data de Nascimento</label>
                        <div class="col-md-6">
                            <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', Auth::user()->extendedProfile->birth_date ?? '') }}">
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">Gênero</label>
                        <div class="col-md-6">
                            <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender">
                                <option value="">Selecione...</option>
                                <option value="male" {{ old('gender', Auth::user()->extendedProfile->gender ?? '') === 'male' ? 'selected' : '' }}>Masculino</option>
                                <option value="female" {{ old('gender', Auth::user()->extendedProfile->gender ?? '') === 'female' ? 'selected' : '' }}>Feminino</option>
                                <option value="other" {{ old('gender', Auth::user()->extendedProfile->gender ?? '') === 'other' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="country" class="col-md-4 col-form-label text-md-end">País</label>
                        <div class="col-md-6">
                            <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country', Auth::user()->extendedProfile->country ?? '') }}">
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="city" class="col-md-4 col-form-label text-md-end">Cidade</label>
                        <div class="col-md-6">
                            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', Auth::user()->extendedProfile->city ?? '') }}">
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="bio" class="col-md-4 col-form-label text-md-end">Biografia</label>
                        <div class="col-md-6">
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="3">{{ old('bio', Auth::user()->extendedProfile->bio ?? '') }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="favorite_group" class="col-md-4 col-form-label text-md-end">Grupo Favorito</label>
                        <div class="col-md-6">
                            <input id="favorite_group" type="text" class="form-control @error('favorite_group') is-invalid @enderror" name="favorite_group" value="{{ old('favorite_group', Auth::user()->extendedProfile->favorite_group ?? '') }}">
                            @error('favorite_group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Salvar Dados
                            </button>
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection