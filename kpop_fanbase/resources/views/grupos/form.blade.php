<div class="mb-3">
    <label for="nome" class="form-label">Nome do Grupo</label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $grupo->nome ?? '') }}" required>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="empresa" class="form-label">Empresa</label>
    <select class="form-select @error('empresa') is-invalid @enderror" id="empresa" name="empresa" required>
        <option value="">Selecione a empresa</option>
        <option value="SH" {{ old('empresa', $grupo->empresa ?? '') == 'SH' ? 'selected' : '' }}>SM Entertainment</option>
        <option value="YG" {{ old('empresa', $grupo->empresa ?? '') == 'YG' ? 'selected' : '' }}>YG Entertainment</option>
        <option value="JP" {{ old('empresa', $grupo->empresa ?? '') == 'JP' ? 'selected' : '' }}>JYP Entertainment</option>
        <option value="Outra" {{ old('empresa', $grupo->empresa ?? '') == 'Outra' ? 'selected' : '' }}>Outra</option>
    </select>
    @error('empresa')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="data_debut" class="form-label">Data de Debut</label>
    <input type="date" class="form-control @error('data_debut') is-invalid @enderror" id="data_debut" name="data_debut" value="{{ old('data_debut', $grupo->data_debut ? $grupo->data_debut->format('Y-m-d') : '') }}" required>
    @error('data_debut')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="foto" class="form-label">Foto do Grupo</label>
    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
    @error('foto')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($grupo) && $grupo->foto)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $grupo->foto) }}" alt="Foto atual" class="img-thumbnail" style="max-height: 200px;">
            <p class="text-muted mt-1">Foto atual</p>
        </div>
    @endif
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3">{{ old('descricao', $grupo->descricao ?? '') }}</textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>