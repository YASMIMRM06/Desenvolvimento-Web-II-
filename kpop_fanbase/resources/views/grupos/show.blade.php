@extends('layouts.app')

@section('title', $grupo->nome)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <img src="{{ asset('storage/' . $grupo->foto) }}" class="card-img-top" alt="{{ $grupo->nome }}">
            <div class="card-body">
                <h1 class="card-title">{{ $grupo->nome }}</h1>
                <p class="card-text">
                    <strong>Empresa:</strong> {{ $grupo->empresa_formatada }}<br>
                    <strong>Debut:</strong> {{ $grupo->data_debut->format('d/m/Y') }}
                </p>
                
                @if(auth()->user() && auth()->user()->isAdmin())
                <div class="d-flex gap-2">
                    <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este grupo?')">Excluir</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-info-circle"></i> Sobre</h3>
            </div>
            <div class="card-body">
                <p>{{ $grupo->descricao }}</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-music"></i> Músicas</h3>
                    @if(auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('musicas.create', ['grupo_id' => $grupo->id]) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Adicionar Música
                    </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Duração</th>
                                <th>Lançamento</th>
                                <th>Avaliação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($musicas as $musica)
                            <tr>
                                <td>{{ $musica->titulo }}</td>
                                <td>{{ $musica->duracao_formatada }}</td>
                                <td>{{ $musica->data_lancamento->format('d/m/Y') }}</td>
                                <td>
                                    <div class="star-rating" data-rating="{{ $musica->media_avaliacoes }}">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $musica->media_avaliacoes ? '' : '-empty' }}"></i>
                                        @endfor
                                        <small>({{ $musica->avaliacoes->count() }})</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('musicas.show', $musica->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user())
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#avaliarModal{{ $musica->id }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $musicas->links() }}
            </div>
        </div>
    </div>
</div>

@foreach($musicas as $musica)
<!-- Modal de Avaliação -->
<div class="modal fade" id="avaliarModal{{ $musica->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Avaliar {{ $musica->titulo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('musicas.avaliar', $musica->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nota (1-5 estrelas)</label>
                        <div class="star-rating-select">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}-{{ $musica->id }}" name="nota" value="{{ $i }}" {{ old('nota') == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}-{{ $musica->id }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentário (opcional)</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3">{{ old('comentario') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ativa os tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush