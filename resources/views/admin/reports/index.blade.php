@extends('layouts.admin')

@section('title', 'Informes | Deluxe Store')
@section('menu-reportes', 'activo')

@section('content')
<div class="container-fluid">
    <header class="mb-4">
        <h1>Informes</h1>
        <p>Resumen calculado a partir de los productos, inventario, pedidos y líneas registradas.</p>
    </header>

    <section class="row g-3 mb-4" aria-label="Indicadores generales">
        <div class="col-12 col-sm-6 col-xl-3"><article class="card h-100"><div class="card-body"><h2 class="h6">Productos registrados</h2><p class="display-6 mb-0">{{ $totalProductos }}</p><small>{{ $productosActivos }} activos</small></div></article></div>
        <div class="col-12 col-sm-6 col-xl-3"><article class="card h-100"><div class="card-body"><h2 class="h6">Stock bajo o mínimo</h2><p class="display-6 mb-0">{{ $productosStockBajo }}</p></div></article></div>
        <div class="col-12 col-sm-6 col-xl-3"><article class="card h-100"><div class="card-body"><h2 class="h6">Pedidos registrados</h2><p class="display-6 mb-0">{{ $totalPedidos }}</p></div></article></div>
        <div class="col-12 col-sm-6 col-xl-3"><article class="card h-100"><div class="card-body"><h2 class="h6">Suma de pedidos</h2><p class="h3 mb-0">${{ number_format($totalPedidosRegistrados, 0, ',', '.') }}</p><small>Incluye pedidos de cualquier estado de pago.</small></div></article></div>
    </section>

    <div class="row g-4">
        <section class="col-12 col-xl-5" aria-labelledby="titulo-estados-pago">
            <div class="card h-100"><div class="card-header" id="titulo-estados-pago">Pedidos por estado de pago</div>
                <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Estado</th><th>Pedidos</th><th>Total</th></tr></thead><tbody>
                    @forelse ($totalesPorEstadoPago as $row)
                        <tr><td>{{ $row->estado_pago }}</td><td>{{ $row->cantidad_pedidos }}</td><td>${{ number_format((float) $row->total_pedidos, 0, ',', '.') }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">Aún no hay pedidos.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </section>

        <section class="col-12 col-xl-7" aria-labelledby="titulo-top-pedidos">
            <div class="card h-100"><div class="card-header" id="titulo-top-pedidos">Unidades registradas en líneas de pedido</div>
                <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Producto</th><th>SKU</th><th>Unidades</th></tr></thead><tbody>
                    @forelse ($productosMasSolicitados as $product)
                        <tr><td>{{ $product->nombre }}</td><td>{{ $product->codigo_sku }}</td><td>{{ $product->unidades }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">Aún no hay líneas de pedido.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </section>
    </div>
</div>
@endsection
