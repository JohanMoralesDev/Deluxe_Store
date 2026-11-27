<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderService
{
    private const CART_KEY = 'cart';

    public function __construct(private readonly InventoryService $inventoryService) {}

    public function create(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = session(self::CART_KEY, []);

            if (empty($cart)) {
                throw new RuntimeException('El carrito está vacío.');
            }

            $subtotal = 0;
            $products = [];

            foreach ($cart as $id => $row) {
                $product = Product::whereKey($id)
                    ->with('inventory')
                    ->lockForUpdate()
                    ->first();

                $quantity = (int) ($row['quantity'] ?? 0);

                if (! $product || ! $product->active) {
                    throw new RuntimeException('Un producto ya no está disponible.');
                }

                if ($quantity < 1 || $quantity > $product->stock) {
                    throw new RuntimeException("La cantidad de {$product->name} no está disponible.");
                }

                $unitPrice = $product->price;
                $lineSubtotal = $unitPrice * $quantity;
                $subtotal += $lineSubtotal;
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $order = Order::create([
                'id_usuario' => $user->getKey(),
                'numero_pedido' => 'PED-' . now()->format('Ymd-His') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6)),
                'estado' => 'PENDIENTE',
                'estado_pago' => 'PENDIENTE',
                'metodo_pago' => $data['metodo_pago'],
                'subtotal' => $subtotal,
                'costo_envio' => 0,
                'descuento' => 0,
                'total' => $subtotal,
                'nombre_destinatario' => $data['nombre_destinatario'],
                'telefono_destinatario' => $data['telefono_destinatario'],
                'direccion_envio' => $data['direccion_envio'],
                'ciudad_envio' => $data['ciudad_envio'],
                'departamento_envio' => $data['departamento_envio'],
                'observaciones' => $data['observaciones'] ?? null,
                'fecha_pedido' => now(),
            ]);

            foreach ($products as $line) {
                $product = $line['product'];

                OrderDetail::create([
                    'id_pedido' => $order->getKey(),
                    'id_producto' => $product->getKey(),
                    'nombre_producto' => $product->name,
                    'codigo_sku' => $product->codigo_sku,
                    'cantidad' => $line['quantity'],
                    'precio_unitario' => $line['unit_price'],
                    'subtotal' => $line['subtotal'],
                ]);

                $this->inventoryService->registerExit(
                    $product->getKey(),
                    $line['quantity'],
                    $user->getKey(),
                    "Salida por pedido {$order->numero_pedido}",
                    $order->getKey()
                );
            }

            session()->forget(self::CART_KEY);

            return $order->load('details');
        });
    }
}
