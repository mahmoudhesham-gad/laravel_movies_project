<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="CineVault — Discover, track, and save your favorite movies. Browse top-rated films, read reviews, and build your personal watchlist.">
	<title>@yield('title', 'CineVault — Your Personal Movie Database')</title>

	{{-- Google Fonts --}}
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	{{-- Main stylesheet — put your CSS in public/assets/css/style.css --}}
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

	{{-- Per-page extra head content (optional) --}}
	@stack('head')
</head>
<body>

{{-- ===== HEADER / NAVBAR ===== --}}
<header class="site-header" id="site-header">
	<nav class="nav-container">

		{{-- Logo --}}
		<a href="{{ route('home') }}" class="nav-logo" id="nav-logo">
			<span class="logo-icon">🎬</span>
			Cine<span class="logo-dot">Vault</span>
		</a>

		{{-- Navigation Links --}}
		<ul class="nav-links" id="nav-links">
			<li>
				<a href="{{ route('home') }}"
				   id="nav-home"
				   @class(['active' => request()->routeIs('home')])>
					Home
				</a>
			</li>
			<li>
				<a href="{{ route('movies.index') }}"
				   id="nav-movies"
				   @class(['active' => request()->routeIs('movies.*')])>
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

		{{-- Auth Buttons --}}
		<div class="nav-auth" id="nav-auth">
			@auth
				<span class="nav-user-greeting">Hi, {{ Auth::user()->name }}</span>
				<a href="{{ route('profile') }}" class="btn btn-ghost" id="nav-profile">Profile</a>

				{{-- Logout uses a POST form to match AuthController@logout --}}
				<form method="POST" action="{{ route('logout') }}" style="display:inline">
					@csrf
					<button type="submit" class="btn btn-ghost" id="btn-logout">Log Out</button>
				</form>
			@else
				<a href="{{ route('login') }}" class="btn btn-ghost" id="btn-login">Log In</a>
				<a href="{{ route('register') }}" class="btn btn-primary" id="btn-signup">Sign Up</a>
			@endauth
		</div>

		{{-- Mobile Menu Toggle --}}
		<button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation">
			<span></span>
			<span></span>
			<span></span>
		</button>

	</nav>
</header>

{{-- ===== MAIN CONTENT START ===== --}}
<main id="app-content">
