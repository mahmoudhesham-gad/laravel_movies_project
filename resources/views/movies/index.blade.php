@include('layouts.header')

<section class="hero">
	<div class="hero-orb hero-orb--gold"></div>
	<div class="hero-orb hero-orb--purple"></div>
	<div class="hero-orb hero-orb--red"></div>

	<div class="hero-content">
		<div class="hero-badge">
			<span class="pulse"></span>
			Now with 500,000+ titles
		</div>

		<h1>Discover Your Next<br><span class="gradient-text">Favorite Movie</span></h1>

		<p>Browse top-rated films, save your favorites, and build the ultimate personal watchlist.</p>

		<form class="hero-search" id="hero-search" action="{{ route('movies.search') }}" method="GET">
			<input type="text" name="q" id="search-input" placeholder="Search movies by title..." autocomplete="off" required value="{{ request('q') }}">
			<button type="submit" class="btn btn-primary">Search</button>
		</form>
	</div>
</section>

<div class="stats-bar">
	<div class="stat-item">
		<div class="stat-number">500K+</div>
		<div class="stat-label">Movies</div>
	</div>
	<div class="stat-item">
		<div class="stat-number">12K+</div>
		<div class="stat-label">Users</div>
	</div>
	<div class="stat-item">
		<div class="stat-number">98%</div>
		<div class="stat-label">Satisfaction</div>
	</div>
	<div class="stat-item">
		<div class="stat-number">4.9</div>
		<div class="stat-label">App Rating</div>
	</div>
</div>

<section class="section" id="featured-section">
	<div class="section-header">
		<h2 class="section-title">🔥 Featured <span class="accent">Today</span></h2>
	</div>
	<div id="featured-card-wrap">
		<div class="featured-card">
			<div class="featured-card__poster">
				<img src="{{ $featured['Poster'] ?? 'https://via.placeholder.com/400x600?text=Movie+Poster' }}"
					 alt="{{ $featured['Title'] ?? 'Featured Movie' }} poster">
			</div>
			<div class="featured-card__body">
				<div class="featured-card__tags">
					<span class="tag">{{ $featured['Genre'] ?? 'Action' }}</span>
					<span class="tag">{{ $featured['Year'] ?? '2024' }}</span>
					<span class="tag">⭐ {{ $featured['imdbRating'] ?? '8.5' }}</span>
				</div>
				<h2>{{ $featured['Title'] ?? 'The Amazing Adventure' }}</h2>
				<p>{{ $featured['Plot'] ?? 'An epic tale of discovery and courage. Follow our hero on a journey through forgotten lands, where danger lurks at every corner and adventure awaits around every turn.' }}</p>
				<a href="{{ route('movies.search', ['q' => $featured['Title'] ?? 'The Amazing Adventure']) }}" class="btn btn-primary">View Details →</a>
			</div>
		</div>
	</div>
</section>

<section class="section" id="trending-section">
	<div class="section-header">
		<h2 class="section-title">🍿 Trending <span class="accent">Movies</span></h2>
		<a href="{{ route('movies.search') }}" class="section-link" id="view-all-link">View all →</a>
	</div>

	<div class="movie-grid" id="trending-grid">
		@forelse($trendingMovies as $movie)
			<a href="{{ route('movies.search', ['q' => $movie['Title']]) }}" class="movie-card">
				<div class="movie-card__poster">
					<img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/210x315?text=Movie+Poster' }}"
						 alt="{{ $movie['Title'] }}" loading="lazy">
					<div class="movie-card__rating">⭐ {{ $movie['imdbRating'] ?? '8.0' }}</div>
					<button class="movie-card__fav" aria-label="Add to favorites">♡</button>
					<div class="movie-card__overlay">
						<span class="btn btn-primary" style="width:100%">View Details</span>
					</div>
				</div>
				<div class="movie-card__info">
					<h3 class="movie-card__title">{{ $movie['Title'] }}</h3>
					<div class="movie-card__meta">
						<span>{{ $movie['Year'] }}</span>
						<span class="movie-card__genre">Movie</span>
					</div>
				</div>
			</a>
		@empty
			<div class="movie-card" style="grid-column:1/-1; padding: 2rem; text-align:center;">
				<p class="movie-card__title">No trending data available at the moment.</p>
			</div>
		@endforelse
	</div>
</section>

@include('layouts.footer')
