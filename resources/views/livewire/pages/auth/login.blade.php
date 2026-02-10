<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div class="w-100">

    <div class="text-center mb-2">

        <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" class="img-fluid mb-2" style="width: 150px;">

        <h1 class="form-title">Welcome Back!</h1>

    </div>

    @if (session('status'))
        <div class="alert alert-success mb-4 d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login">
        <p class="form-subtitle">Log in to continue your journey with us.</p>
        <div class="form-floating mb-3">
            <input wire:model="form.email" id="email" type="email" name="email"
                class="form-control @error('form.email') is-invalid @enderror" placeholder="name@example.com" required
                autofocus autocomplete="username">
            <label for="email">
                <i class="fas fa-envelope me-2 opacity-50"></i>Email address
            </label>
            @error('form.email')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        {{-- PASSWORD INPUT WITH SHOW/HIDE TOGGLE --}}
        <div class="mb-4 position-relative" x-data="{ showPassword: false }">
            <div class="form-floating">
                <input wire:model="form.password" id="password" :type="showPassword ? 'text' : 'password'"
                    name="password" class="form-control @error('form.password') is-invalid @enderror"
                    placeholder="Password" required autocomplete="current-password">
                <label for="password">
                    <i class="fas fa-lock me-2 opacity-50"></i>Password
                </label>
            </div>
            <button type="button" @click="showPassword = !showPassword"
                class="btn-show-hide position-absolute top-50 end-0 translate-middle-y me-3" style="z-index: 10;">
                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
            </button>
            @error('form.password')
                <div class="invalid-feedback d-block">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input wire:model="form.remember" id="remember" type="checkbox" class="form-check-input">
                <label for="remember" class="form-check-label">
                    Remember me
                </label>
            </div>

            <a href="{{ route('password.request') }}" wire:navigate class="text-primary text-decoration-none"
                style="visibility: hidden">
                Forgot password
            </a>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary-custom btn-lg" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">
                    {{ __('Log in') }}<i class="fas fa-arrow-right ms-2"></i>
                </span>
                <span wire:loading wire:target="login" class="text-white">
                    <i class="fas fa-spinner fa-spin me-2"></i>Logging in...
                </span>
            </button>
        </div>
    </form>
</div>
