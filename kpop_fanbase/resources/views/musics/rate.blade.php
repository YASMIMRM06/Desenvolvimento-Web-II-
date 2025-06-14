@extends('layouts.app')

@section('title', 'Avaliar Música: ' . $music->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Avaliar Música: {{ $music->title }}</h4>
                </div>
                <div class="card-body">
                    @if($alreadyRated)
                        <div class="alert alert-warning">
                            Você já avaliou esta música!
                        </div>
                    @else
                        <form method="POST" action="{{ route('musics.rate.store', $music->id) }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Sua Avaliação</label>
                                <div class="rating-stars-input mb-3">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                                        <label for="star{{ $i }}">★</label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comentário (opcional)</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                                <a href="{{ route('musics.show', $music->id) }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rating-stars-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-stars-input input {
        display: none;
    }
    .rating-stars-input label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating-stars-input input:checked ~ label,
    .rating-stars-input label:hover,
    .rating-stars-input label:hover ~ label {
        color: #ffc107;
    }
    .rating-stars-input input:checked + label:hover,
    .rating-stars-input input:checked ~ label:hover,
    .rating-stars-input input:checked ~ label:hover ~ label,
    .rating-stars-input label:hover ~ input:checked ~ label {
        color: #ffc107;
    }
</style>
@endpush
@endsection