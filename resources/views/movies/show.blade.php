@extends('layouts.app')

@section('title', $movie['Title'] ?? 'Movie Details')

@section('content')
<section class="section movie-detail" style="padding-top:2rem;">
    <div class="movie-detail__container">
        <div class="movie-detail__poster">
            @if (!empty($movie['Poster']) && $movie['Poster'] !== 'N/A')
                <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}">
            @else
                <div class="movie-card__no-poster" style="min-height:420px;display:grid;place-items:center;">🎬</div>
            @endif
        </div>

        <div class="movie-detail__info">
            <div class="movie-detail__tags">
                <span class="tag">{{ $movie['Year'] ?? '' }}</span>
                <span class="tag">{{ $movie['Rated'] ?? '' }}</span>
                <span class="tag">{{ $movie['Runtime'] ?? '' }}</span>
            </div>

            <h1 class="movie-detail__title">{{ $movie['Title'] ?? '' }}</h1>

            @if (!empty($movie['Genre']))
                <div class="movie-detail__genres">
                    @foreach (explode(', ', $movie['Genre']) as $genre)
                        <span class="genre-pill">{{ $genre }}</span>
                    @endforeach
                </div>
            @endif

            @if (!empty($movie['Ratings']))
                <div class="movie-detail__ratings">
                    @foreach ($movie['Ratings'] as $rating)
                        <div class="rating-box">
                            <div class="rating-box__value">{{ $rating['Value'] }}</div>
                            <div class="rating-box__label">{{ $rating['Source'] }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (!empty($movie['Plot']) && $movie['Plot'] !== 'N/A')
                <div class="movie-detail__plot">
                    <h3>Plot</h3>
                    <p>{{ $movie['Plot'] }}</p>
                </div>
            @endif

            <div class="movie-detail__credits">
                @if (!empty($movie['Director']) && $movie['Director'] !== 'N/A')
                    <div class="credit-row">
                        <span class="credit-row__label">Director</span>
                        <span class="credit-row__value">{{ $movie['Director'] }}</span>
                    </div>
                @endif
                @if (!empty($movie['Writer']) && $movie['Writer'] !== 'N/A')
                    <div class="credit-row">
                        <span class="credit-row__label">Writer</span>
                        <span class="credit-row__value">{{ $movie['Writer'] }}</span>
                    </div>
                @endif
                @if (!empty($movie['Actors']) && $movie['Actors'] !== 'N/A')
                    <div class="credit-row">
                        <span class="credit-row__label">Actors</span>
                        <span class="credit-row__value">{{ $movie['Actors'] }}</span>
                    </div>
                @endif
            </div>

            <div class="movie-detail__actions">
                <form method="POST" action="{{ route('favorites.store') }}">
                    @csrf
                    <input type="hidden" name="movie_title" value="{{ $movie['Title'] }}">
                    <input type="hidden" name="image_url" value="{{ $movie['Poster'] ?? '' }}">
                    <button type="submit" class="btn btn-primary">♡ Add to Favorites</button>
                </form>
                <a href="{{ route('movies.search', ['q' => $movie['Title']]) }}" class="btn btn-ghost">More Like This</a>
            </div>
        </div>
    </div>
</section>
@endsection
