<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/my_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
