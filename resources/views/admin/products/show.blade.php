@extends('layouts.admin')

@section('title', 'Producto | Deluxe Store')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div><h1>{{ $product->nombre }}</h1><p>SKU: {{ $product->codigo_sku }}</p></div>
        <a class="btn btn-success" href="{{ route('admin.products.edit', $product) }}">Editar producto</a>
    </div>

    <div class="card"><div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Categoría</dt><dd class="col-sm-9">{{ $product->category?->nombre ?? 'Sin categoría' }}</dd>
            <dt class="col-sm-3">Precio</dt><dd class="col-sm-9">${{ number_format((float) $product->precio, 0, ',', '.') }}</dd>
            @if ($product->has_offer)
                <dt class="col-sm-3">Precio de oferta</dt><dd class="col-sm-9">${{ number_format((float) $product->precio_oferta, 0, ',', '.') }}</dd>
            @endif
            <dt class="col-sm-3">Existencias</dt><dd class="col-sm-9">{{ $product->inventory?->cantidad ?? 0 }}</dd>
            <dt class="col-sm-3">Estado</dt><dd class="col-sm-9">{{ $product->esta_activo ? 'Publicado' : 'Borrador / desactivado' }}</dd>
            <dt class="col-sm-3">Descripción</dt><dd class="col-sm-9">{{ $product->descripcion ?: 'Sin descripción.' }}</dd>
        </dl>
    </div></div>

    <a class="btn btn-outline-secondary mt-3" href="{{ route('admin.productos.index') }}">Volver a productos</a>
</div>
@endsection
