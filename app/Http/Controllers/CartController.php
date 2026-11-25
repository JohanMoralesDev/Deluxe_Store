<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Mostrar el carrito
    public function index()
    {
        $carrito = session()->get('carrito', []);

        $total = collect($carrito)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });

        return view('cart.index', compact('carrito', 'total'));
    }

    // Agregar un producto al carrito
    public function add(Request $request, $id)
    {
        $producto = Product::with('inventory')
            ->where('esta_activo', true)
            ->findOrFail($id);

        $datos = $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $cantidad = $datos['cantidad'];

        $carrito = session()->get('carrito', []);

        $cantidadActual = $carrito[$producto->id_producto]['cantidad'] ?? 0;

        $stock = $producto->inventory?->cantidad ?? 0;

        if ($cantidadActual + $cantidad > $stock) {
            return back()->with(
                'error',
                'No hay suficientes unidades disponibles.'
            );
        }

        $precio = $producto->precio_oferta ?? $producto->precio;

        if (isset($carrito[$producto->id_producto])) {
            $carrito[$producto->id_producto]['cantidad'] += $cantidad;
        } else {
            $carrito[$producto->id_producto] = [
                'id_producto' => $producto->id_producto,
                'nombre' => $producto->nombre,
                'precio' => (float) $precio,
                'imagen' => $producto->url_imagen,
                'cantidad' => $cantidad,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('store.carrito')
            ->with('success', 'Producto agregado al carrito.');
    }

    // Actualizar la cantidad de un producto
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito = session()->get('carrito', []);

        if (!isset($carrito[$id])) {
            return back()->with('error', 'Producto no encontrado.');
        }

        $producto = Product::with('inventory')
            ->findOrFail($id);

        $stock = $producto->inventory?->cantidad ?? 0;

        if ($datos['cantidad'] > $stock) {
            return back()->with(
                'error',
                'La cantidad supera las existencias disponibles.'
            );
        }

        $carrito[$id]['cantidad'] = $datos['cantidad'];

        session()->put('carrito', $carrito);

        return redirect()->route('store.carrito')
            ->with('success', 'Cantidad actualizada.');
    }

    // Eliminar un producto del carrito
    public function remove($id)
    {
        $carrito = session()->get('carrito', []);

        unset($carrito[$id]);

        session()->put('carrito', $carrito);

        return redirect()->route('store.carrito')
            ->with('success', 'Producto eliminado del carrito.');
    }

    // Vaciar el carrito
    public function clear()
    {
        session()->forget('carrito');

        return redirect()->route('store.carrito')
            ->with('success', 'Carrito vaciado correctamente.');
    }
}