@extends('layouts.app')

@section('title', 'Detalle del pedido - Deluxe Store')

@section('content')
<main class="contenido-carrito">
    <h1 class="titulo-carrito">PEDIDO {{ $order->numero_pedido }}</h1>

    <p><strong>Estado:</strong> {{ $order->estado }}</p>
    <p><strong>Pago:</strong> {{ $order->estado_pago }}</p>
    <p><strong>Método de pago:</strong> {{ $order->metodo_pago }}</p>
    <p><strong>Destinatario:</strong> {{ $order->nombre_destinatario }}</p>
    <p><strong>Dirección:</strong> {{ $order->direccion_envio }}, {{ $order->ciudad_envio }}, {{ $order->departamento_envio }}</p>

    <section>
        @foreach($order->details as $detail)
            <article class="carrito-item">
                <div class="carrito-item-info">
                    <h2>{{ $detail->nombre_producto }}</h2>
                    <p>SKU: {{ $detail->codigo_sku }}</p>
                    <p>Cantidad: {{ $detail->cantidad }}</p>
                    <p>Precio unitario: ${{ number_format($detail->precio_unitario, 2, ',', '.') }}</p>
                </div>
                <p class="precio-actual">${{ number_format($detail->subtotal, 2, ',', '.') }}</p>
            </article>
        @endforeach
    </section>

    <h2>Total: ${{ number_format($order->total, 2, ',', '.') }}</h2>
    <a href="{{ route('orders.index') }}" class="boton-continuar">Volver al historial</a>
</main>
@endsection
