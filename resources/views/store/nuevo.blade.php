@extends('layouts.app')

@section('title', 'Nuevos modelos | Deluxe Store')

@push('head')
    @vite(['public/assets/css/nuevo.css'])
@endpush

@section('content')
<main class="contenido-nuevo">
    <section class="nuevo-modelo" id="nuevo" aria-labelledby="titulo-nuevo">
        <img src="{{ asset('assets/images/store/Rolex.jpeg') }}" alt="Relojes de la colección Deluxe Store" />
        <div class="contenedor-texto">
            <h1 class="titulo-nuevo" id="titulo-nuevo">Nuevos modelos</h1>
            <p class="subtitulo-nuevo">Consulta las incorporaciones más recientes</p>
        </div>
    </section>

    <p class="frase-nuevo">Explora los modelos agregados recientemente al catálogo.</p>

    <section class="nuevos-productos" aria-label="Productos recientes">
        @forelse ($products as $product)
            <article class="producto-nuevo">
                <div class="producto-nuevo__imagen">
                    <a href="{{ route('products.show', $product) }}" aria-label="Ver {{ $product->nombre }}">
                        <img src="{{ $product->image_url }}" alt="{{ $product->nombre }}" loading="lazy" />
                    </a>
                    @if ($product->has_offer)
                        @php($descuento = (int) round((($product->precio - $product->price) / $product->precio) * 100))
                        <span class="descuento">-{{ $descuento }}%</span>
                    @endif
                </div>

                <h2 class="producto-nuevo__nombre">{{ $product->nombre }}</h2>
                <p class="producto-nuevo__precio">
                    <span class="precio-actual">${{ number_format($product->price, 0, ',', '.') }}</span>
                    @if ($product->has_offer)
                        <del class="precio-anterior">${{ number_format($product->precio, 0, ',', '.') }}</del>
                    @endif
                </p>

                @if ($product->stock > 0)
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button type="submit" class="boton producto-nuevo__boton">Añadir al carrito</button>
                    </form>
                @else
                    <button type="button" class="boton producto-nuevo__boton" disabled>Agotado</button>
                @endif
            </article>
        @empty
            <p>No hay productos recientes para mostrar.</p>
        @endforelse
    </section>

    {{ $products->links() }}
</main>
@endsection
