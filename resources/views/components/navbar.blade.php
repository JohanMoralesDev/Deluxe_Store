<header class="encabezado">
      <div class="nav-izquierdo">
      <!-- Barra de navegación -->
        <div class="campoBuscar">
        <input id="buscarProducto" type="text" placeholder="Buscar productos..." aria-label="Buscar productos" />
        <i class="bi bi-search iconoBusqueda"></i>
        </div>

        <nav class="nav-principal">
          <a href="{{ route('store.index') }}" aria-current="page">Inicio</a>
          <a href="{{ route('store.nuevo') }}">Nuevo</a>
        </nav>
      </div>

      <a href="{{ route('store.index') }}" class="nombre-marca">DELUXE STORE</a>

      <div class="nav-derecho">
        <nav class="nav-secundario">
          <a href="{{ route('store.catalogo') }}">Catálogo</a>
          <a href="#sobre-nosotros">Sobre Nosotros</a>
        </nav>

        <a href="{{ route('store.carrito') }}" class="nav-icon">
          <i class="bi bi-cart-check"></i>
          <span>Carrito</span>
        </a>

        <button type="button" class="nav-icon boton-perfil" id="abrirModalPerfil"
        aria-haspopup="dialog" aria-controls="modalAutenticacion">
          <i class="bi bi-person-circle" aria-hidden="true"></i>
          <span>Perfil</span>
          </button>
      </div>

      <!-- Botòn del menù movil -->
       <button type="button" class="boton-menu-tienda" id="botonMenuTienda"
       aria-label="Abrir menú de navegación" aria-controls="menuPantallaCompleta" aria-expanded="false">
      <i class="bi bi-list" aria-hidden="true"></i>
    </button>

    <!-- Menu navegacion pantalla completa -->
     <nav class="menu-pantalla-completa" id="menuPantallaCompleta"   aria-label="Navegación principal"
     aria-hidden="true" inert>

    <a href="{{ route('store.index') }}" aria-current="page">Inicio</a>
    <a href="{{ route('store.nuevo') }}">Nuevo</a>
    <a href="{{ route('store.catalogo') }}">Catálogo</a>
    <a href="#sobre-nosotros">Sobre Nosotros</a>
     </nav>
    </header>
