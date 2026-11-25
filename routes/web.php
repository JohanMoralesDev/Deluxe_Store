<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ========================================
// RUTAS PÚBLICAS
// ========================================

Route::view('/', 'home.index')->name('store.index');

Route::view('/nuevo', 'store.nuevo')->name('store.nuevo');

Route::get('/catalogo', [ProductController::class, 'index'])
    ->name('store.catalogo');

// ========================================
// CARRITO DE COMPRAS
// ========================================

Route::get('/carrito', [CartController::class, 'index'])
    ->name('store.carrito');

Route::post('/carrito/agregar/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::put('/carrito/actualizar/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/carrito/eliminar/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::delete('/carrito/vaciar', [CartController::class, 'clear'])
    ->name('cart.clear');

// ========================================
// REGISTRO E INICIO DE SESIÓN
// ========================================

Route::middleware('guest')->group(function () {

    Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/registro', [RegisterController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.store');

});

// ========================================
// PERFIL Y CIERRE DE SESIÓN
// ========================================

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/perfil', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/perfil', [ProfileController::class, 'update'])
        ->name('profile.update');

});

// ========================================
// ADMINISTRACIÓN
// ========================================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // Panel principal
        Route::view('/inicio', 'admin.index')
            ->name('admin.index');

        // Gestión de productos
        Route::resource('productos', ProductController::class)
            ->names('admin.products');

        // Gestión de categorías
        Route::resource('categorias', CategoryController::class)
            ->names('admin.categories');

    });
