<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para Productos
Route::resource('products', ProductController::class);

// Rutas base para Mesas
Route::resource('tables', TableController::class);

// Lógica de estados de mesa
Route::post('/tables/{table}/open', [TableController::class, 'open'])->name('tables.open');
Route::post('/tables/{table}/close', [TableController::class, 'close'])->name('tables.close');

// Lógica de Pedidos (AQUÍ ESTÁ LA SOLUCIÓN AL ERROR)
Route::get('/tables/{table}/show', [TableController::class, 'show'])->name('tables.show');
Route::post('/tables/{table}/add-product', [TableController::class, 'addProduct'])->name('tables.add-product');
