@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')

<section class="page-hero" id="favorites-hero">
    <div class="page-hero__content">
        <h1 class="page-hero__title">My <span class="gradient-text">Favorites</span></h1>
        <p class="page-hero__subtitle" id="favorites-count-text">
            @if ($favorites->isEmpty())
                No favorites yet
            @else
                {{ $favorites->count() }} movie{{ $favorites->count() === 1 ? '' : 's' }} saved
            @endif
        </p>
    </div>
</section>

<section class="section" id="favorites-section">

    @if (session('success'))
        <div class="alert alert--info" style="margin-bottom:1rem;">{{ session('success') }}</div>
    @endif

    @if ($favorites->isEmpty())
        <div class="empty-state" id="favorites-empty" style="display:flex;flex-direction:column;align-items:center;">
            <div class="empty-state__icon">♡</div>
            <h2>No favorites yet</h2>
            <p>Start adding movies you love!</p>
            <a href="{{ route('movies.search') }}" class="btn btn-primary" style="margin-top:1rem;">Browse Movies</a>
        </div>

    @else
        <div id="favorites-grid" class="movie-grid">
            @foreach ($favorites as $fav)
                <div class="movie-card" data-favorite-id="{{ $fav->id }}">

                    <a href="{{ route('movies.search', ['q' => $fav->movie_title]) }}">
                        <div class="movie-card__poster">
                            @if ($fav->image_url)
                                <img src="{{ $fav->image_url }}" alt="{{ $fav->movie_title }}" loading="lazy">
                            @else
                                <div class="movie-card__no-poster">🎬</div>
                            @endif
                            <div class="movie-card__overlay">
                                <span class="btn btn-primary" style="width:100%">View Search</span>
                            </div>
                        </div>
                        <div class="movie-card__info">
                            <h3 class="movie-card__title">{{ $fav->movie_title }}</h3>
                        </div>
                    </a>

                    <div style="padding: 0 1rem 1rem;">
                        <form method="POST" action="{{ route('favorites.destroy', $fav->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger remove-fav-btn" style="width:100%">
                                Remove
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</section>

@endsection
