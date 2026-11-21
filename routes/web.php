<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'store.index')->name('store.index');
Route::view('/nuevo', 'store.nuevo')->name('store.nuevo');
Route::view('/catalogo', 'store.catalogo')->name('store.catalogo');
Route::view('/carrito', 'store.carrito')->name('store.carrito');
