(function () {
  var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function showError(msg) {
    var errorBox = document.getElementById('auth-error');
    if (!errorBox) return;
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
  }

  function clearError() {
    var errorBox = document.getElementById('auth-error');
    if (!errorBox) return;
    errorBox.style.display = 'none';
    errorBox.textContent = '';
  }

  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form || form.tagName !== 'FORM') return;

    if (form.id === 'login-form') {
      clearError();

      var email = document.getElementById('login-email');
      var password = document.getElementById('login-password');

      if (!email || !emailRe.test(email.value.trim())) {
        e.preventDefault();
        showError('Please enter a valid email address.');
        return;
      }
      if (!password || !password.value) {
        e.preventDefault();
        showError('Password is required.');
      }
      return;
    }

    if (form.id === 'signup-form') {
      clearError();

      var name = document.getElementById('signup-name');
      var email = document.getElementById('signup-email');
      var password = document.getElementById('signup-password');
      var confirm = document.getElementById('signup-confirm');

      if (!name || !name.value.trim()) {
        e.preventDefault();
        showError('Full name is required.');
        return;
      }
      if (!email || !emailRe.test(email.value.trim())) {
        e.preventDefault();
        showError('Please enter a valid email address.');
        return;
      }
      if (!password || password.value.length < 6) {
        e.preventDefault();
        showError('Password must be at least 6 characters.');
        return;
      }
      if (!confirm || password.value !== confirm.value) {
        e.preventDefault();
        showError('Passwords do not match.');
      }
    }
  });
})();
