@if(isset($troca))
<input type="hidden" name="user_receptor_id" value="{{ $troca->user_receptor_id }}">
<input type="hidden" name="item_desejado_id" value="{{ $troca->item_desejado_id }}">
<input type="hidden" name="item_ofertante_id" value="{{ $troca->item_ofertante_id }}">
@endif

<div class="mb-3">
    <label for="mensagem" class="form-label">Mensagem (opcional)</label>
    <textarea class="form-control @error('mensagem') is-invalid @enderror" id="mensagem" name="mensagem" rows="3">{{ old('mensagem', $troca->mensagem ?? '') }}</textarea>
    @error('mensagem')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>