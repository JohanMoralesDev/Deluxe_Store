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
            ->with('category')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('home.index', compact('productosDestacados'));
    }

    public function newArrivals(): View
    {
        $products = Product::query()
            ->active()
            ->with(['category', 'inventory'])
            ->latest('creado_en')
            ->get();

        return view('store.nuevo', compact('products'));
    }
}
