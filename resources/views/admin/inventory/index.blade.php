@extends('layouts.admin')

@section('title', 'Inventario | Deluxe Store')
@section('menu-inventario', 'activo')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Inventario</h1>
        <p>Consulta existencias y registra movimientos.</p>
    </div>

    <div class="card mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Producto</th><th>SKU</th><th>Existencias</th><th>Mínimo</th><th>Registrar movimiento</th></tr></thead>
                <tbody>
                @forelse ($productos as $product)
                    <tr>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->codigo_sku }}</td>
                        <td>{{ $product->inventory?->cantidad ?? 0 }}</td>
                        <td>{{ $product->inventory?->stock_minimo ?? 5 }}</td>
                        <td>
                            <form class="d-flex flex-wrap gap-2 align-items-end" method="POST" action="{{ route('admin.inventory.movements.store', $product) }}">
                                @csrf
                                <label class="small">Tipo
                                    <select class="form-select form-select-sm" name="tipo" required>
                                        <option value="ENTRADA">Entrada</option>
                                        <option value="SALIDA">Salida</option>
                                        <option value="AJUSTE">Ajustar existencia</option>
                                    </select>
                                </label>
                                <label class="small">Cantidad / existencia final
                                    <input class="form-control form-control-sm" type="number" name="cantidad" min="0" required>
                                </label>
                                <label class="small">Descripción
                                    <input class="form-control form-control-sm" type="text" name="descripcion" maxlength="500">
                                </label>
                                <button class="btn btn-sm btn-success" type="submit">Guardar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">No hay productos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">{{ $productos->links() }}</div>
    </div>

    <section id="movimientos" aria-labelledby="titulo-movimientos">
        <h2 id="titulo-movimientos">Movimientos recientes</h2>
        <div class="card"><div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th>Cantidad</th><th>Existencia resultante</th><th>Responsable</th><th>Descripción</th></tr></thead>
                <tbody>
                @forelse ($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->fecha_movimiento?->format('d/m/Y H:i') }}</td>
                        <td>{{ $movimiento->product?->nombre ?? 'Producto no disponible' }}</td>
                        <td>{{ $movimiento->tipo_movimiento }}</td>
                        <td>{{ $movimiento->cantidad }}</td>
                        <td>{{ $movimiento->stock_nuevo }}</td>
                        <td>{{ $movimiento->user?->nombre ?? 'Sistema' }}</td>
                        <td>{{ $movimiento->descripcion ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4">Aún no hay movimientos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div></div>
    </section>
</div>
@endsection
