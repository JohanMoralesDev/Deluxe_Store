@extends('layouts.app')

@section('title', 'Catálogo - Deluxe Store')

@push('head')
    @vite(['assets/css/Catalogo.css', 'assets/css/style.css', 'assets/js/script.js'])
@endpush

@section('content')
<div class="contenido-catalogo">
      <h1 class="titulo-catalogo">TODA NUESTRA COLECCIÓN</h1>

      <div class="arrow">
    <div class="column-xs-12">

        <!-- Mostrar todos los productos -->
        <div class="arrow_container">
            <button type="button"
                    class="arrow_text filtro-opcion activo"
                    data-filtro="todos"
                    aria-pressed="true">
                Todos
            </button>
        </div>

        <!-- Ordenar por fecha de incorporación -->
        <div class="arrow_container">
            <button type="button"
                    class="arrow_text filtro-opcion"
                    data-filtro="nuevos"
                    aria-pressed="false">
                Nuevos modelos
            </button>
        </div>

        <!-- Filtrar por colección -->
        <div class="arrow_container">
            <label class="arrow_text" for="filtroColeccion">
                Colección
            </label>

            <select class="filtro" id="filtroColeccion">
                <option value="todas">Todas las colecciones</option>
                <option value="clasica">Clásica</option>
                <option value="elegante">Elegante</option>
                <option value="deportiva">Deportiva</option>
            </select>
        </div>

        <!-- Filtrar por tamaño de esfera -->
        <div class="arrow_container">
            <label class="arrow_text" for="filtroTamano">
                Tamaños
            </label>

            <select class="filtro" id="filtroTamano">
                <option value="todos">Todos los tamaños</option>
                <option value="pequeno">Pequeño</option>
                <option value="mediano">Mediano</option>
                <option value="grande">Grande</option>
            </select>
        </div>

        <!-- Filtrar por público -->
        <div class="arrow_container">
            <label class="arrow_text" for="filtroPublico">
                Público
            </label>

            <select class="filtro" id="filtroPublico">
                <option value="todos">Todos</option>
                <option value="dama">Dama</option>
                <option value="caballero">Caballero</option>
                <option value="ninos">Niños</option>
            </select>
        </div>

    </div>
</div>

      <div class="row">

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-curren-hombre"
      data-nombre="Curren" data-publico="caballero" data-coleccion="clasica" data-tamano="1" data-fecha="2025-11-06"
      data-precio="160000" data-precio-anterior="175000">
        <img src="{{ asset('assets/images/store/Curren-Hombre.jpeg') }}" alt="Reloj marca Curren para hombre"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj marca Curren para caballero</h2>
        <strong class="product-price">$160.000,00<del class="precio-anterior">$175.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-curren-dama" data-nombre="Curren"
      data-publico="dama" data-coleccion="elegante" data-tamano="1" data-fecha="2025-08-29"
      data-precio="130000" data-precio-anterior="136000">
        <img src="{{ asset('assets/images/store/Curren-Dama.jpeg') }}" alt="Curren para mujer"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj marca Curren para mujer</h2>
        <strong class="product-price">$130.000,00<del class="precio-anterior">$136.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-qq" data-nombre="Q&Q"
      data-publico="caballero" data-coleccion="clasica" data-tamano="1" data-fecha="2026-03-01"
      data-precio="86000" data-precio-anterior="90000">
        <img src="{{ asset('assets/images/store/Q&Q.jpeg') }}" alt="Reloj marca Q&Q"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj marca Q&Q</h2>
        <strong class="product-price">$86.000,00<del class="precio-anterior">$90.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-rolex" data-nombre="Rolex"
      data-publico="caballero" data-coleccion="elegante" data-tamano="1" data-fecha="2026-06-15"
      data-precio="120000" data-precio-anterior="135000">
        <img src="{{ asset('assets/images/store/Rolex.jpeg') }}" alt="Rolex para hombre"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj marca Rolex para caballero</h2>
        <strong class="product-price">$120.000,00<del class="precio-anterior">$135.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-calvin-klein" data-nombre="Calvin Klein"
      data-publico="caballero" data-coleccion="elegante" data-tamano="1" data-fecha="2025-06-06"
      data-precio="20000" data-precio-anterior="25000">
        <img src="{{ asset('assets/images/store/Calvin-Klein.jpeg') }}" alt="Reloj Calvin Klein para hombre"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj marca Calvin Klein para caballero</h2>
        <strong class="product-price">$20.000,00<del class="precio-anterior">$25.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-pandora" data-nombre="Pandora"
      data-publico="dama" data-coleccion="elegante" data-tamano="1" data-fecha="2025-12-09"
      data-precio="35000" data-precio-anterior="38000">
        <img src="{{ asset('assets/images/store/Pandora.jpeg') }}" alt="Reloj Pandora"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj marca Pandora para dama</h2>
        <strong class="product-price">$35.000,00<del class="precio-anterior">$38.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-naviforce" data-nombre="Naviforce"
      data-publico="caballero" data-coleccion="deportiva" data-tamano="1" data-fecha="2026-09-14"
      data-precio="115000" data-precio-anterior="136000">
        <img src="{{ asset('assets/images/store/Naviforce.jpeg') }}" alt="Reloj Naviforce"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj Naviforce para caballero</h2>
        <strong class="product-price">$115.000,00<del class="precio-anterior">$136.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-qubano" data-nombre="Qubano"
     data-publico="caballero" data-coleccion="clasica" data-tamano="1" data-fecha="2026-02-16"
     data-precio="86000" data-precio-anterior="90000">
        <img src="{{ asset('assets/images/store/Qubano.jpeg') }}" alt="Reloj Qubano"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj Cubano para caballero</h2>
        <strong class="product-price">$86.000,00<del class="precio-anterior">$90.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-fairwhale" data-nombre="FairWhale"
     data-publico="caballero" data-coleccion="clasica" data-tamano="1" data-fecha="2025-05-08"
     data-precio="160000" data-precio-anterior="175000">
        <img src="{{ asset('assets/images/store/FairWhale.jpeg') }}" alt="Reloj FairWhale"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj FairWhale para caballero</h2>
        <strong class="product-price">$160.000,00<del class="precio-anterior">$175.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-g-fox-automatico" data-nombre="G-Fox Automático"
     data-publico="caballero" data-coleccion="elegante" data-tamano="1" data-fecha="2025-09-18"
     data-precio="140000" data-precio-anterior="145000">
        <img src="{{ asset('assets/images/store/G-Fox-Automatico.jpeg') }}" alt="Reloj G-Fox Automático"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj G-Fox Automático para caballero</h2>
        <strong class="product-price">$140.000,00<del class="precio-anterior">$145.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>

      <article class="col-m-4 col-s-6 product-box" data-id="reloj-foxbox" data-nombre="FoxBox"
      data-publico="caballero" data-coleccion="deportiva" data-tamano="1" data-fecha="2025-03-26"
      data-precio="145000" data-precio-anterior="150000">
        <img src="{{ asset('assets/images/store/FoxBox.jpeg') }}" alt="Reloj FoxBox"/>
        <div class="hidden offer">OFERTA</div>
        <h2>Reloj FoxBox para caballero</h2>
        <strong class="product-price">$145.000,00<del class="precio-anterior">$150.000,00</del></strong>
        <button type="button" class="agregar-carrito">
          <i class="bi bi-cart-plus"></i>
          Añadir al carrito</button>
      </article>
      </div>
    </div>

    <!-- Pie de página -->
@endsection
