<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
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

        $categories = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categorias = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('admin.products.create', compact('categorias'));
    }

    public function store(StoreProductRequest $request)
    {
        $datos = $request->validated();
        $datos['esta_activo'] = $request->boolean('esta_activo');
        DB::transaction(function () use ($datos): void {
            $product = Product::create($datos);
            $product->inventory()->create([
                'cantidad' => 0,
                'stock_minimo' => 5,
            ]);
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function show(Request $request, Product $product): View
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

    public function edit(Product $product): View
    {
        $categorias = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('admin.products.edit', compact('product', 'categorias'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $datos = $request->validated();
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
