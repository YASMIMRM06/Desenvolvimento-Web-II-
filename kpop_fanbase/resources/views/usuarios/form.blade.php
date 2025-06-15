<div class="mb-3">
    <label for="nome" class="form-label">Nome Completo</label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $user->nome) }}" required>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $user->data_nascimento ? $user->data_nascimento->format('Y-m-d') : '') }}">
    @error('data_nascimento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="foto_perfil" class="form-label">Foto de Perfil</label>
    <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil" name="foto_perfil" accept="image/*">
    @error('foto_perfil')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if($user->foto_perfil)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto atual" class="img-thumbnail" style="max-height: 150px;">
            <p class="text-muted mt-1">Foto atual</p>
        </div>
    @endif
</div>