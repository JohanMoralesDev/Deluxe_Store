@extends('layouts.admin')
@section('title', $category->nombre.' | Deluxe Store')
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h1>{{ $category->nombre }}</h1><p>{{ $category->descripcion ?: 'Sin descripción.' }}</p></div>
        <a class="btn btn-success" href="{{ route('admin.categories.edit', $category) }}">Editar categoría</a>
    </div>
    <div class="card"><div class="card-header">Productos asociados</div><div class="table-responsive">
        <table class="table align-middle mb-0"><thead><tr><th>Producto</th><th>SKU</th><th>Estado</th></tr></thead>
            <tbody>@forelse ($category->products as $product)
                <tr><td>{{ $product->nombre }}</td><td>{{ $product->codigo_sku }}</td><td>{{ $product->esta_activo ? 'Activo' : 'Inactivo' }}</td></tr>
            @empty<tr><td colspan="3" class="text-center py-4">No hay productos asociados.</td></tr>@endforelse</tbody>
        </table>
    </div></div>
    <a class="btn btn-outline-secondary mt-3" href="{{ route('admin.categories.index') }}">Volver a categorías</a>
</div>
@endsection
