<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $precioVigente = 'COALESCE(NULLIF(precio_oferta, 0), precio)';

        $products = Product::with('category')
            ->active()
            ->search($request->query('q'))
            ->when($request->filled('categoria'), fn ($query, $value) => $query->where('id_categoria', $value))
            ->when($request->filled('publico'), fn ($query, $value) => $query->where('publico', $value))
            ->when($request->filled('tamano'), fn ($query, $value) => $query->where('tamano_esfera', $value))
            ->when($request->boolean('nuevos'), fn ($query) => $query->where('creado_en', '>=', now()->subMonths(6)))
            ->when($request->filled('orden'), fn ($query, $orden) => match ($orden) {
                'precio_asc' => $query->orderByRaw("$precioVigente ASC"),
                'precio_desc' => $query->orderByRaw("$precioVigente DESC"),
                default => $query->latest('creado_en'),
            }, fn ($query) => $query->latest('creado_en'))
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('esta_activa', true)
            ->orderBy('nombre')
            ->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->esta_activo, 404);

        $product->load('category');

        $related = Product::active()
            ->where('id_categoria', $product->id_categoria)
            ->whereKeyNot($product->getKey())
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
