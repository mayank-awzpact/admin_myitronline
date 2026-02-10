@extends('backend.app')
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-white text-black bg-opacity-20 rounded-circle p-3 me-3">
                                <i class="bi bi-pencil-square fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Edit User</h2>
                                <p class="mb-0 opacity-75">Update user account information</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back to Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle fs-4 me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-2">Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-person-circle text-primary fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">{{ $user->email }}</p>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Member since {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-light border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-pencil-square text-warning fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-dark fw-bold">Update User Information</h5>
                            <small class="text-muted">Modify the details below to update the user account</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('users.update', Crypt::encryptString($user->id)) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('POST')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-muted">
                                <i class="bi bi-person me-1"></i>Full Name
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" name="name" id="name"
                                       class="form-control border-start-0 @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}"
                                       placeholder="Enter full name"
                                       required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-muted">
                                <i class="bi bi-envelope me-1"></i>Email Address
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" id="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="Enter email address"
                                       required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-transparent border-0 py-3">
                                <h6 class="mb-0 text-dark">
                                    <i class="bi bi-shield-lock me-2"></i>Password Settings
                                </h6>
                                <small class="text-muted">Leave password fields blank to keep the current password</small>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-lock me-1"></i>New Password
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password" id="password"
                                               class="form-control border-start-0 @error('password') is-invalid @enderror"
                                               placeholder="Enter new password (optional)">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Leave blank to keep current password. Must be at least 8 characters if changing.
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-lock-fill me-1"></i>Confirm New Password
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="form-control border-start-0"
                                               placeholder="Confirm new password">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="bi bi-eye" id="toggleConfirmPasswordIcon"></i>
                                        </button>
                                    </div>
                                    <div id="passwordMatch" class="form-text"></div>
                                </div>

                                <div id="passwordStrengthSection" class="d-none">
                                    <label class="form-label fw-semibold text-muted">Password Strength</label>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small id="passwordStrengthText" class="text-muted">Checking password strength...</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-warning btn-lg shadow-sm flex-fill" id="submitBtn">
                                <i class="bi bi-save me-2"></i>Update User
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg flex-fill">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
     style="background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="card border-0 shadow-lg">
            <div class="card-body text-center py-4">
                <div class="spinner-border text-warning mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="text-muted">Updating User...</h5>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const passwordStrengthBar = document.getElementById('passwordStrength');
    const passwordStrengthText = document.getElementById('passwordStrengthText');
    const passwordStrengthSection = document.getElementById('passwordStrengthSection');
    const passwordMatchDiv = document.getElementById('passwordMatch');
    const form = document.getElementById('editUserForm');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('togglePassword').addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        const icon = document.getElementById('togglePasswordIcon');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', type);
        const icon = document.getElementById('toggleConfirmPasswordIcon');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

    passwordField.addEventListener('input', function() {
        const password = this.value;

        if (password.length > 0) {
            passwordStrengthSection.classList.remove('d-none');
            checkPasswordStrength(password);
        } else {
            passwordStrengthSection.classList.add('d-none');
        }
    });

    function checkPasswordStrength(password) {
        let strength = 0;
        let strengthText = '';
        let strengthClass = '';

        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/)) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;

        if (strength <= 25) {
            strengthText = 'Weak password';
            strengthClass = 'password-weak';
        } else if (strength <= 75) {
            strengthText = 'Medium password';
            strengthClass = 'password-medium';
        } else {
            strengthText = 'Strong password';
            strengthClass = 'password-strong';
        }

        passwordStrengthBar.style.width = strength + '%';
        passwordStrengthBar.className = 'progress-bar ' + strengthClass;
        passwordStrengthText.textContent = strengthText;
        passwordStrengthText.className = 'text-muted ' + (strengthClass ? strengthClass.replace('password-', 'text-') : '');
    }

    function checkPasswordMatch() {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (password === '' && confirmPassword === '') {
            passwordMatchDiv.innerHTML = '';
            return;
        }

        if (confirmPassword === '') {
            passwordMatchDiv.innerHTML = '';
            return;
        }

        if (password === confirmPassword) {
            passwordMatchDiv.innerHTML = '<i class="bi bi-check-circle me-1"></i>Passwords match';
            passwordMatchDiv.className = 'form-text match-success';
        } else {
            passwordMatchDiv.innerHTML = '<i class="bi bi-x-circle me-1"></i>Passwords do not match';
            passwordMatchDiv.className = 'form-text match-error';
        }
    }

    confirmPasswordField.addEventListener('input', checkPasswordMatch);
    passwordField.addEventListener('input', checkPasswordMatch);

    form.addEventListener('submit', function(e) {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (password !== '' || confirmPassword !== '') {
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please check and try again.');
                return;
            }
        }

        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating User...';
        submitBtn.disabled = true;
        document.getElementById('loadingOverlay').classList.remove('d-none');
    });

    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 7000);

    document.querySelectorAll('.form-control').forEach(function(input) {
        input.addEventListener('focus', function() {
            this.closest('.input-group').classList.add('shadow');
        });

        input.addEventListener('blur', function() {
            this.closest('.input-group').classList.remove('shadow');
        });
    });

    const originalName = "{{ $user->name }}";
    const originalEmail = "{{ $user->email }}";

    document.getElementById('name').addEventListener('input', function() {
        if (this.value !== originalName) {
            this.classList.add('border-warning');
        } else {
            this.classList.remove('border-warning');
        }
    });

    document.getElementById('email').addEventListener('input', function() {
        if (this.value !== originalEmail) {
            this.classList.add('border-warning');
        } else {
            this.classList.remove('border-warning');
        }
    });
});
</script>
@endsection
