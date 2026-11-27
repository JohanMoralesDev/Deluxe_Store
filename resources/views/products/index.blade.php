@extends('layouts.app')

@section('title', 'Catálogo - Deluxe Store')

@push('head')
    @vite(['public/assets/css/catalogo.css'])
@endpush

@section('content')
<div class="contenido-catalogo">
  <h1 class="titulo-catalogo">TODA NUESTRA COLECCIÓN</h1>

  <form method="GET" action="{{ route('store.catalogo') }}" class="arrow">
    <div class="column-xs-12">

      <div class="arrow_container">
        <a href="{{ route('store.catalogo') }}"
           @class(['arrow_text', 'filtro-opcion', 'activo' => ! request('nuevos')])>Todos</a>
      </div>

      <div class="arrow_container">
        <a href="{{ route('store.catalogo', ['nuevos' => 1]) }}"
           @class(['arrow_text', 'filtro-opcion', 'activo' => request('nuevos')])>Nuevos modelos</a>
      </div>

      <div class="arrow_container">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar reloj...">
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
          @foreach (['dama' => 'Dama', 'caballero' => 'Caballero', 'ninos' => 'Niños'] as $v => $label)
            <option value="{{ $v }}" @selected(request('publico') === $v)>{{ $label }}</option>
          @endforeach
        </select>
      </div>

      <div class="arrow_container">
        <label class="arrow_text" for="orden">Ordenar</label>
        <select class="filtro" id="orden" name="orden" onchange="this.form.submit()">
          <option value="">Más recientes</option>
          <option value="precio_asc"  @selected(request('orden') === 'precio_asc')>Precio: menor a mayor</option>
          <option value="precio_desc" @selected(request('orden') === 'precio_desc')>Precio: mayor a menor</option>
        </select>
      </div>

    </div>
  </form>

  <div class="row">
    @forelse ($products as $product)
      <article class="col-m-4 col-s-6 product-box">
        <a href="{{ route('products.show', $product) }}">
          <img src="{{ $product->image_url }}" alt="{{ $product->nombre }}">
        </a>

        @if ($product->has_offer)
          <div class="offer">OFERTA</div>
        @endif

        <h2><a href="{{ route('products.show', $product) }}">{{ $product->nombre }}</a></h2>
        <p class="descripcion">{{ Str::limit($product->descripcion, 70) }}</p>

        <strong class="product-price">${{ number_format($product->price, 0, ',', '.') }}
          @if ($product->has_offer)
            <del class="precio-anterior">${{ number_format($product->precio, 0, ',', '.') }}</del>
          @endif
        </strong>

        <form method="POST" action="{{ route('cart.add', $product) }}">
          @csrf
          <button type="submit" class="agregar-carrito">
            <i class="bi bi-cart-plus"></i> Añadir al carrito
          </button>
        </form>
      </article>
    @empty
      <p>No se encontraron relojes con esos criterios.</p>
    @endforelse
  </div>

  {{ $products->links() }}
</div>
@endsection
