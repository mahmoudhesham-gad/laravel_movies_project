@extends('layouts.app')

@section('title', 'Welcome Back')

@push('head')
<style>
		/* ── Scoped auth styles (matches Phase 1 class names) ── */
		body { margin: 0; font-family: sans-serif; background: #0f1117; color: #e0e0e0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
		.auth-page { width: 100%; display: flex; justify-content: center; padding: 2rem 1rem; }
		.auth-card { background: #1a1d27; border-radius: 12px; padding: 2.5rem 2rem; width: 100%; max-width: 420px; box-shadow: 0 8px 32px rgba(0,0,0,.4); }
		.auth-card__header { text-align: center; margin-bottom: 1.8rem; }
		.auth-card__icon { font-size: 2.4rem; margin-bottom: .5rem; }
		.auth-card__title { margin: 0 0 .4rem; font-size: 1.6rem; }
		.auth-card__subtitle { margin: 0; color: #888; font-size: .9rem; }
		.auth-card__footer { text-align: center; margin-top: 1.2rem; font-size: .9rem; color: #888; }
		.auth-card__footer a { color: #e50914; text-decoration: none; }
		.auth-card__footer a:hover { text-decoration: underline; }
		.form-group { margin-bottom: 1.1rem; }
		.form-label { display: block; margin-bottom: .35rem; font-size: .85rem; color: #bbb; }
		.form-input { width: 100%; padding: .6rem .8rem; border-radius: 6px; border: 1px solid #333; background: #12141c; color: #e0e0e0; font-size: .95rem; box-sizing: border-box; }
		.form-input:focus { outline: none; border-color: #e50914; }
		.btn { cursor: pointer; border: none; border-radius: 6px; padding: .7rem 1.2rem; font-size: 1rem; transition: opacity .2s; }
		.btn-primary { background: #e50914; color: #fff; }
		.btn-primary:hover { opacity: .85; }
		.btn--full { width: 100%; }
		.alert { border-radius: 6px; padding: .7rem 1rem; margin-bottom: 1rem; font-size: .9rem; }
		.alert--error { background: #3b1010; border: 1px solid #e50914; color: #f87171; }
		#auth-msg { margin-top: 1rem; text-align: center; }
		.tag { font-size: .9rem; }
	</style>
@endpush

@section('content')
<section class="auth-page" id="login-page">
	<div class="auth-card" id="login-card">

		{{-- Header --}}
		<div class="auth-card__header">
			<div class="auth-card__icon">🔐</div>
			<h1 class="auth-card__title">Welcome Back</h1>
			<p class="auth-card__subtitle">Log in to access your favorites and watchlist</p>
		</div>

		{{-- Error box: shows JS validation errors OR Laravel validation errors --}}
		<div class="alert alert--error" id="auth-error"
			 style="{{ $errors->any() ? '' : 'display:none;' }}">
			@if ($errors->any())
				{{ $errors->first() }}
			@endif
		</div>

		{{-- Login form — posts to Laravel AuthController@login --}}
		<form id="login-form" class="auth-form" method="POST" action="{{ route('login') }}" novalidate>
			@csrf

			<div class="form-group" id="login-email-group">
				<label for="login-email" class="form-label">Email</label>
				<input
					type="email"
					name="email"
					id="login-email"
					class="form-input"
					placeholder="you@example.com"
					value="{{ old('email') }}"
					required
					autocomplete="email"
				>
			</div>

			<div class="form-group" id="login-password-group">
				<label for="login-password" class="form-label">Password</label>
				<input
					type="password"
					name="password"
					id="login-password"
					class="form-input"
					placeholder="••••••••"
					required
					autocomplete="current-password"
				>
			</div>

			<button type="submit" class="btn btn-primary btn--full">Log In →</button>
		</form>

		<div class="auth-card__footer">
			Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
		</div>

	</div>
</section>
@endsection

@push('scripts')
<script>
	document.getElementById('login-form').addEventListener('submit', function (e) {
		const errorBox = document.getElementById('auth-error');
		const email    = document.getElementById('login-email').value.trim();
		const password = document.getElementById('login-password').value;

		errorBox.style.display = 'none';
		errorBox.textContent   = '';

		const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!email || !emailPattern.test(email)) {
			e.preventDefault();
			errorBox.textContent   = 'Please enter a valid email address.';
			errorBox.style.display = 'block';
			return;
		}
		if (!password) {
			e.preventDefault();
			errorBox.textContent   = 'Password is required.';
			errorBox.style.display = 'block';
		}
	});
</script>
@endpush
