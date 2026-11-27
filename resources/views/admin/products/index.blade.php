@extends('layouts.admin')

@section('title', 'Productos | Deluxe Store')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h1>Gestión de productos</h1><p>Consulta los productos registrados en Deluxe Store.</p></div>
        <a class="btn btn-success" href="{{ route('admin.products.create') }}">Registrar producto</a>
    </div>

    <form action="{{ route('admin.productos.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="search" name="buscar" class="form-control" placeholder="Buscar por nombre o SKU..." value="{{ request('buscar') }}">
            <button type="submit" class="btn btn-dark"><i class="bi bi-search" aria-hidden="true"></i> Buscar</button>
        </div>
    </form>

    <div class="card"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Producto</th><th>SKU</th><th>Precio</th><th>Existencias</th><th>Stock mínimo</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->codigo_sku }}</td>
                    <td>${{ number_format((float) $producto->price, 0, ',', '.') }}</td>
                    <td>{{ $producto->inventory?->cantidad ?? 0 }}</td>
                    <td>{{ $producto->inventory?->stock_minimo ?? 5 }}</td>
                    <td>{{ $producto->esta_activo ? 'Publicado' : 'Borrador / desactivado' }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn btn-sm btn-outline-success" href="{{ route('admin.products.show', $producto) }}">Ver</a>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.products.edit', $producto) }}">Editar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4">No hay productos registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="card-body">{{ $productos->links() }}</div></div>
</div>
@endsection
