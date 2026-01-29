<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

// 1. REDIRECCIÓN INICIAL
Route::get('/', fn() => redirect()->route('login'));

// 2. RUTAS DE AUTENTICACIÓN (Públicas)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// 3. RUTAS PROTEGIDAS (Solo usuarios logueados + Bloqueo de historial)
Route::middleware(['auth', 'prevent-back'])->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index']);

    // Módulo de Mesas y Pedidos
    Route::resource('tables', TableController::class);
    Route::post('/tables/{table}/open', [TableController::class, 'open'])->name('tables.open');
    Route::post('/tables/{table}/close', [TableController::class, 'close'])->name('tables.close');
    Route::get('/tables/{table}/show', [TableController::class, 'show'])->name('tables.show');
    Route::post('/tables/{table}/add-product', [TableController::class, 'addProduct'])->name('tables.add-product');
    Route::delete('/orders/{order}', [TableController::class, 'removeProduct'])->name('orders.remove');

    // Inventario y Productos
    Route::resource('products', ProductController::class);
    Route::get('/inventory', [ProductController::class, 'inventory'])->name('inventory.index');
    Route::get('/inventory/pdf', [ProductController::class, 'generateInventoryPDF'])->name('inventory.pdf');

    // Surtido / Compras
    Route::get('/surtido', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/surtido', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/surtido/pdf', [PurchaseController::class, 'generatePDF'])->name('purchases.pdf');

    // Reportes de Ventas
    Route::get('/sales-report', [TableController::class, 'salesReport'])->name('sales.report');
    Route::get('/sales/report/pdf', [TableController::class, 'downloadPDF'])->name('sales.pdf');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Verificación de Email
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
