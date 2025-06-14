@extends('layouts.app')

@section('title', 'Criar Novo Grupo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Criar Novo Grupo</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Grupo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="company" class="form-label">Empresa</label>
                            <select class="form-control @error('company') is-invalid @enderror" id="company" name="company" required>
                                <option value="">Selecione...</option>
                                <option value="HYBE" {{ old('company') === 'HYBE' ? 'selected' : '' }}>HYBE</option>
                                <option value="SM Entertainment" {{ old('company') === 'SM Entertainment' ? 'selected' : '' }}>SM Entertainment</option>
                                <option value="YG Entertainment" {{ old('company') === 'YG Entertainment' ? 'selected' : '' }}>YG Entertainment</option>
                                <option value="JYP Entertainment" {{ old('company') === 'JYP Entertainment' ? 'selected' : '' }}>JYP Entertainment</option>
                                <option value="Outra" {{ old('company') === 'Outra' ? 'selected' : '' }}>Outra</option>
                            </select>
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="debut_date" class="form-label">Data de Debut</label>
                            <input type="date" class="form-control @error('debut_date') is-invalid @enderror" id="debut_date" name="debut_date" value="{{ old('debut_date') }}" required>
                            @error('debut_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto do Grupo</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Criar Grupo</button>
                            <a href="{{ route('groups.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection