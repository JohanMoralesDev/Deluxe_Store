<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $precioVigente = 'COALESCE(NULLIF(precio_oferta, 0), precio)';

        $products = Product::with('category')
            ->active()
            ->search($request->q)
            ->when($request->categoria, fn ($q, $v) => $q->where('id_categoria', $v))
            ->when($request->publico, fn ($q, $v) => $q->where('publico', $v))
            ->when($request->tamano, fn ($q, $v) => $q->where('tamano_esfera', $v))
            ->when($request->boolean('nuevos'), fn ($q) => $q->where('creado_en', '>=', now()->subMonths(6)))
            ->when($request->orden, fn ($q, $orden) => match ($orden) {
                'precio_asc'  => $q->orderByRaw("$precioVigente ASC"),
                'precio_desc' => $q->orderByRaw("$precioVigente DESC"),
                default       => $q->latest('creado_en'),
            }, fn ($q) => $q->latest('creado_en'))
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
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