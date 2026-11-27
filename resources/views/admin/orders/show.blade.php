@extends('layouts.admin')

@section('title', 'Detalle de pedido | Deluxe Store')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div><h1>Pedido {{ $order->numero_pedido }}</h1><p>{{ $order->fecha_pedido?->format('d/m/Y H:i') }}</p></div>
        <a class="btn btn-outline-secondary" href="{{ route('admin.orders.index') }}">Volver a pedidos</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3"><div class="card h-100"><div class="card-body"><strong>Estado</strong><p class="mb-0">{{ $order->estado }}</p></div></div></div>
        <div class="col-12 col-sm-6 col-lg-3"><div class="card h-100"><div class="card-body"><strong>Estado de pago</strong><p class="mb-0">{{ $order->estado_pago }}</p></div></div></div>
        <div class="col-12 col-sm-6 col-lg-3"><div class="card h-100"><div class="card-body"><strong>Método de pago</strong><p class="mb-0">{{ $order->metodo_pago ?: 'No registrado' }}</p></div></div></div>
        <div class="col-12 col-sm-6 col-lg-3"><div class="card h-100"><div class="card-body"><strong>Total</strong><p class="mb-0">${{ number_format((float) $order->total, 0, ',', '.') }}</p></div></div></div>
    </div>

    <section class="card" aria-labelledby="titulo-lineas-pedido">
        <div class="card-header" id="titulo-lineas-pedido">Productos del pedido</div>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0">
            <thead><tr><th>Producto</th><th>SKU</th><th>Cantidad</th><th>Precio unitario</th><th>Subtotal</th></tr></thead>
            <tbody>
            @forelse ($order->details as $detail)
                <tr><td>{{ $detail->nombre_producto }}</td><td>{{ $detail->codigo_sku }}</td><td>{{ $detail->cantidad }}</td><td>${{ number_format((float) $detail->precio_unitario, 0, ',', '.') }}</td><td>${{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td></tr>
            @empty
                <tr><td colspan="5" class="text-center py-4">El pedido no tiene líneas registradas.</td></tr>
            @endforelse
            </tbody>
        </table></div>
    </section>
</div>
@endsection
