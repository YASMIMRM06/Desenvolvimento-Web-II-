<div class="mb-3">
    <label for="grupo_id" class="form-label">Grupo</label>
    <select class="form-select @error('grupo_id') is-invalid @enderror" id="grupo_id" name="grupo_id" required>
        <option value="">Selecione o grupo</option>
        @foreach($grupos as $grupo)
            <option value="{{ $grupo->id }}" {{ old('grupo_id', $musica->grupo_id ?? '') == $grupo->id ? 'selected' : '' }}>
                {{ $grupo->nome }}
            </option>
        @endforeach
    </select>
    @error('grupo_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $musica->titulo ?? '') }}" required>
    @error('titulo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="duracao" class="form-label">Duração (segundos)</label>
    <input type="number" class="form-control @error('duracao') is-invalid @enderror" id="duracao" name="duracao" value="{{ old('duracao', $musica->duracao ?? '') }}" required min="1">
    @error('duracao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="data_lancamento" class="form-label">Data de Lançamento</label>
    <input type="date" class="form-control @error('data_lancamento') is-invalid @enderror" id="data_lancamento" name="data_lancamento" value="{{ old('data_lancamento', $musica->data_lancamento ? $musica->data_lancamento->format('Y-m-d') : '') }}" required>
    @error('data_lancamento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="youtube_id" class="form-label">ID do YouTube (opcional)</label>
    <input type="text" class="form-control @error('youtube_id') is-invalid @enderror" id="youtube_id" name="youtube_id" value="{{ old('youtube_id', $musica->youtube_id ?? '') }}" placeholder="Ex: dQw4w9WgXcQ">
    @error('youtube_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>