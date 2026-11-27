<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class StoreAssistantService
{
    public function answer(string $message): array
    {
        $normalized = Str::of($message)->lower()->ascii()->replaceMatches('/[^a-z0-9\s]/', ' ')->squish()->toString();

        if (preg_match('/\b(categoria|categorias|coleccion|colecciones)\b/', $normalized)) {
            $categories = Category::query()->where('esta_activa', true)->orderBy('nombre')->pluck('nombre')->all();

            return [
                'message' => $categories
                    ? 'Estas son las categorías activas del catálogo: '.implode(', ', $categories).'.'
                    : 'En este momento no hay categorías activas para mostrar.',
                'products' => [],
            ];
        }

        $terms = array_values(array_diff(explode(' ', $normalized), [
            'busco', 'buscar', 'buscame', 'quiero', 'tienen', 'tiene', 'hay', 'muestrame', 'mostrar',
            'producto', 'productos', 'reloj', 'relojes', 'marca', 'modelo', 'precio', 'vale', 'cuesta',
            'disponible', 'disponibilidad', 'stock', 'cuanto', 'cual', 'que', 'el', 'la', 'los', 'las',
            'de', 'del', 'en', 'un', 'una', 'por', 'con', 'para', 'mas', 'menos', 'hasta', 'desde',
            'sobre', 'informacion', 'donde', 'como', 'funciona', 'tienda',
        ]));

        $query = Product::query()->active()->with(['category', 'inventory']);
        $this->applyPriceFilter($query, $message, $normalized);

        if ($terms !== []) {
            $query->where(function ($products) use ($terms): void {
                foreach (array_slice($terms, 0, 6) as $term) {
                    $products->orWhere('nombre', 'like', '%'.$term.'%')
                        ->orWhere('codigo_sku', 'like', '%'.$term.'%')
                        ->orWhereHas('category', fn ($category) => $category->where('nombre', 'like', '%'.$term.'%'));
                }
            });
        }

        $products = $query->orderBy('nombre')->limit(5)->get();

        if ($products->isEmpty() && $terms !== []) {
            $alternatives = Product::query()->active()->with(['category', 'inventory'])
                ->latest('creado_en')->limit(3)->get();

            return [
                'message' => $alternatives->isEmpty()
                    ? 'No encontré productos activos para mostrar en el catálogo.'
                    : 'No encontré una coincidencia exacta. Estas son algunas alternativas activas del catálogo.',
                'products' => $this->presentProducts($alternatives),
            ];
        }

        if ($products->isEmpty()) {
            return [
                'message' => $this->fallbackAnswer($normalized),
                'products' => [],
            ];
        }

        $messageText = 'Encontré '.($products->count() === 1 ? 'este producto' : 'estos productos').' activos en el catálogo.';
        if (str_contains($normalized, 'disponib') || str_contains($normalized, 'stock')) {
            $messageText = 'Esta es la disponibilidad registrada para los productos encontrados.';
        } elseif (str_contains($normalized, 'precio') || str_contains($normalized, 'cuesta') || str_contains($normalized, 'vale')) {
            $messageText = 'Estos son los precios actuales registrados para los productos encontrados.';
        }

        return [
            'message' => $messageText,
            'products' => $this->presentProducts($products),
        ];
    }

    private function applyPriceFilter($query, string $message, string $normalized): void
    {
        preg_match_all('/\d{1,3}(?:[.,]\d{3})+|\d+/', $message, $matches);
        $amounts = array_map(
            static fn (string $amount): int => (int) str_replace([',', '.'], '', $amount),
            $matches[0]
        );

        if (count($amounts) >= 2 && str_contains($normalized, 'entre')) {
            $query->whereRaw('COALESCE(NULLIF(precio_oferta, 0), precio) BETWEEN ? AND ?', [min($amounts[0], $amounts[1]), max($amounts[0], $amounts[1])]);
        } elseif ($amounts !== [] && preg_match('/\b(menos|menor|hasta|maximo|inferior|bajo)\b/', $normalized)) {
            $query->whereRaw('COALESCE(NULLIF(precio_oferta, 0), precio) <= ?', [$amounts[0]]);
        } elseif ($amounts !== [] && preg_match('/\b(mas|mayor|minimo|desde|superior)\b/', $normalized)) {
            $query->whereRaw('COALESCE(NULLIF(precio_oferta, 0), precio) >= ?', [$amounts[0]]);
        }
    }

    private function presentProducts($products): array
    {
        return $products->map(fn (Product $product): array => [
            'name' => $product->nombre,
            'category' => $product->category?->nombre,
            'image' => $product->image_url,
            'price' => $product->price,
            'stock' => $product->inventory?->cantidad,
            'url' => route('products.show', $product),
        ])->all();
    }

    private function fallbackAnswer(string $message): string
    {
        if (preg_match('/\b(envio|envios|devolucion|devoluciones|garantia|horario|contacto|pago|pagos)\b/', $message)) {
            return 'No tengo condiciones comerciales confirmadas sobre ese tema. Puedes consultar los canales oficiales de la tienda en el pie de página.';
        }

        if (preg_match('/\b(hola|buenas|buenos|ayuda)\b/', $message)) {
            return '¡Hola! Puedo buscar productos por marca, nombre, SKU, categoría, precio o disponibilidad.';
        }

        return 'Puedo ayudarte a buscar productos, categorías, precios y disponibilidad usando los datos del catálogo.';
    }
}
