<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    private const KEY = 'cart';

    public function summary(): array
    {
        $cart = session(self::KEY, []);
        $items = [];
        $total = 0;

        if (empty($cart)) {
            return ['items' => [], 'total' => 0, 'count' => 0, 'issues' => []];
        }

        $products = Product::whereIn('id_producto', array_keys($cart))
            ->with('inventory')
            ->get()
            ->keyBy('id_producto');

        $issues = [];

        foreach ($cart as $id => $row) {
            $product = $products->get((int) $id);

            if (! $product || ! $product->active) {
                unset($cart[$id]);
                $issues[] = 'Un producto ya no está disponible y fue retirado.';
                continue;
            }

            $quantity = min((int) ($row['quantity'] ?? 1), $product->stock);

            if ($quantity < 1) {
                unset($cart[$id]);
                $issues[] = "{$product->name} está agotado y fue retirado.";
                continue;
            }

            if ($quantity !== (int) ($row['quantity'] ?? 1)) {
                $cart[$id]['quantity'] = $quantity;
                $issues[] = "Ajustamos {$product->name} a {$quantity} unidades.";
            }

            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        session([self::KEY => $cart]);

        return [
            'items' => $items,
            'total' => $total,
            'count' => array_sum(array_column($items, 'quantity')),
            'issues' => array_unique($issues),
        ];
    }
}