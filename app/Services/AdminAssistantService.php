<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminAssistantService
{
    public function answer(string $message): array
    {
        $text = Str::of($message)->lower()->ascii()->replaceMatches('/[^a-z0-9\s]/', ' ')->squish()->toString();

        if (str_contains($text, 'agotad') || str_contains($text, 'sin stock')) {
            $items = Inventory::with('product')->where('cantidad', 0)->limit(10)->get();
            return $this->result(
                'Productos con existencia cero: '.$items->count().' en esta consulta.',
                $items->map(fn (Inventory $item) => [
                    'producto' => $item->product?->nombre ?? 'Producto no disponible',
                    'sku' => $item->product?->codigo_sku,
                    'existencias' => $item->cantidad,
                ])->all(),
                [['label' => 'Abrir inventario', 'url' => route('admin.inventory.index')]]
            );
        }

        if (str_contains($text, 'stock bajo') || str_contains($text, 'poco inventario') || str_contains($text, 'existencias bajas')) {
            $items = Inventory::with('product')->whereColumn('cantidad', '<=', 'stock_minimo')
                ->orderBy('cantidad')->limit(10)->get();
            return $this->result(
                'Productos en o por debajo de su nivel mínimo: '.$items->count().' en esta consulta.',
                $items->map(fn (Inventory $item) => [
                    'producto' => $item->product?->nombre ?? 'Producto no disponible',
                    'sku' => $item->product?->codigo_sku,
                    'existencias' => $item->cantidad,
                    'minimo' => $item->stock_minimo,
                ])->all(),
                [['label' => 'Abrir inventario', 'url' => route('admin.inventory.index')]]
            );
        }

        if (str_contains($text, 'pedido') && (str_contains($text, 'pendiente') || str_contains($text, 'estado'))) {
            $orders = Order::query()->where('estado', 'PENDIENTE')->latest('fecha_pedido')->limit(10)->get();
            return $this->result(
                'Pedidos con estado PENDIENTE: '.$orders->count().' en los últimos resultados.',
                $orders->map(fn (Order $order) => [
                    'pedido' => $order->numero_pedido,
                    'estado' => $order->estado,
                    'estado_pago' => $order->estado_pago,
                    'fecha' => $order->fecha_pedido?->format('d/m/Y H:i'),
                ])->all(),
                [['label' => 'Ver pedidos', 'url' => route('admin.orders.index')]]
            );
        }

        if (str_contains($text, 'mas vendido') || str_contains($text, 'mas vendidos')) {
            $rows = DB::table('detalle_pedido')
                ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
                ->select('productos.nombre', 'productos.codigo_sku', DB::raw('SUM(detalle_pedido.cantidad) as unidades_en_pedidos'))
                ->groupBy('productos.id_producto', 'productos.nombre', 'productos.codigo_sku')
                ->orderByDesc('unidades_en_pedidos')
                ->limit(5)->get();

            return $this->result(
                'Productos con más unidades registradas en líneas de pedido. El dato incluye pedidos de cualquier estado.',
                $rows->map(fn ($row) => ['producto' => $row->nombre, 'sku' => $row->codigo_sku, 'unidades' => (int) $row->unidades_en_pedidos])->all(),
                [['label' => 'Ver informes', 'url' => route('admin.reports.index')]]
            );
        }

        if (str_contains($text, 'venta') || str_contains($text, 'vendido') || str_contains($text, 'ingreso')) {
            $total = (float) Order::sum('total');
            $porEstado = Order::query()
                ->select('estado_pago', DB::raw('COUNT(*) as cantidad_pedidos'), DB::raw('SUM(total) as total_pedidos'))
                ->groupBy('estado_pago')->orderBy('estado_pago')->get();

            return $this->result(
                'La suma de total de todos los pedidos registrados es $'.number_format($total, 0, ',', '.').'. Esta suma no filtra por estado de pago.',
                $porEstado->map(fn ($row) => [
                    'estado_pago' => $row->estado_pago,
                    'pedidos' => (int) $row->cantidad_pedidos,
                    'total' => (float) $row->total_pedidos,
                ])->all(),
                [['label' => 'Ver informes', 'url' => route('admin.reports.index')]]
            );
        }

        if (str_contains($text, 'movimiento') || str_contains($text, 'entrada') || str_contains($text, 'salida') || str_contains($text, 'ajuste')) {
            $movements = InventoryMovement::with('product')->latest('fecha_movimiento')->limit(8)->get();
            return $this->result(
                'Movimientos recientes registrados en inventario:',
                $movements->map(fn (InventoryMovement $movement) => [
                    'fecha' => $movement->fecha_movimiento?->format('d/m/Y H:i'),
                    'producto' => $movement->product?->nombre,
                    'tipo' => $movement->tipo_movimiento,
                    'cantidad' => $movement->cantidad,
                    'stock_nuevo' => $movement->stock_nuevo,
                ])->all(),
                [['label' => 'Abrir movimientos', 'url' => route('admin.inventory.index').'#movimientos']]
            );
        }

        if (str_contains($text, 'cuantos productos') || str_contains($text, 'productos registrados')) {
            return $this->result(
                'Hay '.Product::count().' productos registrados: '.Product::where('esta_activo', true)->count().' activos y '.Product::where('esta_activo', false)->count().' inactivos.',
                [],
                [['label' => 'Ver productos', 'url' => route('admin.productos.index')]]
            );
        }

        $terms = array_values(array_diff(explode(' ', $text), ['buscar', 'producto', 'productos', 'consulta', 'consultar', 'precio', 'stock', 'el', 'la', 'los', 'las', 'de', 'del', 'por', 'favor']));
        if ($terms !== []) {
            $products = Product::with('inventory')->where(function ($query) use ($terms): void {
                foreach (array_slice($terms, 0, 5) as $term) {
                    $query->orWhere('nombre', 'like', '%'.$term.'%')->orWhere('codigo_sku', 'like', '%'.$term.'%');
                }
            })->orderBy('nombre')->limit(8)->get();

            if ($products->isNotEmpty()) {
                return $this->result(
                    'Productos que coinciden con la búsqueda:',
                    $products->map(fn (Product $product) => [
                        'producto' => $product->nombre,
                        'sku' => $product->codigo_sku,
                        'precio' => (float) $product->price,
                        'existencias' => $product->inventory?->cantidad ?? 0,
                        'estado' => $product->esta_activo ? 'Activo' : 'Inactivo',
                    ])->all(),
                    [['label' => 'Gestionar productos', 'url' => route('admin.productos.index')]]
                );
            }
        }

        return $this->result(
            'Puedo consultar productos, existencias, movimientos, pedidos pendientes, unidades registradas en pedidos y totales por estado de pago.',
            [],
            [
                ['label' => 'Inventario', 'url' => route('admin.inventory.index')],
                ['label' => 'Pedidos', 'url' => route('admin.orders.index')],
                ['label' => 'Informes', 'url' => route('admin.reports.index')],
            ]
        );
    }

    private function result(string $message, array $data, array $links): array
    {
        return compact('message', 'data', 'links');
    }
}
