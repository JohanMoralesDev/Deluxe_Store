@extends('layouts.admin')

@section('title', 'Pedidos | Deluxe Store')
@section('menu-pedidos', 'activo')

@section('content')
<div class="container-fluid">
    <header class="mb-4">
        <h1>Pedidos</h1>
        <p>Consulta pedidos y sus estados registrados.</p>
    </header>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-4">
        <div class="col-12 col-sm-8 col-md-5">
            <label for="pedido-estado" class="form-label">Estado</label>
            <select id="pedido-estado" name="estado" class="form-select">
                <option value="">Todos los estados</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ $estado }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-auto align-self-end"><button class="btn btn-success" type="submit">Filtrar pedidos</button></div>
    </form>

    <div class="card"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Pedido</th><th>Fecha</th><th>Estado</th><th>Estado de pago</th><th>Total</th><th></th></tr></thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->numero_pedido }}</td>
                    <td>{{ $order->fecha_pedido?->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->estado }}</td>
                    <td>{{ $order->estado_pago }}</td>
                    <td>${{ number_format((float) $order->total, 0, ',', '.') }}</td>
                    <td><a class="btn btn-sm btn-outline-success" href="{{ route('admin.orders.show', $order) }}">Consultar</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-4">No hay pedidos con ese criterio.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="card-body">{{ $orders->links() }}</div></div>
</div>
@endsection
