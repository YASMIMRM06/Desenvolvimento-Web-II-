@extends('layouts.app', ['title' => 'Músicas de K-POP'])

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-music"></i> Músicas de K-POP</h3>
            @can('create', App\Models\Musica::class)
            <a href="{{ route('musicas.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i> Nova Música
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Grupo</th>
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
                        <td>{{ $musica->grupo->nome }}</td>
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
                            @can('update', $musica)
                            <a href="{{ route('musicas.edit', $musica->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('delete', $musica)
                            <form action="{{ route('musicas.destroy', $musica->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta música?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $musicas->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .star-rating {
        color: #ffc107;
    }
</style>
@endpush