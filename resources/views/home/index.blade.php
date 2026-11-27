@extends('layouts.app')

@section('title', 'Deluxe Store')

@php($productosDestacados = $productosDestacados ?? collect())

@section('content')
<main class="contenido-principal">
    <section class="nueva-coleccion" id="inicio">
        <div class="nueva-coleccion__texto">
            <h1 class="titulo">Nueva Colección</h1>
            <a href="{{ route('store.nuevo') }}" class="boton">Descubre las novedades <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
    </section>

    <section class="mas-vendidos" id="catalogo" aria-labelledby="titulo-mas-vendidos">
        <div class="mas-vendidos__encabezado">
            <span class="mas-vendidos__etiqueta">SELECCIÓN DEL MOMENTO</span>
            <br>
            <h2 class="titulo" id="titulo-mas-vendidos">Más vendidos</h2>
            <p class="mas-vendidos__descripcion">Una selección aleatoria de productos activos disponibles.</p>
        </div>

        @if ($productosDestacados->isNotEmpty())
            <div class="productos">
                @foreach ($productosDestacados as $product)
                    <article class="tarjeta-producto">
                        <div class="tarjeta-producto__imagen">
                            <a href="{{ route('products.show', $product) }}" aria-label="Ver {{ $product->nombre }}">
                                <img src="{{ $product->image_url }}" alt="{{ $product->nombre }}" loading="lazy">
                            </a>
                            @if ($product->has_offer)
                                @php($descuento = (int) round((($product->precio - $product->price) / $product->precio) * 100))
                                <span class="producto-etiqueta">-{{ $descuento }}%</span>
                            @endif
                            <a href="{{ route('products.show', $product) }}" class="producto-accion">
                                <i class="bi bi-eye" aria-hidden="true"></i> Conoce este producto
                            </a>
                        </div>

                        <div class="tarjeta-producto__contenido">
                            <span class="tarjeta-producto__categoria">{{ $product->category?->nombre ?? 'Relojes' }}</span>
                            <h3 class="tarjeta-producto__nombre">{{ $product->nombre }}</h3>
                            <div class="tarjeta-producto__precios">
                                <span class="precio-actual">${{ number_format($product->price, 0, ',', '.') }}</span>
                                @if ($product->has_offer)
                                    <del class="precio-anterior">${{ number_format($product->precio, 0, ',', '.') }}</del>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="mas-vendidos__descripcion">Aún no hay productos disponibles para mostrar.</p>
        @endif

        <div class="mas-vendidos__pie">
            <a href="{{ route('store.catalogo') }}" class="boton boton--catalogo">
                Explorar colección completa
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
</main>
@endsection
