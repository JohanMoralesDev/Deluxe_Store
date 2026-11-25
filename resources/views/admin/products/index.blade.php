@extends('layouts.admin')

@section('title', 'Productos | Deluxe Store')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Gestión de productos</h1>
            <p>Consulta los productos registrados en Deluxe Store.</p>
        </div>
    </div>

    {{-- Buscador --}}
    <form action="{{ route('admin.productos.index') }}"
          method="GET"
          class="mb-4">

        <div class="input-group">

            <input
                type="search"
                name="buscar"
                class="form-control"
                placeholder="Buscar por nombre o SKU..."
                value="{{ request('buscar') }}"
            >

            <button type="submit" class="btn btn-dark">
                <i class="bi bi-search"></i>
                Buscar
            </button>

        </div>
    </form>

    {{-- Tabla de productos --}}
    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>SKU</th>
                            <th>Precio</th>
                            <th>Existencias</th>
                            <th>Stock mínimo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($productos as $producto)

                            <tr>

                                <td>
                                    {{ $producto->nombre }}
                                </td>

                                <td>
                                    {{ $producto->codigo_sku }}
                                </td>

                                <td>
                                    ${{ number_format((float) $producto->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $producto->inventory?->cantidad ?? 0 }}
                                </td>

                                <td>
                                    {{ $producto->inventory?->stock_minimo ?? 0 }}
                                </td>

                                <td>
                                    @if ($producto->esta_activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No hay productos registrados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            {{ $productos->links() }}

        </div>

    </div>

</div>

@endsection
