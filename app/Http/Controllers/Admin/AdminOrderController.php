<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->when($request->filled('estado'), fn ($query) => $query->where('estado', $request->string('estado')))
            ->latest('fecha_pedido')
            ->paginate(15)
            ->withQueryString();

        $estados = Order::query()->select('estado')->distinct()->orderBy('estado')->pluck('estado');

        return view('admin.orders.index', compact('orders', 'estados'));
    }

    public function show(Order $order): View
    {
        $order->load(['details.product']);

        return view('admin.orders.show', compact('order'));
    }
}
