@props(['music'])

<div class="col-md-4 mb-4">
    <div class="card h-100">
        @if($music->youtube_url)
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/{{ $music->youtube_id }}" allowfullscreen></iframe>
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $music->title }}</h5>
            <p class="card-text">
                <strong>Grupo:</strong> {{ $music->group->name }}<br>
                <strong>Duração:</strong> {{ $music->duration }}
            </p>
            @if($music->average_rating)
                <div>
                    @include('components.rating-stars', ['rating' => $music->average_rating])
                    <small class="text-muted">({{ $music->ratings_count }} avaliações)</small>
                </div>
            @else
                <small class="text-muted">Nenhuma avaliação</small>
            @endif
        </div>
        <div class="card-footer bg-white">
            <a href="{{ route('musics.show', $music->id) }}" class="btn btn-primary btn-sm">
                Detalhes
            </a>
            @auth
                @if(!$music->hasUserRating(auth()->id()))
                    <a href="{{ route('musics.rate', $music->id) }}" class="btn btn-success btn-sm">
                        Avaliar
                    </a>
                @endif
            @endauth
        </div>
    </div>
</div>