<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private const KEY = 'cart';

    public function __construct(private readonly CartService $cartService) {}

    public function index(): View
    {
        return view('cart.index', $this->cartService->summary());
    }

    public function add(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        $data = $request->validate(['quantity' => ['nullable', 'integer', 'min:1', 'max:99']]);
        $qty  = (int) ($data['quantity'] ?? 1);

        if (! $product->active || $product->stock < 1) {
            return $this->respond($request, false, 'El producto no está disponible.');
        }

        $cart    = session(self::KEY, []);
        $newQty  = ($cart[$product->id]['quantity'] ?? 0) + $qty;

        if ($newQty > $product->stock) {
            $newQty = $product->stock;
            $msg = "Solo hay {$product->stock} unidades de {$product->name}.";
        } else {
            $msg = "{$product->name} agregado al carrito.";
        }

        $cart[$product->id] = ['quantity' => $newQty];
        session([self::KEY => $cart]);

        return $this->respond($request, true, $msg);
    }

    public function update(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);
        $cart = session(self::KEY, []);

        if (! isset($cart[$product->id])) {
            return $this->respond($request, false, 'El producto no está en el carrito.');
        }

        $qty = min((int) $data['quantity'], max($product->stock, 0));
        if ($qty < 1) {
            return $this->respond($request, false, 'El producto no está disponible.');
        }

        $cart[$product->id]['quantity'] = $qty;
        session([self::KEY => $cart]);

        return $this->respond($request, true, 'Cantidad actualizada.');
    }

    public function remove(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        $cart = session(self::KEY, []);
        unset($cart[$product->id]);
        session([self::KEY => $cart]);

        return $this->respond($request, true, 'Producto eliminado.');
    }

    public function clear(Request $request): RedirectResponse|JsonResponse
    {
        session()->forget(self::KEY);

        return $this->respond($request, true, 'Carrito vaciado.');
    }

    private function respond(Request $request, bool $ok, string $message): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            $s = $this->cartService->summary();

            return response()->json([
                'ok'      => $ok,
                'message' => $message,
                'count'   => $s['count'],
                'total'   => $s['total'],
            ], $ok ? 200 : 422);
        }

        return back()->with($ok ? 'success' : 'error', $message);
    }
}