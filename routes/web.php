<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::view('/', 'home.index')->name('store.index');
Route::view('/nuevo', 'store.nuevo')->name('store.nuevo');
Route::get('/catalogo', [ProductController::class, 'index'])->name('store.catalogo');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');
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
Route::get('/admin', [DashboardController::class, 'index'])
    ->name('admin.index');

Route::get('/admin/productos', [AdminProductController::class, 'index'])
    ->name('admin.productos.index');

// Rutas de autenticación
Route::post('/login', [LoginController::class, 'login'])
    ->name('auth.login.store');

Route::post('/registro', [RegisterController::class, 'register'])
    ->name('auth.register.store');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
