<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest', 'throttle:login')->group(function () {
    // Registered only when ADMIN_REGISTRATION_ENABLED=true. Left open, anyone could
    // create an account here and be logged straight into the admin dashboard.
    // New admins are added from User Management instead.
    if (config('app.admin_registration_enabled')) {
        Volt::route('administrator/register', 'pages.auth.register')
            ->name('register');
    }

        Volt::route('administrator/login', 'pages.auth.login')
        ->name('login');


    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:login'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
