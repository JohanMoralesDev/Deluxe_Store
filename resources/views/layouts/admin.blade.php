<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administración | Deluxe Store')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['public/assets/css/admin.css', 'public/assets/css/assistant.css', 'public/assets/js/admin.js'])
    @stack('head')
    @stack('styles')
</head>
<body>
<div class="panel-admin">
    <button class="boton-menu-movil" id="botonMenuMovil" type="button" aria-controls="barraLateral" aria-expanded="false">
        <i class="bi bi-list" aria-hidden="true"></i><span>Menú</span>
    </button>

    <aside class="barra-lateral" id="barraLateral">
        <a href="{{ route('store.index') }}" class="marca-admin"><i class="bi bi-gem" aria-hidden="true"></i><span>Deluxe Store</span></a>
        <p class="titulo-menu">ADMINISTRACIÓN</p>
        <nav class="menu-admin" aria-label="Menú administrativo">
            <a href="{{ route('admin.index') }}" class="enlace-admin @yield('menu-dashboard')"><i class="bi bi-grid" aria-hidden="true"></i><span>Dashboard</span></a>
            <a href="{{ route('admin.inventory.index') }}" class="enlace-admin @yield('menu-inventario')"><i class="bi bi-box-seam" aria-hidden="true"></i><span>Inventario</span></a>
            <a href="{{ route('admin.inventory.index') }}#movimientos" class="enlace-admin"><i class="bi bi-arrow-left-right" aria-hidden="true"></i><span>Movimientos</span></a>
            <a href="{{ route('admin.orders.index') }}" class="enlace-admin"><i class="bi bi-receipt" aria-hidden="true"></i><span>Pedidos</span></a>
            <a href="{{ route('admin.reports.index') }}" class="enlace-admin"><i class="bi bi-bar-chart" aria-hidden="true"></i><span>Informes</span></a>
            <a href="{{ route('admin.productos.index') }}" class="enlace-admin"><i class="bi bi-tags" aria-hidden="true"></i><span>Productos</span></a>
            <a href="{{ route('admin.categories.index') }}" class="enlace-admin"><i class="bi bi-collection" aria-hidden="true"></i><span>Categorías</span></a>
        </nav>
        <a href="{{ route('store.index') }}" class="volver-tienda"><i class="bi bi-arrow-left" aria-hidden="true"></i>Volver a la tienda</a>
    </aside>

    <main class="contenido-admin">
        @include('components.alerts')
        @yield('content')
        <footer class="pie-admin">Deluxe Store · Panel de Administración</footer>
    </main>
</div>
@include('components.admin-assistant')
@stack('scripts')
</body>
</html>
