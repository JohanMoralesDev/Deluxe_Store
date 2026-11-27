<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['public/assets/css/style.css', 'public/assets/css/auth.css', 'public/assets/css/assistant.css', 'public/assets/js/script.js', 'public/assets/js/assistant.js'])
    @stack('head')
    @stack('styles')
    <title>@yield('title', 'Deluxe Store')</title>
</head>
<body>
    @include('components.navbar')
    @include('components.alerts')

    @yield('content')

    @include('components.footer')
    @include('components.auth-modal')
    @include('components.store-assistant')
    @stack('scripts')
</body>
</html>
