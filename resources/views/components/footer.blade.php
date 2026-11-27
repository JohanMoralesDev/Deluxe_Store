<footer class="pie-pagina" id="sobre-nosotros" aria-labelledby="titulo-footer">
    <section class="pie-pagina__marca" aria-labelledby="titulo-footer">
        <a href="{{ route('store.index') }}" class="logo-tienda" aria-label="Deluxe Store, inicio">
            <img src="{{ asset('assets/images/store/Logo.png') }}" alt="">
        </a>
        <div class="pie-pagina__identidad">
            <h2 class="pie-pagina__nombre" id="titulo-footer">DELUXE STORE</h2>
            <p class="pie-pagina__desarrollo">Desarrollado por <strong>Zentrix</strong></p>
            <p class="pie-pagina__descripcion">Tienda de relojes para diferentes estilos y ocasiones.</p>
        </div>
    </section>

    <nav class="pie-pagina__columna" aria-label="Enlaces del pie de página">
        <h2 class="pie-pagina__titulo">Navegación</h2>
        <ul class="pie-pagina__enlaces">
            <li><a href="{{ route('store.index') }}">Inicio</a></li>
            <li><a href="{{ route('store.catalogo') }}">Catálogo</a></li>
            <li><a href="{{ route('store.nuevo') }}">Novedades</a></li>
            <li><a href="{{ route('store.index') }}#sobre-nosotros">Sobre nosotros</a></li>
            <li><a href="{{ route('store.carrito') }}">Carrito</a></li>
        </ul>
    </nav>

    <section class="pie-pagina__columna" aria-labelledby="titulo-contacto-footer">
        <h2 class="pie-pagina__titulo" id="titulo-contacto-footer">Canales digitales</h2>
        <p class="pie-pagina__descripcion">Encuéntranos en las redes sociales de la tienda.</p>
        <div class="redes-sociales">
            <a href="https://www.instagram.com/deluxestoremajo?stkn=MXQ2NDFqejMweWdpYg==" aria-label="Instagram de Deluxe Store" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-instagram" aria-hidden="true"></i>
            </a>
            <a href="https://www.tiktok.com/@deluxestoremajo?_r=1&_t=ZS-9ALdsl9GegP" aria-label="TikTok de Deluxe Store" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-tiktok" aria-hidden="true"></i>
            </a>
        </div>
    </section>

    <div class="pie-pagina__inferior">© {{ date('Y') }} Deluxe Store</div>
</footer>
