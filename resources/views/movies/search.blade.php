@extends('layouts.app')

@section('title', $query ? 'Search: ' . $query : 'Browse Movies')

@section('content')

<section class="page-hero" id="movies-hero">
    <div class="page-hero__content">
        <h1 class="page-hero__title">Browse <span class="gradient-text">Movies</span></h1>
    </div>
</section>

<section class="section" id="movies-search-section">

    <form id="movies-search-bar" class="search-bar" method="GET" action="{{ route('movies.search') }}">
        <div class="search-bar__input-wrap">
            <span class="search-bar__icon">🔍</span>
            <input
                type="text"
                name="q"
                id="movies-search-input"
                value="{{ $query }}"
                placeholder="Search for movies, series, episodes…"
                autocomplete="off"
                required
            >
        </div>
        <div class="search-bar__filters">
            <select name="type" id="movies-type-filter" class="search-bar__select">
                <option value="">All Types</option>
                <option value="movie"   @selected($type === 'movie')>Movies</option>
                <option value="series"  @selected($type === 'series')>Series</option>
                <option value="episode" @selected($type === 'episode')>Episodes</option>
            </select>
            <button type="submit" class="btn btn-primary" id="movies-search-btn">Search</button>
        </div>
    </form>

    @if ($error)
        <div class="alert alert--info" style="margin-bottom:1.5rem;">{{ $error }}</div>
    @endif

    @if (!$query)
        <div class="empty-state" id="movies-empty-state">
            <div class="empty-state__icon">🍿</div>
            <h2>Start exploring</h2>
            <p>Type a movie title above to search the OMDb database.</p>
        </div>

    @elseif (count($movies) === 0 && !$error)
        <div class="empty-state" id="movies-empty-state">
            <div class="empty-state__icon">🍿</div>
            <h2>No movies found</h2>
            <p>Try another title or adjust your filters.</p>
        </div>

    @else
        <div id="movies-grid" class="movie-grid">
            @foreach ($movies as $m)
                <a href="{{ route('movies.show', $m['imdbID']) }}" class="movie-card">
                    <div class="movie-card__poster">
                        @if (!empty($m['Poster']) && $m['Poster'] !== 'N/A')
                            <img src="{{ $m['Poster'] }}" alt="{{ $m['Title'] }}" loading="lazy">
                        @else
                            <div class="movie-card__no-poster">🎬</div>
                        @endif
                        <div class="movie-card__overlay">
                            <span class="btn btn-primary" style="width:100%">View Details</span>
                        </div>
                    </div>
                    <div class="movie-card__info">
                        <h3 class="movie-card__title">{{ $m['Title'] }}</h3>
                        <div class="movie-card__meta">
                            <span>{{ $m['Year'] ?? '' }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($totalPages > 1)
            <div id="movies-pagination" class="pagination">
                @for ($p = 1; $p <= min($totalPages, 10); $p++)
                    <a
                        href="{{ route('movies.search', ['q' => $query, 'type' => $type, 'page' => $p]) }}"
                        class="btn {{ $p === $page ? 'btn-primary' : 'pagination__btn' }}"
                    >{{ $p }}</a>
                @endfor
            </div>
        @endif
    @endif

</section>

@endsection
