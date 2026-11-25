
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Administración | Deluxe Store')</title>

    <!-- Tipografía -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Recursos del proyecto -->
    @vite(['assets/css/admin.css', 'assets/js/admin.js'])

    @stack('head')
</head>

<body>

    <div class="panel-admin">

        <!-- Botón del menú móvil -->
        <button
            class="boton-menu-movil"
            id="botonMenuMovil"
            type="button"
            aria-controls="barraLateral"
            aria-expanded="false"
        >
            <i class="bi bi-list"></i>
            <span>Menú</span>
        </button>

        <!-- Barra lateral -->
        <aside class="barra-lateral" id="barraLateral">

            <a href="{{ route('store.index') }}" class="marca-admin">
                <i class="bi bi-gem"></i>
                <span>Deluxe Store</span>
            </a>

            <p class="titulo-menu">ADMINISTRACIÓN</p>

            <nav class="menu-admin" aria-label="Menú administrativo">

                <!-- Dashboard -->
                <a
                    href="{{ route('admin.index') }}"
                    class="enlace-admin @yield('menu-dashboard')"
                >
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Módulos pendientes de conectar -->
                <a href="#inventario" class="enlace-admin">
                    <i class="bi bi-box-seam"></i>
                    <span>Inventario</span>
                </a>

                <a href="#movimientos" class="enlace-admin">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Movimientos</span>
                </a>

                <a href="#pedidos" class="enlace-admin">
                    <i class="bi bi-receipt"></i>
                    <span>Pedidos</span>
                </a>

                <a href="#informes" class="enlace-admin">
                    <i class="bi bi-bar-chart"></i>
                    <span>Informes</span>
                </a>

                <!-- Productos -->
                <a href="{{ route('admin.productos.index') }}"
                   class="enlace-admin">
                    <i class="bi bi-tags"></i>
                    <span>Productos</span>
                </a>

            </nav>

            <!-- Regresar a la tienda -->
            <a href="{{ route('store.index') }}" class="volver-tienda">
                <i class="bi bi-arrow-left"></i>
                Volver a la tienda
            </a>

        </aside>

        <!-- Contenido de cada módulo -->
        <main class="contenido-admin">

            @yield('content')

            <!-- Pie de página -->
            <footer class="pie-admin">
                Deluxe Store · Panel de Administración
            </footer>

        </main>

    </div>

    @stack('scripts')

</body>
</html>
