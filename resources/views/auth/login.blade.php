@extends('layouts.app')

@section('title', 'Welcome Back')

@section('content')
<section class="auth-page" id="login-page">
	<div class="auth-card" id="login-card">

		<div class="auth-card__header">
			<div class="auth-card__icon">🔐</div>
			<h1 class="auth-card__title">Welcome Back</h1>
			<p class="auth-card__subtitle">Log in to access your favorites and watchlist</p>
		</div>

		<div class="alert alert--error" id="auth-error"
			 style="{{ $errors->any() ? '' : 'display:none;' }}">
			@if ($errors->any())
				{{ $errors->first() }}
			@endif
		</div>

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
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush
