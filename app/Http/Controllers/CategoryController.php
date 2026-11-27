<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Mostrar todas las categorías
    public function index()
    {
        $categorias = Category::withCount('products')
            ->orderBy('nombre')
            ->paginate(10);

        return view('admin.categories.index', compact('categorias'));
    }

    // Mostrar formulario para crear una categoría
    public function create()
    {
        return view('admin.categories.create');
    }

    // Guardar una categoría
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'esta_activa' => 'sometimes|boolean',
        ]);

        $datos['esta_activa'] = $request->boolean('esta_activa');

        Category::create($datos);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    // Mostrar una categoría
    public function show(Category $category)
    {
        $category->load('products');

        return view('admin.categories.show', compact('category'));
    }

    // Mostrar formulario de edición
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Actualizar una categoría
    public function update(Request $request, Category $category)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'esta_activa' => 'sometimes|boolean',
        ]);

        $datos['esta_activa'] = $request->boolean('esta_activa');

        $category->update($datos);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    // Desactivar una categoría
    public function destroy(Category $category)
    {
        $category->update([
            'esta_activa' => false,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría desactivada correctamente.');
    }
}
