<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
//LOGICA LOGIN 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\HomeController;


//////////////////ROLES/////////////////
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmpleadoController;
//////////////////ROLES/////////////////
//LOGICA LOGIN
use PHPUnit\Metadata\Group;

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
Route::delete('/orders/{order}', [TableController::class, 'removeProduct'])->name('orders.remove');
Route::get('/sales-report', [TableController::class, 'salesReport'])->name('sales.report');
Route::get('/sales/report/pdf', [TableController::class, 'downloadPDF'])->name('sales.pdf');
/////////////////////////////////////////////////////////
//Logica Login,Registro y acceso
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registro
    Route::get('/register', [RegisterController::class, 'create'])->name('register'); //  formulario
    Route::post('/register', [RegisterController::class, 'store']); // proceso de formulario

    // Recuperación de contraseña
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

/////////////////////////////////////////////////////ROLES///////////////////////
//7 Redireccionamiento de vistas a roles 

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//////////////////////////////////////////////////////ROLES//////////////////////

// Verificación de email
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

// Autenticado
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Inicio
Route::get('/', fn() => redirect()->route('login'));



Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index']);
});