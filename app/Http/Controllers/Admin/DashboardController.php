<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total de productos registrados
        $totalProductos = Product::count();

        // 2. Total de pedidos registrados
        $totalPedidos = Order::count();

        // 3. Ventas acumuladas
        // Temporalmente incluye los pedidos registrados.
        $ventasAcumuladas = Order::sum('total');

        // 4. Productos con stock bajo
        $productosStockBajo = Inventory::with('product')
            ->whereColumn('cantidad', '<=', 'stock_minimo')
            ->get();

        // 5. Productos agotados
        $productosAgotados = Inventory::with('product')
            ->where('cantidad', 0)
            ->get();

        // 6. Productos más vendidos
        $productosMasVendidos = DB::table('detalle_pedido')
            ->join(
                'productos',
                'detalle_pedido.id_producto',
                '=',
                'productos.id_producto'
            )
            ->select(
                'productos.id_producto',
                'productos.nombre',
                DB::raw('SUM(detalle_pedido.cantidad) as unidades_vendidas')
            )
            ->groupBy(
                'productos.id_producto',
                'productos.nombre'
            )
            ->orderByDesc('unidades_vendidas')
            ->limit(5)
            ->get();

        // 7. Productos sin ventas durante los últimos 30 días
        $ventasRecientes = DB::table('detalle_pedido')
            ->join(
                'pedidos',
                'detalle_pedido.id_pedido',
                '=',
                'pedidos.id_pedido'
            )
            ->where('detalle_pedido.creado_en', '>=', now()->subDays(30))
            ->select('detalle_pedido.id_producto')
            ->distinct();

        $productosBajaRotacion = Product::with('inventory')
            ->whereNotIn('id_producto', $ventasRecientes)
            ->limit(5)
            ->get();

        // 8. Últimos movimientos de inventario
        $ultimosMovimientos = InventoryMovement::with('product')
            ->orderByDesc('fecha_movimiento')
            ->limit(10)
            ->get();

        // 9. Total de unidades existentes
        $totalUnidades = Inventory::sum('cantidad');

        return view('admin.dashboard', compact(
            'totalProductos',
            'totalPedidos',
            'ventasAcumuladas',
            'productosStockBajo',
            'productosAgotados',
            'productosMasVendidos',
            'productosBajaRotacion',
            'ultimosMovimientos',
            'totalUnidades'
        ));
    }
}
