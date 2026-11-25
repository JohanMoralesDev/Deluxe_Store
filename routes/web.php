<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('store.index');
Route::view('/nuevo', 'store.nuevo')->name('store.nuevo');
Route::get('/catalogo', [ProductController::class, 'index'])->name('store.catalogo');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/carrito', [CartController::class, 'index'])->name('store.carrito');
Route::post('/carrito/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
    Route::post('/registro', [RegisterController::class, 'register'])->name('register.store');
    Route::post('/login-modal', [LoginController::class, 'login'])->name('auth.login.store');
    Route::post('/registro-modal', [RegisterController::class, 'register'])->name('auth.register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/pedidos/{order}/confirmacion', [OrderController::class, 'confirmation'])->name('orders.confirmation');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/productos', [AdminProductController::class, 'index'])->name('admin.productos.index');

    Route::resource('administrar-productos', ProductController::class)
        ->parameters(['administrar-productos' => 'product'])
        ->names('admin.products');

    Route::resource('categorias', CategoryController::class)->names('admin.categories');
});
