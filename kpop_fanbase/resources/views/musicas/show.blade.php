@extends('layouts.app')

@section('title', $musica->titulo)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="card-title">{{ $musica->titulo }}</h1>
                        <h3 class="card-subtitle mb-2 text-muted">{{ $musica->grupo->nome }}</h3>
                    </div>
                    <div class="text-end">
                        <div class="star-rating" data-rating="{{ $musica->media_avaliacoes }}">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $musica->media_avaliacoes ? '' : '-empty' }}"></i>
                            @endfor
                            <small>({{ $musica->avaliacoes->count() }} avaliações)</small>
                        </div>
                        <p class="mb-0"><small>Lançamento: {{ $musica->data_lancamento->format('d/m/Y') }}</small></p>
                        <p class="mb-0"><small>Duração: {{ $musica->duracao_formatada }}</small></p>
                    </div>
                </div>
                
                @if($musica->youtube_id)
                <div class="ratio ratio-16x9 my-4">
                    <iframe src="https://www.youtube.com/embed/{{ $musica->youtube_id }}" allowfullscreen></iframe>
                </div>
                @endif
                
                @if(auth()->user() && auth()->user()->isAdmin())
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('musicas.edit', $musica->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('musicas.destroy', $musica->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta música?')">Excluir</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-star"></i> Avaliações</h3>
            </div>
            <div class="card-body">
                @auth
                <div class="mb-4">
                    <h4>Avalie esta música</h4>
                    <form action="{{ route('musicas.avaliar', $musica->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nota</label>
                            <div class="star-rating-select">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="nota" value="{{ $i }}" {{ old('nota') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentário (opcional)</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="3">{{ old('comentario') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                    </form>
                </div>
                @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Faça login</a> para avaliar esta música.
                </div>
                @endauth
                
                <hr>
                
                <h4>Avaliações recentes</h4>
                @forelse($avaliacoes as $avaliacao)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $avaliacao->usuario->nome }}</h5>
                            <div class="star-rating" data-rating="{{ $avaliacao->nota }}">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $avaliacao->nota ? '' : '-empty' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="card-text"><small class="text-muted">{{ $avaliacao->created_at->format('d/m/Y H:i') }}</small></p>
                        @if($avaliacao->comentario)
                        <p class="card-text">{{ $avaliacao->comentario }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="alert alert-warning">
                    Nenhuma avaliação ainda. Seja o primeiro a avaliar!
                </div>
                @endforelse
                
                {{ $avaliacoes->links() }}
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3><i class="fas fa-info-circle"></i> Sobre o Grupo</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $musica->grupo->foto) }}" alt="{{ $musica->grupo->nome }}" class="img-fluid rounded" style="max-height: 200px;">
                </div>
                <h4>{{ $musica->grupo->nome }}</h4>
                <p><strong>Empresa:</strong> {{ $musica->grupo->empresa_formatada }}</p>
                <p><strong>Debut:</strong> {{ $musica->grupo->data_debut->format('d/m/Y') }}</p>
                <a href="{{ route('grupos.show', $musica->grupo->id) }}" class="btn btn-primary btn-sm">Ver Grupo</a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3><i class="fas fa-music"></i> Outras Músicas</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($musica->grupo->musicas->where('id', '!=', $musica->id)->take(5) as $outraMusica)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('musicas.show', $outraMusica->id) }}">{{ $outraMusica->titulo }}</a>
                        <span class="badge bg-primary rounded-pill">{{ $outraMusica->duracao_formatada }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .star-rating {
        color: #ffc107;
    }
    .star-rating-select input[type="radio"] {
        display: none;
    }
    .star-rating-select label {
        color: #ddd;
        font-size: 1.5rem;
        padding: 0 3px;
        cursor: pointer;
    }
    .star-rating-select input[type="radio"]:checked ~ label {
        color: #ffc107;
    }
    .star-rating-select label:hover,
    .star-rating-select label:hover ~ label {
        color: #ffc107;
    }
</style>
@endpush