@extends('layouts.app')

@section('title', $music->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h2 class="card-title">{{ $music->title }}</h2>
                    <p class="card-text">
                        <strong>Grupo:</strong> 
                        <a href="{{ route('groups.show', $music->group->id) }}">{{ $music->group->name }}</a><br>
                        <strong>Duração:</strong> {{ $music->duration }}<br>
                        <strong>Lançamento:</strong> {{ $music->release_date->format('d/m/Y') }}
                    </p>
                    
                    @if($music->youtube_url)
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe src="https://www.youtube.com/embed/{{ $music->youtube_id }}" allowfullscreen></iframe>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <h4>Avaliação Média</h4>
                        @if($music->average_rating)
                            <div class="display-4">{{ number_format($music->average_rating, 1) }}</div>
                            @include('components.rating-stars', ['rating' => $music->average_rating, 'size' => 'lg'])
                            <small>{{ $music->ratings_count }} avaliações</small>
                        @else
                            <p class="text-muted">Nenhuma avaliação ainda</p>
                        @endif
                    </div>
                    
                    @auth
                        @if(!$userRating)
                            <a href="{{ route('musics.rate', $music->id) }}" class="btn btn-primary">
                                Avaliar esta música
                            </a>
                        @else
                            <div class="alert alert-info">
                                Sua avaliação: 
                                @include('components.rating-stars', ['rating' => $userRating->rating])
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
            
            @can('update', $music)
                <div class="d-grid gap-2">
                    <a href="{{ route('musics.edit', $music->id) }}" class="btn btn-secondary">Editar Música</a>
                </div>
            @endcan
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Avaliações</h5>
                </div>
                <div class="card-body">
                    @if($music->ratings->isEmpty())
                        <p class="text-muted">Nenhuma avaliação ainda. Seja o primeiro a avaliar!</p>
                    @else
                        <div class="list-group">
                            @foreach($music->ratings as $rating)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $rating->user->name }}</h6>
                                        <small>{{ $rating->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="mb-1">
                                        @include('components.rating-stars', ['rating' => $rating->rating])
                                    </div>
                                    @if($rating->comment)
                                        <p class="mb-1">{{ $rating->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sobre a Música</h5>
                </div>
                <div class="card-body">
                    @if($music->description)
                        <p>{{ $music->description }}</p>
                    @else
                        <p class="text-muted">Nenhuma descrição disponível.</p>
                    @endif
                    
                    <h6>Detalhes</h6>
                    <ul>
                        <li><strong>Compositor:</strong> {{ $music->composer ?? 'Desconhecido' }}</li>
                        <li><strong>Letrista:</strong> {{ $music->lyricist ?? 'Desconhecido' }}</li>
                        <li><strong>Gênero:</strong> {{ $music->genre ?? 'Não especificado' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection