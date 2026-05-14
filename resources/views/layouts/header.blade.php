<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="CineVault — Discover, track, and save your favorite movies. Browse top-rated films, read reviews, and build your personal watchlist.">
	<title>@yield('title', 'CineVault — Your Personal Movie Database')</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

	@stack('head')
</head>
<body>

<header class="site-header" id="site-header">
	<nav class="nav-container">

		<a href="{{ route('home') }}" class="nav-logo" id="nav-logo">
			<span class="logo-icon">🎬</span>
			Cine<span class="logo-dot">Vault</span>
		</a>

		<ul class="nav-links" id="nav-links">
			<li>
				<a href="{{ route('home') }}"
				   id="nav-home"
				   @class(['active' => request()->routeIs('home')])>
					Home
				</a>
			</li>
			<li>
				<a href="{{ route('home') }}"
				   id="nav-movies"
				   @class(['active' => request()->routeIs('home')])>
					Movies
				</a>
			</li>
			@auth
			<li>
				<a href="{{ route('favorites.index') }}"
				   id="nav-favorites"
				   @class(['active' => request()->routeIs('favorites.*')])>
					Favorites
				</a>
			</li>
			@endauth
		</ul>

		<div class="nav-auth" id="nav-auth">
			@auth
				<span class="nav-user-greeting">Hi, {{ Auth::user()->name }}</span>
				<a href="{{ route('profile') }}" class="btn btn-ghost" id="nav-profile">Profile</a>

				<form method="POST" action="{{ route('logout') }}" style="display:inline">
					@csrf
					<button type="submit" class="btn btn-ghost" id="btn-logout">Log Out</button>
				</form>
			@else
				<a href="{{ route('login') }}" class="btn btn-ghost" id="btn-login">Log In</a>
				<a href="{{ route('register') }}" class="btn btn-primary" id="btn-signup">Sign Up</a>
			@endauth
		</div>

		<button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation">
			<span></span>
			<span></span>
			<span></span>
		</button>

	</nav>
</header>

<main id="app-content">
