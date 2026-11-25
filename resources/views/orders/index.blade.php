@extends('layouts.app')

@section('title', 'Mis pedidos - Deluxe Store')

@section('content')
<main class="contenido-carrito">
    <h1 class="titulo-carrito">MIS PEDIDOS</h1>

    @if($orders->isEmpty())
        <p>Aún no has realizado compras.</p>
    @else
        @foreach($orders as $order)
            <article class="carrito-item">
                <div class="carrito-item-info">
                    <h2>{{ $order->numero_pedido }}</h2>
                    <p>Estado: {{ $order->estado }}</p>
                    <p>Fecha: {{ $order->fecha_pedido?->format('d/m/Y H:i') }}</p>
                    <p>{{ $order->details_count }} producto(s)</p>
                </div>
                <p class="carrito-item-precios">
                    <span class="precio-actual">${{ number_format($order->total, 2, ',', '.') }}</span>
                </p>
                <a href="{{ route('orders.show', $order) }}" class="boton-continuar">Ver detalle</a>
            </article>
        @endforeach

        {{ $orders->links() }}
    @endif
</main>
@endsection
