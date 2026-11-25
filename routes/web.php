<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::view('/', 'home.index')->name('store.index');
Route::view('/nuevo', 'store.nuevo')->name('store.nuevo');
Route::view('/catalogo', 'products.index')->name('store.catalogo');
Route::get('/carrito', [CartController::class, 'index'])->name('store.carrito');
Route::get('/login', fn () => redirect()->route('store.index'))
    ->name('login');

Route::post('/carrito/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/pedidos/{order}/confirmacion', [OrderController::class, 'confirmation'])->name('orders.confirmation');
});

// Panel administrativo
Route::view('/admin', 'admin')->name('admin.index');
