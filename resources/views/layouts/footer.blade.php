	</main>
	{{-- ===== MAIN CONTENT END ===== --}}

	{{-- ===== FOOTER ===== --}}
	<footer class="site-footer" id="site-footer">
		<div class="footer-container">
			<div class="footer-grid">

				{{-- Brand Column --}}
				<div class="footer-brand">
					<a href="{{ route('home') }}" class="nav-logo">
						<span class="logo-icon">🎬</span>
						Cine<span class="logo-dot">Vault</span>
					</a>
					<p>Your personal movie database. Discover trending films, save favorites, and never miss a great movie again.</p>
					<div class="footer-socials">
						<a href="#" aria-label="Twitter">𝕏</a>
						<a href="#" aria-label="GitHub">⌘</a>
						<a href="#" aria-label="YouTube">▶</a>
					</div>
				</div>

				{{-- Explore Column --}}
				<div class="footer-col">
					<h4>Explore</h4>
					<ul>
						<li><a href="{{ route('home') }}">Trending</a></li>
						<li><a href="{{ route('home') }}">Top Rated</a></li>
						<li><a href="{{ route('home') }}">New Releases</a></li>
						<li><a href="{{ route('home') }}">Genres</a></li>
					</ul>
				</div>

				{{-- Account Column --}}
				<div class="footer-col">
					<h4>Account</h4>
					<ul>
						@auth
							<li><a href="{{ route('favorites.index') }}">My Favorites</a></li>
							<li><a href="{{ route('profile') }}">Watchlist</a></li>
							<li><a href="{{ route('profile') }}">Settings</a></li>
							<li>
								<form method="POST" action="{{ route('logout') }}" style="display:inline">
									@csrf
									<button type="submit" style="background:none;border:none;padding:0;cursor:pointer;color:inherit;font:inherit;">
										Log Out
									</button>
								</form>
							</li>
						@else
							<li><a href="{{ route('login') }}">Log In</a></li>
							<li><a href="{{ route('register') }}">Sign Up</a></li>
						@endauth
					</ul>
				</div>

				{{-- Legal Column --}}
				<div class="footer-col">
					<h4>Legal</h4>
					<ul>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Terms of Service</a></li>
						<li><a href="#">Cookie Policy</a></li>
					</ul>
				</div>

			</div>

			{{-- Bottom Bar --}}
			<div class="footer-bottom">
				<span>&copy; {{ date('Y') }} CineVault. All rights reserved.</span>
				<span>Powered by OMDb API</span>
			</div>
		</div>
	</footer>

	{{-- Mobile menu toggle (exact match to Phase 1) --}}
	<script>
		const toggle = document.getElementById('nav-toggle');
		const links  = document.getElementById('nav-links');
		const auth   = document.getElementById('nav-auth');
		toggle.addEventListener('click', () => {
			links.classList.toggle('is-open');
			auth.classList.toggle('is-open');
		});
	</script>

	{{-- Per-page extra scripts --}}
	@stack('scripts')

</body>
</html>
