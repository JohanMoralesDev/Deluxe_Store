<!DOCTYPE html>
<html lang="es-CO">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- SEO -->
  <title>Deluxe Store | Relojes: nueva colección y más vendidos</title>
  <meta name="description" content="Deluxe Store, tienda de relojes. Descubre la nueva colección y los relojes más vendidos de marcas como Calvin Klein, Q&amp;Q, G-Fox y FairWhale." />
  <meta name="theme-color" content="#004d31" />
  <link rel="icon" href="assets/Imagenes/Logo.png" />

  <!-- Redes sociales (al publicar el sitio, añadir og:url y og:image con direcciones absolutas) -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Deluxe Store" />
  <meta property="og:locale" content="es_CO" />
  <meta property="og:title" content="Deluxe Store | Relojes: nueva colección y más vendidos" />
  <meta property="og:description" content="Descubre la nueva colección y los relojes más vendidos de Deluxe Store." />

  <!-- Tipografía -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet" />

  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

  <!-- Estilos propios -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <a class="enlace-salto" href="#contenido">Saltar al contenido</a>

  <!-- =====================================================
       ENCABEZADO
       El menú móvil debe quedarse dentro del <header>:
       el CSS (capas y posición fija) depende de ello.
       ===================================================== -->
  <header class="encabezado">

    <div class="nav-izquierdo">
      <div class="campoBuscar" role="search">
        <input type="search" name="busqueda" placeholder="Buscar productos..." aria-label="Buscar productos" />
        <i class="bi bi-search iconoBusqueda" aria-hidden="true"></i>
      </div>

      <nav class="nav-principal" aria-label="Navegación principal">
        <ul>
          <li><a href="index.html" aria-current="page">Inicio</a></li>
          <li><a href="Nuevo.html">Nuevo</a></li>
        </ul>
      </nav>
    </div>

    <a href="index.html" class="nombre-marca">DELUXE STORE</a>

    <div class="nav-derecho">
      <nav class="nav-secundario" aria-label="Navegación secundaria">
        <ul>
          <li><a href="catalogo.html">Catálogo</a></li>
          <li><a href="#sobre-nosotros">Sobre Nosotros</a></li>
        </ul>
      </nav>

      <a href="carrito.html" class="nav-icon">
        <i class="bi bi-cart-check" aria-hidden="true"></i>
        <span>Carrito</span>
      </a>

      <button type="button" class="nav-icon boton-perfil" id="abrirModalPerfil"
        aria-haspopup="dialog" aria-controls="modalAutenticacion">
        <i class="bi bi-person-circle" aria-hidden="true"></i>
        <span>Perfil</span>
      </button>
    </div>

    <!-- Menú móvil y tablet -->
    <button type="button" class="boton-menu-tienda" id="botonMenuTienda"
      aria-label="Abrir menú de navegación" aria-controls="menuPantallaCompleta" aria-expanded="false">
      <i class="bi bi-list" aria-hidden="true"></i>
    </button>

    <nav class="menu-pantalla-completa" id="menuPantallaCompleta" aria-label="Menú móvil"
      aria-hidden="true" inert>
      <ul>
        <li><a href="index.html" aria-current="page">Inicio</a></li>
        <li><a href="Nuevo.html">Nuevo</a></li>
        <li><a href="catalogo.html">Catálogo</a></li>
        <li><a href="#sobre-nosotros">Sobre Nosotros</a></li>
      </ul>
    </nav>

  </header>


  <!-- =====================================================
       CONTENIDO PRINCIPAL
       ===================================================== -->
  <main class="contenido-principal" id="contenido">

    <!-- Banner principal -->
    <section class="nueva-coleccion" id="inicio" aria-labelledby="titulo-coleccion">
      <div class="nueva-coleccion__texto">
        <h1 class="titulo" id="titulo-coleccion">Nueva Colección</h1>
        <a href="Nuevo.html" class="boton">Descubre más</a>
      </div>
    </section>

    <!-- Más vendidos -->
    <section class="mas-vendidos" id="catalogo" aria-labelledby="titulo-mas-vendidos">

      <header class="mas-vendidos__encabezado">
        <p class="mas-vendidos__etiqueta">SELECCIÓN DEL MOMENTO</p>
        <h2 class="titulo" id="titulo-mas-vendidos">Más vendidos</h2>
        <p class="mas-vendidos__descripcion">
          Descubre los favoritos de nuestra colección y encuentra
          el reloj ideal para tu estilo.
        </p>
      </header>

      <div class="productos">

        <article class="tarjeta-producto">
          <div class="tarjeta-producto__imagen">
            <img src="assets/Imagenes/Calvin-Klein.jpeg" alt="Reloj Calvin Klein para hombre"
              loading="lazy" decoding="async" />
            <span class="producto-etiqueta">Destacado</span>
            <a href="carrito.html" class="producto-accion">
              <i class="bi bi-cart-plus" aria-hidden="true"></i>
              Ver carrito
            </a>
          </div>
          <div class="tarjeta-producto__contenido">
            <span class="tarjeta-producto__categoria">Relojes · Hombre</span>
            <h3 class="tarjeta-producto__nombre">Reloj Calvin Klein para hombre</h3>
            <div class="tarjeta-producto__precios">
              <span class="visually-hidden">Precio actual:</span>
              <span class="precio-actual">$20.000</span>
              <span class="visually-hidden">Precio anterior:</span>
              <del class="precio-anterior">$25.000</del>
            </div>
          </div>
        </article>

        <article class="tarjeta-producto">
          <div class="tarjeta-producto__imagen">
            <img src="assets/Imagenes/Q&amp;Q.jpeg" alt="Reloj Q&amp;Q"
              loading="lazy" decoding="async" />
            <a href="carrito.html" class="producto-accion">
              <i class="bi bi-cart-plus" aria-hidden="true"></i>
              Ver carrito
            </a>
          </div>
          <div class="tarjeta-producto__contenido">
            <span class="tarjeta-producto__categoria">Relojes</span>
            <h3 class="tarjeta-producto__nombre">Reloj Q&amp;Q</h3>
            <div class="tarjeta-producto__precios">
              <span class="visually-hidden">Precio actual:</span>
              <span class="precio-actual">$86.000</span>
              <span class="visually-hidden">Precio anterior:</span>
              <del class="precio-anterior">$90.000</del>
            </div>
          </div>
        </article>

        <article class="tarjeta-producto">
          <div class="tarjeta-producto__imagen">
            <img src="assets/Imagenes/G-Fox-Automatico.jpeg" alt="Reloj G-Fox automático"
              loading="lazy" decoding="async" />
            <a href="carrito.html" class="producto-accion">
              <i class="bi bi-cart-plus" aria-hidden="true"></i>
              Ver carrito
            </a>
          </div>
          <div class="tarjeta-producto__contenido">
            <span class="tarjeta-producto__categoria">Relojes</span>
            <h3 class="tarjeta-producto__nombre">Reloj G-Fox Automático</h3>
            <div class="tarjeta-producto__precios">
              <span class="visually-hidden">Precio actual:</span>
              <span class="precio-actual">$140.000</span>
              <span class="visually-hidden">Precio anterior:</span>
              <del class="precio-anterior">$145.000</del>
            </div>
          </div>
        </article>

        <article class="tarjeta-producto">
          <div class="tarjeta-producto__imagen">
            <img src="assets/Imagenes/FairWhale.jpeg" alt="Reloj FairWhale"
              loading="lazy" decoding="async" />
            <a href="carrito.html" class="producto-accion">
              <i class="bi bi-cart-plus" aria-hidden="true"></i>
              Ver carrito
            </a>
          </div>
          <div class="tarjeta-producto__contenido">
            <span class="tarjeta-producto__categoria">Relojes</span>
            <h3 class="tarjeta-producto__nombre">Reloj FairWhale</h3>
            <div class="tarjeta-producto__precios">
              <span class="visually-hidden">Precio actual:</span>
              <span class="precio-actual">$160.000</span>
              <span class="visually-hidden">Precio anterior:</span>
              <del class="precio-anterior">$175.000</del>
            </div>
          </div>
        </article>

      </div>

      <div class="mas-vendidos__pie">
        <a href="catalogo.html" class="boton boton--catalogo">
          Explorar colección completa
          <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
      </div>

    </section>
  </main>


  <!-- =====================================================
       MODAL DE AUTENTICACIÓN
       (lo abre y cierra assets/js/script.js)
       ===================================================== -->
  <section class="modal-auth" id="modalAutenticacion" role="dialog" aria-modal="true"
    aria-labelledby="tituloModal" aria-hidden="true" hidden>

    <div class="modal__container">

      <button type="button" class="modal__cerrar" id="cerrarModal" aria-label="Cerrar ventana">
        <i class="bi bi-x-lg" aria-hidden="true"></i>
      </button>

      <!-- Iniciar sesión -->
      <div class="modal__sign_in">
        <h2 class="modal__title" id="tituloModal">Iniciar Sesión</h2>

        <form id="formularioLogin">
          <p id="mensajeLogin" class="mensaje-formulario" role="status" aria-live="polite"></p>

          <label for="loginEmail">Correo electrónico</label>
          <input type="email" id="loginEmail" name="email" autocomplete="email" required />

          <label for="loginPassword">Contraseña</label>
          <div class="campo-password">
            <input type="password" id="loginPassword" name="password"
              autocomplete="current-password" required />
            <button type="button" class="alternar-password"
              aria-label="Mostrar contraseña" aria-pressed="false" data-target="loginPassword">
              <i class="bi bi-eye" aria-hidden="true"></i>
            </button>
          </div>

          <!-- PENDIENTE: este enlace aún no tiene página de destino -->
          <a href="#" class="modal__enlace">¿Olvidaste tu contraseña?</a>

          <button type="submit" class="modal__boton">Iniciar Sesión</button>

          <p class="modal__cambio">¿No tienes cuenta?
            <button type="button" id="mostrarRegistro">Regístrate</button>
          </p>
        </form>
      </div>

      <!-- Crear cuenta -->
      <div class="modal__registro" hidden>
        <h2 class="modal__title">Crear cuenta</h2>

        <form id="formularioRegistro">
          <p id="mensajeRegistro" class="mensaje-formulario" role="status" aria-live="polite"></p>

          <label for="registroNombre">Nombre completo</label>
          <input type="text" id="registroNombre" name="nombre" autocomplete="name" required />

          <label for="registroEmail">Correo electrónico</label>
          <input type="email" id="registroEmail" name="email" autocomplete="email" required />

          <label for="registroPassword">Contraseña</label>
          <div class="campo-password">
            <input type="password" id="registroPassword" name="password"
              autocomplete="new-password" required />
            <button type="button" class="alternar-password"
              aria-label="Mostrar contraseña" aria-pressed="false" data-target="registroPassword">
              <i class="bi bi-eye" aria-hidden="true"></i>
            </button>
          </div>

          <label for="confirmarPassword">Confirmar contraseña</label>
          <div class="campo-password">
            <input type="password" id="confirmarPassword" name="confirmarPassword"
              autocomplete="new-password" required />
            <button type="button" class="alternar-password"
              aria-label="Mostrar contraseña" aria-pressed="false" data-target="confirmarPassword">
              <i class="bi bi-eye" aria-hidden="true"></i>
            </button>
          </div>

          <button type="submit" class="modal__boton">Registrarse</button>

          <p class="modal__cambio">¿Ya tienes cuenta?
            <button type="button" id="mostrarLogin">Iniciar sesión</button>
          </p>
        </form>
      </div>

    </div>
  </section>


  <!-- =====================================================
       PIE DE PÁGINA
       ===================================================== -->
  <footer class="pie-pagina" id="sobre-nosotros">

    <div class="pie-pagina__marca">
      <a href="index.html" class="logo-tienda">
        <img src="assets/Imagenes/Logo.png" alt="Deluxe Store, ir al inicio" />
      </a>
      <p class="pie-pagina__nombre">Deluxe Store</p>

      <div class="redes-sociales">
        <a href="https://www.instagram.com/deluxestoremajo?stkn=MXQ2NDFqejMweWdpYg=="
          target="_blank" rel="noopener noreferrer"
          aria-label="Deluxe Store en Instagram (se abre en una pestaña nueva)">
          <i class="bi bi-instagram" aria-hidden="true"></i>
        </a>
        <a href="https://www.tiktok.com/@deluxestoremajo?_r=1&amp;_t=ZS-9ALdsl9GegP"
          target="_blank" rel="noopener noreferrer"
          aria-label="Deluxe Store en TikTok (se abre en una pestaña nueva)">
          <i class="bi bi-tiktok" aria-hidden="true"></i>
        </a>
      </div>
    </div>

    <!-- PENDIENTE: estos enlaces apuntan a secciones que aún no existen -->
    <nav aria-label="Información legal y políticas">
      <ul class="pie-pagina__enlaces">
        <li><a href="#informacion-legal">Información legal</a></li>
        <li><a href="#terminos">Términos y Condiciones</a></li>
        <li><a href="#privacidad">Políticas de privacidad</a></li>
        <li><a href="#envio">Políticas de envío</a></li>
        <li><a href="#devoluciones">Cambios y devolución</a></li>
      </ul>
    </nav>

  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
