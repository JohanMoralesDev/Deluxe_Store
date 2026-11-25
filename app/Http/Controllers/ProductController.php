<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        $productos = Product::with(['category', 'inventory'])
            ->latest('creado_en')
            ->paginate(10);

        return view('admin.products.index', compact('productos'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $categorias = Category::where('esta_activa', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.products.create', compact('categorias'));
    }

    // Guardar un producto nuevo
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_categoria' => [
                'required',
                'integer',
                Rule::exists('categorias', 'id_categoria')
                    ->where('esta_activa', true),
            ],
            'nombre' => 'required|string|max:150',
            'codigo_sku' => 'required|string|max:100|unique:productos,codigo_sku',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'precio_oferta' => 'nullable|numeric|min:0|lt:precio',
            'color' => 'nullable|string|max:50',
            'url_imagen' => 'nullable|url|max:255',
            'esta_activo' => 'sometimes|boolean',
        ]);

        $datos['esta_activo'] = $request->boolean('esta_activo');

        Product::create($datos);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    // Mostrar un producto
    public function show(Product $product)
    {
        $product->load(['category', 'inventory']);

        return view('admin.products.show', compact('product'));
    }

    // Mostrar formulario de edición
    public function edit(Product $product)
    {
        $categorias = Category::where('esta_activa', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.products.edit', compact('product', 'categorias'));
    }

    // Actualizar un producto
    public function update(Request $request, Product $product)
    {
        $datos = $request->validate([
            'id_categoria' => [
                'required',
                'integer',
                Rule::exists('categorias', 'id_categoria')
                    ->where('esta_activa', true),
            ],
            'nombre' => 'required|string|max:150',
            'codigo_sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('productos', 'codigo_sku')
                    ->ignore($product->id_producto, 'id_producto'),
            ],
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'precio_oferta' => 'nullable|numeric|min:0|lt:precio',
            'color' => 'nullable|string|max:50',
            'url_imagen' => 'nullable|url|max:255',
            'esta_activo' => 'sometimes|boolean',
        ]);

        $datos['esta_activo'] = $request->boolean('esta_activo');

        $product->update($datos);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    // Desactivar un producto
    public function destroy(Product $product)
    {
        $product->update([
            'esta_activo' => false,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto desactivado correctamente.');
    }
}
