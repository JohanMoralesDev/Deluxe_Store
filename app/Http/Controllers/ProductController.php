<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Mostrar el listado de productos.
     */
    public function index()
    {
        // Consultar productos y cargar su inventario relacionado.
        $productos = Product::with('inventory')
            ->orderBy('nombre')
            ->paginate(10);

        // Enviar los productos a la vista.
        return view('admin.products.index', compact('productos'));
    }
}