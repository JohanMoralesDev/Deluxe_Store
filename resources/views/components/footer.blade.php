<footer class="pie-pagina" id="sobre-nosotros" aria-labelledby="titulo-footer">
    <section class="pie-pagina__marca" aria-labelledby="titulo-footer">
        <div class="pie-pagina__marca-cabecera">
            <a href="{{ route('store.index') }}" class="logo-tienda" aria-label="Deluxe Store, inicio">
                <img src="{{ asset('assets/images/store/Logo.png') }}" alt="">
            </a>
            <h2 class="pie-pagina__nombre" id="titulo-footer">DELUXE STORE</h2>
        </div>

        <div class="redes-sociales" role="group" aria-label="Redes sociales de Deluxe Store">
            <a href="https://www.instagram.com/deluxestoremajo?stkn=MXQ2NDFqejMweWdpYg==" aria-label="Instagram de Deluxe Store" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-instagram" aria-hidden="true"></i>
            </a>
            <a href="https://www.tiktok.com/@deluxestoremajo?_r=1&_t=ZS-9ALdsl9GegP" aria-label="TikTok de Deluxe Store" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-tiktok" aria-hidden="true"></i>
            </a>
        </div>

        <p class="pie-pagina__desarrollo">Desarrollado por Zentrix</p>
    </section>

    <nav class="pie-pagina__columna" aria-labelledby="titulo-soporte-footer">
        <h2 class="pie-pagina__titulo" id="titulo-soporte-footer">SOPORTE Y AYUDA</h2>
        <ul class="pie-pagina__enlaces">
            <li><span>Preguntas Frecuentes</span></li>
            <li><span>Contacto</span></li>
            <li><span>Garantías</span></li>
            <li><span>Seguridad en Compras</span></li>
            <li><span>Mapa del Sitio</span></li>
        </ul>
    </nav>

    <nav class="pie-pagina__columna" aria-labelledby="titulo-informacion-footer">
        <h2 class="pie-pagina__titulo" id="titulo-informacion-footer">INFORMACIÓN DE LA TIENDA</h2>
        <ul class="pie-pagina__enlaces">
            <li><span>Información General</span></li>
            <li><span>Métodos de Envío</span></li>
            <li><span>Políticas de Privacidad</span></li>
            <li><span>Términos y Condiciones</span></li>
            <li><span>Cambios y Devoluciones</span></li>
        </ul>
    </nav>

    <div class="pie-pagina__inferior">
        <span class="pie-pagina__inferior-marca">Deluxe Store <span class="pie-pagina__separador" aria-hidden="true">|</span></span>
        <span class="pie-pagina__copyright">© {{ date('Y') }} Deluxe Store. Todos los derechos reservados.</span>
    </div>
</footer>
