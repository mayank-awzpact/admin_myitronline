<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/my_icon.png') }}">
   <link href="{{ asset('cdn/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cdn/css/all.min.css') }}">
    <link href="{{ asset('cdn/css/inter.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body>
    <div class="main-container">
        <div class="login-card">
            <div class="login-panel">
                {{ $slot }}
            </div>

            <div class="visual-panel">
                <div class="promo-blob blob-1"></div>
                <div class="promo-blob blob-2"></div>
                <div class="visual-content">
                    <div class="visual-icon">
                        <img src="{{ asset('img/logo/logo_4.png') }}" alt="Logo" class="img-fluid"
                            style="width: 300px;">
                    </div>
                    <h3 class="mb-3">MYITRONLINE</h3>
                    <p class="mb-0 text-white">India's leading Tax e-filing website</p>
                </div>
            </div>
        </div>
    </div>

   <script src="{{ asset('cdn/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
