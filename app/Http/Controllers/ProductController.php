<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->routeIs('admin.products.index')) {
            $productos = Product::with(['category', 'inventory'])
                ->latest('creado_en')
                ->paginate(10);

            return view('admin.products.index', compact('productos'));
        }

        $precioVigente = 'COALESCE(NULLIF(precio_oferta, 0), precio)';

        $products = Product::with('category')
            ->active()
            ->search($request->q)
            ->when($request->categoria, fn ($q, $v) => $q->where('id_categoria', $v))
            ->when($request->publico, fn ($q, $v) => $q->where('publico', $v))
            ->when($request->tamano, fn ($q, $v) => $q->where('tamano_esfera', $v))
            ->when($request->boolean('nuevos'), fn ($q) => $q->where('creado_en', '>=', now()->subMonths(6)))
            ->when($request->orden, fn ($q, $orden) => match ($orden) {
                'precio_asc' => $q->orderByRaw("$precioVigente ASC"),
                'precio_desc' => $q->orderByRaw("$precioVigente DESC"),
                default => $q->latest('creado_en'),
            }, fn ($q) => $q->latest('creado_en'))
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categorias = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('admin.products.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_categoria' => ['required', 'integer', Rule::exists('categorias', 'id_categoria')->where('esta_activa', true)],
            'nombre' => 'required|string|max:150',
            'codigo_sku' => 'required|string|max:100|unique:productos,codigo_sku',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'precio_oferta' => 'nullable|numeric|min:0|lt:precio',
            'color' => 'nullable|string|max:50',
            'url_imagen' => 'nullable|string|max:255',
            'esta_activo' => 'sometimes|boolean',
        ]);

        $datos['esta_activo'] = $request->boolean('esta_activo');
        Product::create($datos);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function show(Request $request, Product $product)
    {
        if ($request->routeIs('admin.products.show')) {
            $product->load(['category', 'inventory']);

            return view('admin.products.show', compact('product'));
        }

        abort_unless($product->esta_activo, 404);
        $product->load('category');

        $related = Product::active()
            ->where('id_categoria', $product->id_categoria)
            ->whereKeyNot($product->getKey())
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }

    public function edit(Product $product)
    {
        $categorias = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('admin.products.edit', compact('product', 'categorias'));
    }

    public function update(Request $request, Product $product)
    {
        $datos = $request->validate([
            'id_categoria' => ['required', 'integer', Rule::exists('categorias', 'id_categoria')->where('esta_activa', true)],
            'nombre' => 'required|string|max:150',
            'codigo_sku' => ['required', 'string', 'max:100', Rule::unique('productos', 'codigo_sku')->ignore($product->id_producto, 'id_producto')],
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'precio_oferta' => 'nullable|numeric|min:0|lt:precio',
            'color' => 'nullable|string|max:50',
            'url_imagen' => 'nullable|string|max:255',
            'esta_activo' => 'sometimes|boolean',
        ]);

        $datos['esta_activo'] = $request->boolean('esta_activo');
        $product->update($datos);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->update(['esta_activo' => false]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto desactivado correctamente.');
    }
}
