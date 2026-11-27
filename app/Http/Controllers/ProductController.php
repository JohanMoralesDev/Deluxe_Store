<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\InventoryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;
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

        $precioVigente = 'CASE WHEN precio_oferta > 0 AND precio_oferta < precio THEN precio_oferta ELSE precio END';
        $products = Product::with('category')
            ->with('inventory')
            ->active()
            ->search($request->query('q'))
            ->when($request->filled('categoria'), fn ($query) => $query->where('id_categoria', $request->query('categoria')))
            ->when($request->filled('publico'), fn ($query) => $query->where('publico', $request->query('publico')))
            ->when($request->filled('tamano'), fn ($query) => $query->where('tamano_esfera', $request->query('tamano')))
            ->when($request->boolean('nuevos'), fn ($query) => $query->where('creado_en', '>=', now()->subMonths(6)))
            ->when($request->filled('orden'), fn ($query) => match ($request->query('orden')) {
                'precio_asc' => $query->orderByRaw("$precioVigente ASC"),
                'precio_desc' => $query->orderByRaw("$precioVigente DESC"),
                default => $query->latest('creado_en'),
            }, fn ($query) => $query->latest('creado_en'))
            ->get();

        $categories = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categorias = Category::where('esta_activa', true)->orderBy('nombre')->get();

        return view('admin.products.create', compact('categorias'));
    }

    public function store(StoreProductRequest $request, InventoryService $inventoryService)
    {
        $datos = $request->validated();
        $cantidadInicial = (int) $datos['cantidad_inicial'];
        $imagen = $datos['imagen'] ?? null;
        unset($datos['cantidad_inicial'], $datos['imagen']);
        $datos['esta_activo'] = $request->boolean('esta_activo');
        $rutaImagen = $imagen instanceof UploadedFile ? $this->storeProductImage($imagen) : null;
        if ($rutaImagen !== null) {
            $datos['url_imagen'] = $rutaImagen;
        }

        try {
            DB::transaction(function () use ($datos, $cantidadInicial, $inventoryService): void {
                $product = Product::create($datos);
                $product->inventory()->create([
                    'cantidad' => 0,
                    'stock_minimo' => 5,
                ]);

                if ($cantidadInicial > 0) {
                    $inventoryService->registerEntry(
                        $product->getKey(),
                        $cantidadInicial,
                        Auth::id(),
                        'Existencia inicial al crear producto'
                    );
                }
            });
        } catch (Throwable $exception) {
            if ($rutaImagen !== null) {
                $this->deleteManagedProductImage($rutaImagen);
            }

            throw $exception;
        }

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
        $imagen = $datos['imagen'] ?? null;
        unset($datos['imagen']);
        $datos['esta_activo'] = $request->boolean('esta_activo');
        $imagenAnterior = $product->url_imagen;
        $rutaImagen = $imagen instanceof UploadedFile ? $this->storeProductImage($imagen) : null;
        if ($rutaImagen !== null) {
            $datos['url_imagen'] = $rutaImagen;
        }

        try {
            DB::transaction(fn () => $product->update($datos));
        } catch (Throwable $exception) {
            if ($rutaImagen !== null) {
                $this->deleteManagedProductImage($rutaImagen);
            }

            throw $exception;
        }

        if ($imagenAnterior !== $product->url_imagen) {
            $this->deleteReplacedImageIfUnused($imagenAnterior, $product->getKey());
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->update(['esta_activo' => false]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto desactivado correctamente.');
    }

    private function storeProductImage(UploadedFile $image): string
    {
        $path = $image->storePublicly('productos', 'public');

        if (! is_string($path) || $path === '') {
            throw new RuntimeException('No fue posible guardar la imagen del producto.');
        }

        return 'storage/'.$path;
    }

    private function deleteManagedProductImage(?string $path): void
    {
        $prefix = 'storage/productos/';
        if ($path !== null && str_starts_with($path, $prefix)) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }

    private function deleteReplacedImageIfUnused(?string $path, int $productId): void
    {
        $prefix = 'storage/productos/';
        if ($path === null || ! str_starts_with($path, $prefix)) {
            return;
        }

        $stillReferenced = Product::query()
            ->where('url_imagen', $path)
            ->where('id_producto', '!=', $productId)
            ->exists();

        if (! $stillReferenced) {
            $this->deleteManagedProductImage($path);
        }
    }
}
