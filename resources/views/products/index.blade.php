@extends('layouts.app')

@section('title', 'Catálogo - Deluxe Store')

@push('head')
    @vite(['public/assets/css/catalogo.css'])
@endpush

@section('content')
<main class="contenido-catalogo">
  <h1 class="titulo-catalogo">TODA NUESTRA COLECCIÓN</h1>

  <form method="GET" action="{{ route('store.catalogo') }}" class="arrow">
    <div class="column-xs-12">
      <div class="arrow_container">
        <a href="{{ route('store.catalogo') }}" @class(['arrow_text', 'filtro-opcion', 'activo' => ! request('nuevos')])>Todos</a>
      </div>
      <div class="arrow_container">
        <a href="{{ route('store.catalogo', ['nuevos' => 1]) }}" @class(['arrow_text', 'filtro-opcion', 'activo' => request('nuevos')])>Nuevos modelos</a>
      </div>
      <div class="arrow_container">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar reloj..." aria-label="Buscar productos del catálogo">
      </div>
      <div class="arrow_container">
        <label class="arrow_text" for="categoria">Colección</label>
        <select class="filtro" id="categoria" name="categoria" onchange="this.form.submit()">
          <option value="">Todas las colecciones</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id_categoria }}" @selected(request('categoria') == $cat->id_categoria)>{{ $cat->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div class="arrow_container">
        <label class="arrow_text" for="tamano">Tamaños</label>
        <select class="filtro" id="tamano" name="tamano" onchange="this.form.submit()">
          <option value="">Todos los tamaños</option>
          @foreach (['pequeno' => 'Pequeño', 'mediano' => 'Mediano', 'grande' => 'Grande'] as $v => $label)
            <option value="{{ $v }}" @selected(request('tamano') === $v)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="arrow_container">
        <label class="arrow_text" for="publico">Público</label>
        <select class="filtro" id="publico" name="publico" onchange="this.form.submit()">
          <option value="">Todos</option>
          @foreach (['dama' => 'Dama', 'caballero' => 'Caballero', 'ninos' => 'Niños', 'unisex' => 'Unisex'] as $v => $label)
            <option value="{{ $v }}" @selected(request('publico') === $v)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="arrow_container">
        <label class="arrow_text" for="orden">Ordenar</label>
        <select class="filtro" id="orden" name="orden" onchange="this.form.submit()">
          <option value="">Más recientes</option>
          <option value="precio_asc" @selected(request('orden') === 'precio_asc')>Precio: menor a mayor</option>
          <option value="precio_desc" @selected(request('orden') === 'precio_desc')>Precio: mayor a menor</option>
        </select>
      </div>
    </div>
  </form>

  <section class="row catalogo-productos" aria-label="Productos disponibles">
    @forelse ($products as $product)
      <article class="product-box" aria-labelledby="producto-{{ $product->getKey() }}">
        <div class="product-box__media">
          <a class="product-box__imagen-enlace" href="{{ route('products.show', $product) }}" aria-label="Ver detalles de {{ $product->nombre }}">
            <img class="product-box__imagen" src="{{ $product->image_url }}" alt="{{ $product->nombre }}" loading="lazy" decoding="async">
          </a>
          @if ($product->has_offer)
            <span class="offer" aria-label="Oferta, {{ $product->discount_percent }} por ciento de descuento">
              <span>OFERTA</span><span>-{{ $product->discount_percent }}%</span>
            </span>
          @endif
        </div>

        <div class="product-box__contenido">
          @if ($product->category)
            <p class="product-box__categoria">{{ $product->category->nombre }}</p>
          @endif
          <h2 id="producto-{{ $product->getKey() }}" class="product-box__nombre">{{ $product->nombre }}</h2>

          @if (filled($product->descripcion))
            <p class="product-box__descripcion">{{ Str::limit($product->descripcion, 100) }}</p>
          @endif

          <div class="product-box__precios" aria-label="Precio del producto">
            <strong class="product-price">${{ number_format($product->price, 0, ',', '.') }}</strong>
            @if ($product->has_offer)
              <del class="precio-anterior" aria-label="Precio original">${{ number_format((float) $product->precio, 0, ',', '.') }}</del>
            @endif
          </div>

          <p class="product-box__disponibilidad {{ $product->inventory && $product->stock > 0 ? 'disponible' : ($product->inventory ? 'agotado' : 'por-confirmar') }}">
            @if ($product->inventory)
              @if ($product->stock > 0)
                <i class="bi bi-check-circle" aria-hidden="true"></i> Disponible · {{ $product->stock }} unidades
              @else
                <i class="bi bi-x-circle" aria-hidden="true"></i> Agotado
              @endif
            @else
              <i class="bi bi-info-circle" aria-hidden="true"></i> Existencias por confirmar
            @endif
          </p>

          <div class="product-box__acciones">
            <a class="product-box__detalle" href="{{ route('products.show', $product) }}">Ver detalles</a>
            @if ($product->stock > 0)
              <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button type="submit" class="agregar-carrito">
                  <i class="bi bi-cart-plus" aria-hidden="true"></i> Añadir al carrito
                </button>
              </form>
            @else
              <button type="button" class="agregar-carrito" disabled>
                {{ $product->inventory ? 'Agotado' : 'Existencias por confirmar' }}
              </button>
            @endif
          </div>
        </div>
      </article>
    @empty
      <p class="catalogo-vacio">No se encontraron relojes con esos criterios.</p>
    @endforelse
  </section>
</main>
@endsection
