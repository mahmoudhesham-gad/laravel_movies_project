@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<section class="auth-page" id="signup-page">
	<div class="auth-card" id="signup-card">

		<div class="auth-card__header">
			<div class="auth-card__icon">🚀</div>
			<h1 class="auth-card__title">Create Account</h1>
			<p class="auth-card__subtitle">Join CineVault and start building your movie collection</p>
		</div>

		<div class="alert alert--error" id="auth-error"
			 style="{{ $errors->any() ? '' : 'display:none;' }}">
			@if ($errors->any())
				{{ $errors->first() }}
			@endif
		</div>

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
			</div>

			<button type="submit" class="btn btn-primary btn--full">Sign Up →</button>
		</form>

		<div class="auth-card__footer">
			<a href="/">← Back to home</a>
		</div>

		<div class="auth-card__footer">
			Already have an account? <a href="{{ route('login') }}">Log In</a>
		</div>

	</div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush
