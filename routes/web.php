<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('store.index');
Route::view('/nuevo', 'store.nuevo')->name('store.nuevo');
Route::view('/catalogo', 'products.index')->name('store.catalogo');
Route::view('/carrito', 'cart.index')->name('store.carrito');

// Panel administrativo
Route::view('/admin', 'admin')->name('admin.index');
use App\Http\Controllers\Auth\RegisterController;
Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/registro', [RegisterController::class, 'register'])
    ->name('register.store');