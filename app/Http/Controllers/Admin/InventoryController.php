<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

class InventoryController extends Controller
{
    public function index(): View
    {
        $productos = Product::with('inventory')
            ->orderBy('nombre')
            ->paginate(15);
        $movimientos = InventoryMovement::with(['product', 'user'])
            ->latest('fecha_movimiento')
            ->limit(10)
            ->get();

        return view('admin.inventory.index', compact('productos', 'movimientos'));
    }

    public function storeMovement(Request $request, Product $product, InventoryService $inventoryService)
    {
        $datos = $request->validate([
            'tipo' => ['required', 'in:ENTRADA,SALIDA,AJUSTE'],
            'cantidad' => ['required', 'integer', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ]);

        if ($datos['tipo'] !== 'AJUSTE' && (int) $datos['cantidad'] < 1) {
            return back()->withErrors(['cantidad' => 'La cantidad debe ser mayor a cero.'])->withInput();
        }

        try {
            match ($datos['tipo']) {
                'ENTRADA' => $inventoryService->registerEntry(
                    $product->getKey(), (int) $datos['cantidad'], Auth::id(), $datos['descripcion'] ?? null
                ),
                'SALIDA' => $inventoryService->registerExit(
                    $product->getKey(), (int) $datos['cantidad'], Auth::id(), $datos['descripcion'] ?? null
                ),
                'AJUSTE' => $inventoryService->adjustStock(
                    $product->getKey(), (int) $datos['cantidad'], Auth::id(), $datos['descripcion'] ?? null
                ),
            };
        } catch (RuntimeException $exception) {
            return back()->with('error', $exception->getMessage())->withInput();
        }

        return back()->with('success', 'Movimiento de inventario registrado.');
    }
}
