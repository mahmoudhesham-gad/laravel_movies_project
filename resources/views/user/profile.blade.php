@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<section class="profile-section">
    <div class="profile-card animate-fade-in" id="profile-card">

        @if (session('success'))
            <div class="alert alert--info" style="margin-bottom:1rem;">{{ session('success') }}</div>
        @endif

        <div class="profile-header">
            <div class="profile-avatar-container">
                @php
                    $pic = $user->profile_picture
                        ? Storage::url($user->profile_picture)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=random&size=256';
                @endphp
                <img src="{{ $pic }}" alt="Profile Picture" class="profile-avatar" id="profile-preview">
                <label for="profile-upload" class="avatar-edit-btn" title="Change Profile Picture">
                    <span class="icon">📷</span>
                </label>
                <input type="file" id="profile-upload" accept="image/png,image/jpeg,image/webp" hidden>
                <div>
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    <p class="profile-email">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="alert alert--error" id="profile-error" style="display:none;"></div>
        <div class="alert alert--info" id="profile-success" style="display:none;"></div>

        <div class="profile-content">
            <div class="profile-stats">
                <div class="stat-box">
                    <span class="stat-value">{{ $user->favoriteMovies()->count() }}</span>
                    <span class="stat-label">Favorites</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value">-</span>
                    <span class="stat-label">Reviews</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value">Now</span>
                    <span class="stat-label">Session</span>
                </div>
            </div>
        </div>

        <form id="profile-upload-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:none;">
            @csrf
            <input type="file" name="profile_picture" id="profile-upload-input" accept="image/png,image/jpeg,image/webp" required>
        </form>

        <div class="profile-actions" id="profile-actions" style="display:none;">
            <button class="btn btn-primary" id="save-profile" type="button" disabled>Save Profile Picture</button>
            <button class="btn btn-ghost" id="cancel-profile" type="button" disabled>Cancel</button>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        var preview = document.getElementById('profile-preview');
        var uploadBtn = document.getElementById('profile-upload');
        var uploadInput = document.getElementById('profile-upload-input');
        var form = document.getElementById('profile-upload-form');
        var saveBtn = document.getElementById('save-profile');
        var cancelBtn = document.getElementById('cancel-profile');
        var actions = document.getElementById('profile-actions');
        var errorBox = document.getElementById('profile-error');
        var successBox = document.getElementById('profile-success');

        var savedSrc = preview ? preview.src : '';
        var selectedFile = null;

        function clearError() {
            if (!errorBox) return;
            errorBox.style.display = 'none';
            errorBox.textContent = '';
        }

        function showError(msg) {
            if (!errorBox) return;
            errorBox.textContent = msg;
            errorBox.style.display = 'block';
        }

        function clearSuccess() {
            if (!successBox) return;
            successBox.style.display = 'none';
            successBox.textContent = '';
        }

        uploadBtn.addEventListener('change', function (e) {
            clearError();
            clearSuccess();
            var file = e.target.files && e.target.files[0];
            selectedFile = file;

            if (!file) {
                saveBtn.disabled = true;
                cancelBtn.disabled = true;
                actions.style.display = 'none';
                if (preview) preview.src = savedSrc;
                return;
            }

            if (!file.type.startsWith('image/')) {
                showError('Please select a valid image file.');
                selectedFile = null;
                saveBtn.disabled = true;
                cancelBtn.disabled = true;
                actions.style.display = 'none';
                uploadBtn.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function (event) {
                if (preview && event.target && event.target.result) {
                    preview.src = String(event.target.result);
                }
                saveBtn.disabled = false;
                cancelBtn.disabled = false;
                actions.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        });

        cancelBtn.addEventListener('click', function () {
            selectedFile = null;
            uploadBtn.value = '';
            if (uploadInput) uploadInput.value = '';
            if (preview) preview.src = savedSrc;
            saveBtn.disabled = true;
            cancelBtn.disabled = true;
            actions.style.display = 'none';
            clearError();
            clearSuccess();
        });

        saveBtn.addEventListener('click', function () {
            clearError();
            clearSuccess();

            if (!selectedFile) {
                showError('Please choose an image first.');
                return;
            }

            var dt = new DataTransfer();
            dt.items.add(selectedFile);
            uploadInput.files = dt.files;
            form.submit();
        });
    })();
</script>
@endpush
