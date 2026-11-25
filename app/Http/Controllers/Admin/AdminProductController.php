<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Mostrar el listado de productos en administración.
     */
    public function index(Request $request)
    {
        // Consultar productos y cargar su inventario.
        $productos = Product::with('inventory')

            // Aplicar búsqueda si el usuario escribió algo.
            ->when($request->filled('buscar'), function ($query) use ($request) {

                $busqueda = $request->buscar;

                $query->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'LIKE', "%{$busqueda}%")
                        ->orWhere('codigo_sku', 'LIKE', "%{$busqueda}%");
                });

            })

            // Ordenar alfabéticamente.
            ->orderBy('nombre')

            // Mostrar diez productos por página.
            ->paginate(10)

            // Conservar la búsqueda al cambiar de página.
            ->withQueryString();

        return view('admin.products.index', compact('productos'));
    }
}
