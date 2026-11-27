<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $productosDestacados = Product::query()
            ->active()
            ->whereHas('orderDetails')
            ->with('category')
            ->withSum('orderDetails as unidades_vendidas', 'cantidad')
            ->orderByDesc('unidades_vendidas')
            ->take(4)
            ->get();

        return view('home.index', compact('productosDestacados'));
    }

    public function newArrivals(): View
    {
        $products = Product::query()
            ->active()
            ->with(['category', 'inventory'])
            ->latest('creado_en')
            ->paginate(8);

        return view('store.nuevo', compact('products'));
    }
}
