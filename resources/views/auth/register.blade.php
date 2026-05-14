@extends('layouts.app')

@section('title', 'Create Account')

@push('head')
<style>
		/* ── Identical scoped auth styles ── */
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
<section class="auth-page" id="signup-page">
	<div class="auth-card" id="signup-card">

		{{-- Header --}}
		<div class="auth-card__header">
			<div class="auth-card__icon">🚀</div>
			<h1 class="auth-card__title">Create Account</h1>
			<p class="auth-card__subtitle">Join CineVault and start building your movie collection</p>
		</div>

		{{-- Error box: shows JS validation errors OR Laravel validation errors --}}
		<div class="alert alert--error" id="auth-error"
			 style="{{ $errors->any() ? '' : 'display:none;' }}">
			@if ($errors->any())
				{{ $errors->first() }}
			@endif
		</div>

		{{-- Register form — posts to Laravel AuthController@register --}}
		<form id="signup-form" class="auth-form" method="POST" action="{{ route('register') }}" novalidate>
			@csrf

			<div class="form-group" id="signup-name-group">
				<label for="signup-name" class="form-label">Full Name</label>
				<input
					type="text"
					name="name"
					id="signup-name"
					class="form-input"
					placeholder="John Doe"
					value="{{ old('name') }}"
					required
				>
			</div>

			<div class="form-group" id="signup-email-group">
				<label for="signup-email" class="form-label">Email</label>
				<input
					type="email"
					name="email"
					id="signup-email"
					class="form-input"
					placeholder="you@example.com"
					value="{{ old('email') }}"
					required
					autocomplete="email"
				>
			</div>

			<div class="form-group" id="signup-password-group">
				<label for="signup-password" class="form-label">Password</label>
				<input
					type="password"
					name="password"
					id="signup-password"
					class="form-input"
					placeholder="Minimum 6 characters"
					required
					minlength="6"
					autocomplete="new-password"
				>
			</div>

			<div class="form-group" id="signup-confirm-group">
				<label for="signup-confirm" class="form-label">Confirm Password</label>
				<input
					type="password"
					name="password_confirmation"
					id="signup-confirm"
					class="form-input"
					placeholder="Re-enter your password"
					required
					autocomplete="new-password"
				>
				{{--
					NOTE: Laravel's `confirmed` rule looks for a field named
					`password_confirmation` (with an underscore), not `password_confirm`.
					This matches your AuthController validation rule automatically.
				--}}
			</div>

			<button type="submit" class="btn btn-primary btn--full">Sign Up →</button>
		</form>

		<div class="auth-card__footer">
			Already have an account? <a href="{{ route('login') }}">Log In</a>
		</div>

	</div>
</section>
@endsection

@push('scripts')
<script>
	document.getElementById('signup-form').addEventListener('submit', function (e) {
		const errorBox = document.getElementById('auth-error');
		const name     = document.getElementById('signup-name').value.trim();
		const email    = document.getElementById('signup-email').value.trim();
		const password = document.getElementById('signup-password').value;
		const confirm  = document.getElementById('signup-confirm').value;

		errorBox.style.display = 'none';
		errorBox.textContent   = '';

		if (!name) {
			e.preventDefault();
			errorBox.textContent   = 'Full name is required.';
			errorBox.style.display = 'block';
			return;
		}

		const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!email || !emailPattern.test(email)) {
			e.preventDefault();
			errorBox.textContent   = 'Please enter a valid email address.';
			errorBox.style.display = 'block';
			return;
		}

		if (password.length < 6) {
			e.preventDefault();
			errorBox.textContent   = 'Password must be at least 6 characters.';
			errorBox.style.display = 'block';
			return;
		}

		if (password !== confirm) {
			e.preventDefault();
			errorBox.textContent   = 'Passwords do not match.';
			errorBox.style.display = 'block';
		}
	});
</script>
@endpush
