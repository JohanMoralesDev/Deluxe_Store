@extends('layouts.app')

@section('title', $product->nombre.' - Deluxe Store')

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/css/Catalogo.css') }}">
@endpush

@section('content')
<div class="contenido-catalogo">
  <a href="{{ route('store.catalogo') }}">← Volver al catálogo</a>

  <div class="row">
    <div class="col-m-6">
      <img src="{{ $product->image_url }}" alt="{{ $product->nombre }}" style="max-width:100%">
    </div>

    <div class="col-m-6">
      <h1>{{ $product->nombre }}</h1>
      <p>Colección: {{ $product->category?->nombre }} · Público: {{ ucfirst($product->publico) }}</p>
      @if ($product->color)<p>Color: {{ $product->color }}</p>@endif
      <p>{{ $product->descripcion }}</p>
      <p>SKU: {{ $product->codigo_sku }}</p>

      <strong class="product-price">${{ number_format($product->price, 0, ',', '.') }}
        @if ($product->has_offer)
          <del class="precio-anterior">${{ number_format($product->precio, 0, ',', '.') }}</del>
        @endif
      </strong>

      <form method="POST" action="{{ route('cart.add', $product) }}">
        @csrf
        <button type="submit" class="agregar-carrito"><i class="bi bi-cart-plus"></i> Añadir al carrito</button>
      </form>
    </div>
  </div>

  @if ($related->isNotEmpty())
    <h2>Más de esta colección</h2>
    <div class="row">
      @foreach ($related as $item)
        <article class="col-m-3 col-s-6 product-box">
          <a href="{{ route('products.show', $item) }}">
            <img src="{{ $item->image_url }}" alt="{{ $item->nombre }}">
            <h3>{{ $item->nombre }}</h3>
          </a>
        </article>
      @endforeach
    </div>
  @endif
</div>
@endsection