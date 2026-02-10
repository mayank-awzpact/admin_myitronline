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
                                <i class="bi bi-person-plus fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Add New User</h2>
                                <p class="mb-0 opacity-75">Create a new user account for the system</p>
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

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-light border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-person-plus text-primary fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-dark fw-bold">User Information</h5>
                            <small class="text-muted">Fill in the details below to create a new user account</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
                        @csrf

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
                                       value="{{ old('name') }}"
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
                                       value="{{ old('email') }}"
                                       placeholder="Enter email address"
                                       required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-muted">
                                <i class="bi bi-lock me-1"></i>Password
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                                       placeholder="Enter password"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Password must be at least 8 characters long
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold text-muted">
                                <i class="bi bi-lock-fill me-1"></i>Confirm Password
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control border-start-0"
                                       placeholder="Confirm password"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="form-text"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Password Strength</label>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small id="passwordStrengthText" class="text-muted">Enter a password to see strength</small>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm flex-fill" id="submitBtn">
                                <i class="bi bi-save me-2"></i>Create User
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
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="text-muted">Creating User...</h5>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .input-group:focus-within {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        border-radius: 0.375rem;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: none;
        border-radius: 10px;
        color: #721c24;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
    }

    .progress-bar {
        transition: all 0.3s ease;
    }

    .password-weak {
        background-color: #dc3545 !important;
    }

    .password-medium {
        background-color: #ffc107 !important;
    }

    .password-strong {
        background-color: #28a745 !important;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .match-success {
        color: #28a745 !important;
    }

    .match-error {
        color: #dc3545 !important;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const passwordStrengthBar = document.getElementById('passwordStrength');
    const passwordStrengthText = document.getElementById('passwordStrengthText');
    const passwordMatchDiv = document.getElementById('passwordMatch');
    const form = document.getElementById('addUserForm');
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
        let strength = 0;
        let strengthText = '';
        let strengthClass = '';

        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/)) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;

        if (strength === 0) {
            strengthText = 'Enter a password to see strength';
            strengthClass = '';
        } else if (strength <= 25) {
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
    });

    function checkPasswordMatch() {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

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

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match. Please check and try again.');
            return;
        }

        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating User...';
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
});
</script>
@endsection
