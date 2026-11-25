@extends('layouts.admin')

@section('title', 'Dashboard | Deluxe Store')

@section('menu-dashboard', 'activo')

@section('content')

    <header class="encabezado-admin">

        <div>
            <p class="subtitulo-admin">PANEL DE CONTROL</p>

            <h1>Resumen general</h1>

            <p>
                Bienvenido a la administración de Deluxe Store.
            </p>
        </div>

        <div class="perfil-admin">
            <i class="bi bi-person-circle"></i>
            <span>Administrador</span>
        </div>

    </header>

    <!-- Indicadores -->
    <section class="indicadores">

        <article class="tarjeta-indicador">
            <div class="icono-indicador">
                <i class="bi bi-currency-dollar"></i>
            </div>

            <p>Ventas acumuladas</p>

            <h2>
                ${{ number_format($ventasAcumuladas, 0, ',', '.') }}
            </h2>

            <span>Ventas registradas</span>
        </article>

        <article class="tarjeta-indicador">
            <div class="icono-indicador">
                <i class="bi bi-receipt"></i>
            </div>

            <p>Pedidos</p>

            <h2>{{ $totalPedidos }}</h2>

            <span>Pedidos registrados</span>
        </article>

        <article class="tarjeta-indicador">
            <div class="icono-indicador">
                <i class="bi bi-box-seam"></i>
            </div>

            <p>Productos</p>

            <h2>{{ $totalProductos }}</h2>

            <span>Productos registrados</span>
        </article>

        <article class="tarjeta-indicador">
            <div class="icono-indicador">
                <i class="bi bi-exclamation-triangle"></i>
            </div>

            <p>Inventario bajo</p>

            <h2>{{ $productosStockBajo->count() }}</h2>

            <span>Productos por revisar</span>
        </article>

    </section>

    <!-- Estado del inventario -->
    <section class="resumen-inventario">

        <div class="encabezado-seccion">
            <h2>Estado del inventario</h2>

            <p>
                Productos que necesitan atención.
            </p>
        </div>

        <div class="tabla-contenedor">

            <table class="tabla-inventario">

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($productosStockBajo as $item)
                        <tr>
                            <td>
                                {{ $item->product?->nombre ?? 'Producto no disponible' }}
                            </td>

                            <td>{{ $item->cantidad }}</td>

                            <td>{{ $item->stock_minimo }}</td>

                            <td>
                                @if ($item->cantidad == 0)
                                    <span class="badge bg-danger">
                                        Agotado
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Stock bajo
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4">
                                No hay productos con stock bajo.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

    <!-- Productos más vendidos -->
    <section class="resumen-inventario">

        <div class="encabezado-seccion">
            <h2>Productos más vendidos</h2>
            <p>Los cinco productos con más unidades vendidas.</p>
        </div>

        <div class="tabla-contenedor">

            <table class="tabla-inventario">

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Unidades vendidas</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($productosMasVendidos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->unidades_vendidas }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="2">
                                Todavía no hay ventas registradas.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

    <!-- Productos con baja rotación -->
    <section class="resumen-inventario">

        <div class="encabezado-seccion">
            <h2>Productos sin ventas recientes</h2>
            <p>Productos sin pedidos registrados en los últimos 30 días.</p>
        </div>

        <ul>
            @forelse($productosBajaRotacion as $producto)
                <li>{{ $producto->nombre }}</li>
            @empty
                <li>No hay productos para mostrar.</li>
            @endforelse
        </ul>

    </section>

    <!-- Movimientos recientes -->
    <section class="resumen-inventario">

        <div class="encabezado-seccion">
            <h2>Últimos movimientos</h2>
            <p>Actividad reciente del inventario.</p>
        </div>

        <div class="tabla-contenedor">

            <table class="tabla-inventario">

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Movimiento</th>
                        <th>Cantidad</th>
                        <th>Stock anterior</th>
                        <th>Stock nuevo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ultimosMovimientos as $movimiento)
                        <tr>
                            <td>
                                {{ $movimiento->product?->nombre ?? 'Producto no disponible' }}
                            </td>

                            <td>{{ $movimiento->tipo_movimiento }}</td>

                            <td>{{ $movimiento->cantidad }}</td>

                            <td>{{ $movimiento->stock_anterior }}</td>

                            <td>{{ $movimiento->stock_nuevo }}</td>

                            <td>
                                {{ $movimiento->fecha_movimiento?->format('d/m/Y H:i') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                No hay movimientos registrados.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

@endsection
