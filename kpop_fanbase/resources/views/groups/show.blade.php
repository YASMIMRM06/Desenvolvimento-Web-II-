@extends('layouts.app')

@section('title', $group->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $group->photo }}" class="card-img-top" alt="{{ $group->name }}">
                <div class="card-body">
                    <h2 class="card-title">{{ $group->name }}</h2>
                    <p class="card-text">
                        <strong>Empresa:</strong> {{ $group->company }}<br>
                        <strong>Debut:</strong> {{ $group->debut_date->format('d/m/Y') }}<br>
                        <strong>Descrição:</strong> {{ $group->description }}
                    </p>
                </div>
                <div class="card-footer">
                    @can('update', $group)
                        <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-secondary">Editar Grupo</a>
                    @endcan
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Estatísticas</h5>
                </div>
                <div class="card-body">
                    <p><strong>Músicas:</strong> {{ $group->musics_count }}</p>
                    <p><strong>Média de Avaliações:</strong> 
                        @if($group->average_rating)
                            {{ number_format($group->average_rating, 1) }} ★
                        @else
                            N/A
                        @endif
                    </p>
                    <p><strong>Fãs:</strong> {{ $group->fans_count }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Músicas</h5>
                        @can('create', App\Models\Music::class)
                            <a href="{{ route('musics.create', ['group_id' => $group->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Adicionar Música
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    @if($group->musics->isEmpty())
                        <p class="text-muted">Nenhuma música cadastrada para este grupo.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Duração</th>
                                        <th>Avaliação Média</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($group->musics as $music)
                                        <tr>
                                            <td>{{ $music->title }}</td>
                                            <td>{{ $music->duration }}</td>
                                            <td>
                                                @if($music->average_rating)
                                                    @include('components.rating-stars', ['rating' => $music->average_rating])
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('musics.show', $music->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('update', $music)
                                                    <a href="{{ route('musics.edit', $music->id) }}" class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Próximos Eventos</h5>
                </div>
                <div class="card-body">
                    @if($group->upcomingEvents->isEmpty())
                        <p class="text-muted">Nenhum evento programado para este grupo.</p>
                    @else
                        <div class="row">
                            @foreach($group->upcomingEvents as $event)
                                @include('components.event-card', ['event' => $event])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection