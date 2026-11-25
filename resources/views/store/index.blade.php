<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- TipografÃ­a externa -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet"/>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <!-- CSS Propio -->
    @vite(['assets/css/style.css', 'assets/js/script.js'])
    <title>Deluxe Store</title>
  </head>

  <body>
    <header class="encabezado">
      <div class="nav-izquierdo">
      <!-- Barra de navegaciÃ³n -->
        <div class="campoBuscar">
        <input type="text" placeholder="Buscar productos..." aria-label="Buscar productos" />
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
          <a href="{{ route('store.catalogo') }}">CatÃ¡logo</a>
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

      <!-- BotÃ²n del menÃ¹ movil -->
       <button type="button" class="boton-menu-tienda" id="botonMenuTienda"
       aria-label="Abrir menÃº de navegaciÃ³n" aria-controls="menuPantallaCompleta" aria-expanded="false">
      <i class="bi bi-list" aria-hidden="true"></i>
    </button>

    <!-- Menu navegacion pantalla completa -->
     <nav class="menu-pantalla-completa" id="menuPantallaCompleta"   aria-label="NavegaciÃ³n principal"
     aria-hidden="true" inert>

    <a href="{{ route('store.index') }}" aria-current="page">Inicio</a>
    <a href="{{ route('store.nuevo') }}">Nuevo</a>
    <a href="{{ route('store.catalogo') }}">CatÃ¡logo</a>
    <a href="#sobre-nosotros">Sobre Nosotros</a>
     </nav>
    </header>

    <main class="contenido-principal">
      <section class="nueva-coleccion" id="inicio">
        <div class="nueva-coleccion__texto">
          <h1 class="titulo">Nueva ColecciÃ³n</h1>
          <a href="{{ route('store.nuevo') }}" class="boton">Descubre mÃ¡s</a>
        </div>


      </section>

      <section class="mas-vendidos" id="catalogo">
  <div class="mas-vendidos__encabezado">
    <span class="mas-vendidos__etiqueta">SELECCIÃ“N DEL MOMENTO</span>
    <br>
    <h2 class="titulo">MÃ¡s vendidos</h2>

    <p class="mas-vendidos__descripcion">
      Descubre los favoritos de nuestra colecciÃ³n y encuentra
      el reloj ideal para tu estilo.
    </p>
  </div>

  <div class="productos">

    <!-- Producto 1 -->
    <article class="tarjeta-producto">
      <div class="tarjeta-producto__imagen">
        <img
          src="{{ asset('assets/images/store/Calvin-Klein.jpeg') }}"
          alt="Reloj Calvin Klein para hombre"
          loading="lazy"
        />

        <span class="producto-etiqueta">Destacado</span>

        <a href="{{ route('store.carrito') }}" class="producto-accion">
          <i class="bi bi-cart-plus" aria-hidden="true"></i>
          Ver carrito
        </a>
      </div>

      <div class="tarjeta-producto__contenido">
        <span class="tarjeta-producto__categoria">Relojes Â· Hombre</span>

        <h3 class="tarjeta-producto__nombre">
          Reloj Calvin Klein para hombre
        </h3>

        <div class="tarjeta-producto__precios">
          <span class="precio-actual">$20.000</span>
          <span class="precio-anterior">$25.000</span>
        </div>
      </div>
    </article>

    <!-- Producto 2 -->
    <article class="tarjeta-producto">
      <div class="tarjeta-producto__imagen">
        <img
          src="{{ asset('assets/images/store/Q&Q.jpeg') }}"
          alt="Reloj Q&Q"
          loading="lazy"
        />

        <a href="{{ route('store.carrito') }}" class="producto-accion">
          <i class="bi bi-cart-plus" aria-hidden="true"></i>
          Ver carrito
        </a>
      </div>

      <div class="tarjeta-producto__contenido">
        <span class="tarjeta-producto__categoria">Relojes</span>

        <h3 class="tarjeta-producto__nombre">Reloj Q&Q</h3>

        <div class="tarjeta-producto__precios">
          <span class="precio-actual">$86.000</span>
          <span class="precio-anterior">$90.000</span>
        </div>
      </div>
    </article>

    <!-- Producto 3 -->
    <article class="tarjeta-producto">
      <div class="tarjeta-producto__imagen">
        <img
          src="{{ asset('assets/images/store/G-Fox-Automatico.jpeg') }}"
          alt="Reloj G-Fox automÃ¡tico"
          loading="lazy"
        />

        <a href="{{ route('store.carrito') }}" class="producto-accion">
          <i class="bi bi-cart-plus" aria-hidden="true"></i>
          Ver carrito
        </a>
      </div>

      <div class="tarjeta-producto__contenido">
        <span class="tarjeta-producto__categoria">Relojes</span>

        <h3 class="tarjeta-producto__nombre">
          Reloj G-Fox AutomÃ¡tico
        </h3>

        <div class="tarjeta-producto__precios">
          <span class="precio-actual">$140.000</span>
          <span class="precio-anterior">$145.000</span>
        </div>
      </div>
    </article>

    <!-- Producto 4 -->
    <article class="tarjeta-producto">
      <div class="tarjeta-producto__imagen">
        <img
          src="{{ asset('assets/images/store/FairWhale.jpeg') }}"
          alt="Reloj FairWhale"
          loading="lazy"
        />

        <a href="{{ route('store.carrito') }}" class="producto-accion">
          <i class="bi bi-cart-plus" aria-hidden="true"></i>
          Ver carrito
        </a>
      </div>

      <div class="tarjeta-producto__contenido">
        <span class="tarjeta-producto__categoria">Relojes</span>

        <h3 class="tarjeta-producto__nombre">Reloj FairWhale</h3>

        <div class="tarjeta-producto__precios">
          <span class="precio-actual">$160.000</span>
          <span class="precio-anterior">$175.000</span>
        </div>
      </div>
    </article>

  </div>

  <div class="mas-vendidos__pie">
    <a href="{{ route('store.catalogo') }}" class="boton boton--catalogo">
      Explorar colecciÃ³n completa
      <i class="bi bi-arrow-right" aria-hidden="true"></i>
    </a>
  </div>
</section>
    </main>

    <!-- Modal de autenticaciÃ³n -->
    <section class="modal-auth" id="modalAutenticacion" role="dialog" aria-modal="true"
    aria-labelledby="tituloModal" aria-hidden="true" hidden>

      <div class="modal__container">

        <button type="button" class="modal__cerrar" id="cerrarModal" aria-label="Cerrar ventana">
          <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>

        <div class="modal__sign_in">
          <h2 class="modal__title" id="tituloModal">Iniciar SesiÃ³n</h2>
          <form id="formularioLogin" autocomplete="off">
            <p id="mensajeLogin" class="mensaje-formulario" role="status" aria-live="polite"></p>
            <label for="loginEmail">Correo electrÃ³nico</label>
            <input type="email" id="loginEmail" name="email" autocomplete="off" required>

            <label for="loginPassword">ContraseÃ±a</label>
              <div class="campo-password">
                <input type="password" id="loginPassword" name="password"
                  autocomplete="current-password" required>

                <button type="button" class="alternar-password"
                  aria-label="Mostrar contraseÃ±a" aria-pressed="false" data-target="loginPassword">
                <i class="bi bi-eye" aria-hidden="true"></i>
                </button>
              </div>
            <a href="#" class="modal__enlace">Â¿Olvidaste tu contraseÃ±a?</a>

            <button type="submit" class="modal__boton">Iniciar SesiÃ³n</button>
            <p class="modal__cambio">Â¿no tienes cuenta?
              <button type="button" id="mostrarRegistro">RegÃ­strate</button>
            </p>
          </form>
      </div>

      <div class="modal__registro" hidden>
        <h2 class="modal__title">Crear cuenta</h2>
        <form id="formularioRegistro" autocomplete="off">
          <p id="mensajeRegistro" class="mensaje-formulario" role="status" aria-live="polite"></p>
          <label for="registroNombre">Nombre completo</label>
          <input type="text" id="registroNombre" name="nombre" autocomplete="off" required>

          <label for="registroEmail">Correo ElectrÃ³nico</label>
          <input type="email" id="registroEmail" name="email" autocomplete="off" required>

          <label for="registroPassword">ContraseÃ±a</label>
            <div class="campo-password">
              <input type="password" id="registroPassword" name="password"
                autocomplete="new-password" required>

              <button type="button" class="alternar-password"
                aria-label="Mostrar contraseÃ±a" aria-pressed="false" data-target="registroPassword">
                <i class="bi bi-eye" aria-hidden="true"></i>
              </button>
            </div>

          <label for="confirmarPassword">Confirmar contraseÃ±a</label>
            <div class="campo-password">
              <input type="password" id="confirmarPassword"
                name="confirmarPassword" autocomplete="new-password" required>

              <button type="button" class="alternar-password"
                aria-label="Mostrar contraseÃ±a" aria-pressed="false" data-target="confirmarPassword">
                <i class="bi bi-eye" aria-hidden="true"></i>
              </button>
            </div>

          <button type="submit" class="modal__boton">Registrarse</button>
          <p class="modal__cambio">Â¿Ya tienes cuenta?<button type="button" id="mostrarLogin">Iniciar sesiÃ³n</button></p>
        </form>
      </div>
      </div>
    </section>

    <!-- Pie de pÃ¡gina -->
    <footer class="pie-pagina" id="sobre-nosotros">
      <div class="pie-pagina__marca">
        <a href="{{ route('store.index') }}" class="logo-tienda">
        <img src="{{ asset('assets/images/store/Logo.png') }}" alt="Logo de Deluxe Store" />
        </a>
        <p class="pie-pagina__nombre">Deluxe Store</p>

        <div class="redes-sociales">
          <a href="https://www.instagram.com/deluxestoremajo?stkn=MXQ2NDFqejMweWdpYg==" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://www.tiktok.com/@deluxestoremajo?_r=1&_t=ZS-9ALdsl9GegP" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>

      <ul class="pie-pagina__enlaces">
        <li><a href="#informacion-legal">InformaciÃ³n legal</a></li>
        <li><a href="#terminos">TÃ©rminos y Condiciones</a></li>
        <li><a href="#privacidad">PolÃ­ticas de privacidad</a></li>
        <li><a href="#envio">PolÃ­ticas de envÃ­o</a></li>
        <li><a href="#devoluciones">Cambios y devoluciÃ³n</a></li>
      </ul>
    </footer>
    <!-- JavaScript -->
  </body>
</html>
