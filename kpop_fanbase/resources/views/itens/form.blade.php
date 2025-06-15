<div class="mb-3">
    <label for="nome" class="form-label">Nome do Item</label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $item->nome ?? '') }}" required>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo</label>
    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
        <option value="">Selecione o tipo</option>
        <option value="album" {{ old('tipo', $item->tipo ?? '') == 'album' ? 'selected' : '' }}>Álbum</option>
        <option value="photocard" {{ old('tipo', $item->tipo ?? '') == 'photocard' ? 'selected' : '' }}>Photocard</option>
        <option value="merchandising" {{ old('tipo', $item->tipo ?? '') == 'merchandising' ? 'selected' : '' }}>Merchandising</option>
        <option value="outro" {{ old('tipo', $item->tipo ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
    </select>
    @error('tipo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
        <option value="">Selecione o estado</option>
        <option value="novo" {{ old('estado', $item->estado ?? '') == 'novo' ? 'selected' : '' }}>Novo</option>
        <option value="seminovo" {{ old('estado', $item->estado ?? '') == 'seminovo' ? 'selected' : '' }}>Seminovo</option>
        <option value="usado" {{ old('estado', $item->estado ?? '') == 'usado' ? 'selected' : '' }}>Usado</option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3">{{ old('descricao', $item->descricao ?? '') }}</textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="foto" class="form-label">Foto do Item</label>
    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
    @error('foto')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($item) && $item->foto)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto atual" class="img-thumbnail" style="max-height: 200px;">
            <p class="text-muted mt-1">Foto atual</p>
        </div>
    @endif
</div>

<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="disponivel_para_troca" name="disponivel_para_troca" value="1" {{ old('disponivel_para_troca', $item->disponivel_para_troca ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="disponivel_para_troca">Disponível para troca</label>
</div>