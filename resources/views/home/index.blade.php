@extends('layouts.app')

@section('title', 'Deluxe Store')

@push('head')
    @vite(['assets/css/style.css', 'assets/js/script.js'])
@endpush

@section('content')
<main class="contenido-principal">
      <section class="nueva-coleccion" id="inicio">
        <div class="nueva-coleccion__texto">
          <h1 class="titulo">Nueva Colección</h1>
          <a href="{{ route('store.nuevo') }}" class="boton">Descubre más</a>
        </div>


      </section>

      <section class="mas-vendidos" id="catalogo">
  <div class="mas-vendidos__encabezado">
    <span class="mas-vendidos__etiqueta">SELECCIÓN DEL MOMENTO</span>
    <br>
    <h2 class="titulo">Más vendidos</h2>

    <p class="mas-vendidos__descripcion">
      Descubre los favoritos de nuestra colección y encuentra
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
        <span class="tarjeta-producto__categoria">Relojes · Hombre</span>

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
          alt="Reloj G-Fox automático"
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
          Reloj G-Fox Automático
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
      Explorar colección completa
      <i class="bi bi-arrow-right" aria-hidden="true"></i>
    </a>
  </div>
</section>
    </main>
@endsection
