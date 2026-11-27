@extends('layouts.app')

@section('title', 'Carrito - Deluxe Store')

@push('head')
    @vite(['public/assets/css/carrito.css'])
@endpush

@section('content')
<main class="contenido-carrito">
    <h1 class="titulo-carrito">TU CARRITO</h1>

    @foreach($issues as $issue)
        <p class="alerta alerta-error">{{ $issue }}</p>
    @endforeach

    @if(empty($items))
        <section class="carrito-vacio">
            <p>Tu carrito está vacío.</p>
            <a href="{{ route('store.catalogo') }}" class="boton-continuar">Ir al catálogo</a>
        </section>
    @else
        <div class="carrito-layout">
            <section class="carrito-lista" aria-label="Productos en el carrito">
                @foreach($items as $item)
                    @php($product = $item['product'])
                    <article class="carrito-item">
                        <div class="carrito-item-imagen">
                            @if($product->url_imagen)
                                <img src="{{ asset($product->url_imagen) }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('assets/Imagenes/Logo.png') }}" alt="{{ $product->name }}">
                            @endif
                        </div>

                        <div class="carrito-item-info">
                            <h2 class="carrito-item-nombre">{{ $product->name }}</h2>
                            <p class="carrito-item-descripcion">{{ $product->descripcion }}</p>

                            <form method="POST" action="{{ route('cart.update', $product) }}" class="carrito-item-acciones">
                                @csrf
                                @method('PATCH')
                                <label>
                                    Cantidad
                                    <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="{{ $item['quantity'] }}" required>
                                </label>
                                <button type="submit" class="boton-continuar">Actualizar</button>
                            </form>

                            <form method="POST" action="{{ route('cart.remove', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="boton-eliminar">
                                    <i class="bi bi-trash3"></i> Eliminar
                                </button>
                            </form>
                        </div>

                        <p class="carrito-item-precios">
                            <span class="precio-actual">${{ number_format($item['subtotal'], 2, ',', '.') }}</span>
                        </p>
                    </article>
                @endforeach
            </section>

            <aside class="resumen-pedido">
                <h2 class="resumen-titulo">Resumen del pedido</h2>
                <dl class="resumen-detalle">
                    <div class="resumen-fila">
                        <dt>Subtotal</dt>
                        <dd>${{ number_format($total, 2, ',', '.') }}</dd>
                    </div>
                    <div class="resumen-fila">
                        <dt>Envio</dt>
                        <dd>Gratis</dd>
                    </div>
                </dl>
                <div class="resumen-fila resumen-total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2, ',', '.') }}</span>
                </div>

                @auth
                    <a href="{{ route('checkout') }}" class="boton-pagar">Proceder al pago</a>
                @else
                    <p>Inicia sesion para finalizar tu compra.</p>
                @endauth
                <a href="{{ route('store.catalogo') }}" class="boton-continuar">Continuar comprando</a>

                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton-eliminar">Vaciar carrito</button>
                </form>
            </aside>
        </div>
    @endif
</main>
@endsection
