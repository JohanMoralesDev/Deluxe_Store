<header class="encabezado">
    <div class="nav-izquierdo">
        <form class="campoBuscar nav-buscador" role="search" method="GET" action="{{ route('store.catalogo') }}">
            <input id="buscarProducto" type="search" name="q" value="{{ request('q') }}"
                placeholder="Buscar marca o modelo..." aria-label="Buscar marca o modelo">
            <button class="iconoBusqueda nav-buscador__boton" type="submit" aria-label="Buscar en el catálogo">
                <i class="bi bi-search" aria-hidden="true"></i>
            </button>
        </form>
        <nav class="nav-principal" aria-label="Navegación principal">
            <a href="{{ route('store.catalogo') }}" @if (request()->routeIs('store.catalogo', 'products.*')) aria-current="page" @endif>Catálogo</a>
            <a href="{{ route('store.nuevo') }}" @if (request()->routeIs('store.nuevo')) aria-current="page" @endif>Novedades</a>
        </nav>
    </div>

    <a href="{{ route('store.index') }}" class="nombre-marca" aria-label="Deluxe Store, inicio">DELUXE STORE</a>

    <div class="nav-derecho">
        <nav class="nav-secundario" aria-label="Más enlaces">
            <a href="{{ route('store.index') }}#sobre-nosotros">Sobre nosotros</a>
        </nav>
        <a href="{{ route('store.carrito') }}" class="nav-icon" aria-label="Ir al carrito">
            <i class="bi bi-cart-check" aria-hidden="true"></i><span>Carrito</span>
        </a>
        @auth
            <div class="cuenta-menu-contenedor">
                <button type="button" class="nav-icon cuenta-menu-boton" id="botonMenuCuenta"
                    aria-haspopup="true" aria-expanded="false" aria-controls="menuCuenta">
                    <i class="bi bi-person-circle" aria-hidden="true"></i><span>{{ auth()->user()->nombre }}</span>
                </button>
                <div class="menu-cuenta" id="menuCuenta" aria-label="Opciones de cuenta" hidden>
                    <div class="menu-cuenta__usuario">
                        <strong>{{ auth()->user()->nombre }}</strong>
                        <span>{{ auth()->user()->correo }}</span>
                    </div>
                    <a href="{{ route('account.show') }}">Mi cuenta</a>
                    <a href="{{ route('account.show') }}#editar-informacion">Editar información</a>
                    @if (auth()->user()->roles->contains('nombre', 'ADMINISTRADOR'))
                        <a href="{{ route('admin.index') }}">Panel administrativo</a>
                    @endif
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        @else
            <button type="button" class="nav-icon boton-perfil" id="abrirModalPerfil"
                aria-haspopup="dialog" aria-controls="modalAutenticacion">
                <i class="bi bi-person-circle" aria-hidden="true"></i><span>Iniciar sesión</span>
            </button>
        @endauth
    </div>

    <button type="button" class="boton-menu-tienda" id="botonMenuTienda"
        aria-label="Abrir menú de navegación" aria-controls="menuPantallaCompleta" aria-expanded="false">
        <i class="bi bi-list" aria-hidden="true"></i>
    </button>

    <nav class="menu-pantalla-completa" id="menuPantallaCompleta" aria-label="Navegación móvil" aria-hidden="true" inert>
        <form class="buscador-movil" role="search" method="GET" action="{{ route('store.catalogo') }}">
            <label for="buscarProductoMovil">Buscar productos</label>
            <div>
                <input id="buscarProductoMovil" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar marca o modelo...">
                <button type="submit" aria-label="Buscar"><i class="bi bi-search" aria-hidden="true"></i></button>
            </div>
        </form>
        <a href="{{ route('store.index') }}" @if (request()->routeIs('store.index')) aria-current="page" @endif>Inicio</a>
        <a href="{{ route('store.catalogo') }}" @if (request()->routeIs('store.catalogo', 'products.*')) aria-current="page" @endif>Catálogo</a>
        <a href="{{ route('store.nuevo') }}" @if (request()->routeIs('store.nuevo')) aria-current="page" @endif>Novedades</a>
        <a href="{{ route('store.index') }}#sobre-nosotros">Sobre nosotros</a>
        <a href="{{ route('store.carrito') }}">Carrito</a>
        @auth
            <a href="{{ route('account.show') }}">Mi cuenta</a>
            @if (auth()->user()->roles->contains('nombre', 'ADMINISTRADOR'))
                <a href="{{ route('admin.index') }}">Panel administrativo</a>
            @endif
            <form class="menu-movil-sesion" action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        @else
            <button class="menu-movil-cuenta" type="button" id="abrirModalPerfilMovil" aria-controls="modalAutenticacion">
                Iniciar sesión o registrarse
            </button>
        @endauth
    </nav>
</header>
