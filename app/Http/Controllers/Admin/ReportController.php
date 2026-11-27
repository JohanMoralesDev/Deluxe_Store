<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $totalProductos = Product::count();
        $productosActivos = Product::where('esta_activo', true)->count();
        $productosStockBajo = Inventory::whereColumn('cantidad', '<=', 'stock_minimo')->count();
        $totalPedidos = Order::count();
        $totalPedidosRegistrados = (float) Order::sum('total');
        $totalesPorEstadoPago = Order::query()
            ->select('estado_pago', DB::raw('COUNT(*) as cantidad_pedidos'), DB::raw('SUM(total) as total_pedidos'))
            ->groupBy('estado_pago')->orderBy('estado_pago')->get();
        $productosMasSolicitados = DB::table('detalle_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->select('productos.nombre', 'productos.codigo_sku', DB::raw('SUM(detalle_pedido.cantidad) as unidades'))
            ->groupBy('productos.id_producto', 'productos.nombre', 'productos.codigo_sku')
            ->orderByDesc('unidades')->limit(10)->get();

        return view('admin.reports.index', compact(
            'totalProductos',
            'productosActivos',
            'productosStockBajo',
            'totalPedidos',
            'totalPedidosRegistrados',
            'totalesPorEstadoPago',
            'productosMasSolicitados'
        ));
    }
}
