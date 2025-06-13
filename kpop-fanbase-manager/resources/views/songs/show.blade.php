@extends('layouts.app')

@section('title', $song->title)

@section('content')
<div class="song-detail">
    <div class="song-info">
        <h1>{{ $song->title }}</h1>
        <p>By: <a href="{{ route('groups.show', $song->group) }}">{{ $song->group->name }}</a></p>
        <p>Duration: {{ $song->duration }}</p>
        <p>Released: {{ $song->release_date->format('M d, Y') }}</p>
        
        <div class="rating">
            <span class="average-rating">{{ number_format($song->average_rating, 1) }}</span>
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($song->average_rating))
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </div>
            <span>({{ $song->ratings->count() }} ratings)</span>
        </div>
        
        @if($song->youtube_id)
        <div class="video-container">
            <iframe width="560" height="315" 
                    src="https://www.youtube.com/embed/{{ $song->youtube_id }}" 
                    frameborder="0" allowfullscreen></iframe>
        </div>
        @endif
    </div>
    
    @auth
    <div class="rate-form">
        <h3>Rate this song</h3>
        <form action="{{ route('songs.rate', $song) }}" method="POST">
            @csrf
            <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" />
                    <label for="star{{ $i }}">★</label>
                @endfor
            </div>
            <textarea name="comment" placeholder="Your comment (optional)"></textarea>
            <button type="submit">Submit Rating</button>
        </form>
    </div>
    @endauth
    
    <div class="reviews">
        <h3>Reviews</h3>
        @forelse($song->ratings as $rating)
        <div class="review">
            <div class="review-header">
                <span class="user">{{ $rating->user->name }}</span>
                <span class="rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating->rating))
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </span>
                <span class="date">{{ $rating->created_at->format('M d, Y') }}</span>
            </div>
            @if($rating->comment)
            <p class="comment">{{ $rating->comment }}</p>
            @endif
        </div>
        @empty
        <p>No reviews yet. Be the first to rate!</p>
        @endforelse
    </div>
</div>
@endsection