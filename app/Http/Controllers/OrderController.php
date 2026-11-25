<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
    ) {}

    public function checkout(): View|RedirectResponse
    {
        $summary = $this->cartService->summary();

        if ($summary['count'] === 0) {
            return redirect()->route('store.carrito')
                ->with('error', 'Agrega productos al carrito antes de continuar.');
        }

        return view('orders.confirmation', [
            'items' => $summary['items'],
            'total' => $summary['total'],
            'issues' => $summary['issues'],
            'checkout' => true,
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = $this->orderService->create(
                $request->user(),
                $request->validated()
            );
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('orders.confirmation', $order)
            ->with('success', 'Compra registrada correctamente.');
    }

    public function index(): View
    {
        $orders = Order::query()
            ->where('id_usuario', Auth::id())
            ->withCount('details')
            ->latest('fecha_pedido')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorizeOwnership($order);

        return view('orders.show', [
            'order' => $order->load('details'),
        ]);
    }

    public function confirmation(Order $order): View
    {
        $this->authorizeOwnership($order);

        return view('orders.confirmation', [
            'order' => $order->load('details'),
            'checkout' => false,
        ]);
    }

    private function authorizeOwnership(Order $order): void
    {
        abort_unless((int) $order->id_usuario === (int) Auth::id(), 403);
    }
}