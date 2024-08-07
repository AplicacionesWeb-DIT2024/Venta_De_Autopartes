<?php

use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas accesibles para todos los usuarios autenticados
Route::middleware('auth')->group(function () {
    // Redirigir a los usuarios al listado de autopartes después de iniciar sesión
    Route::get('/home', [AutopartController::class, 'index'])->name('home');
    Route::get('/autoparts', [AutopartController::class, 'index'])->name('autopartes.index');
    Route::get('/autoparts/{id}', [AutopartController::class, 'show'])->name('autopartes.show');
});

// Rutas para el rol Cliente
Route::middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/store', [CarritoController::class, 'store'])->name('carrito.store');
    Route::delete('/carrito/{id}', [CarritoController::class, 'destroy'])->name('carrito.destroy');
    Route::put('/carrito/{id}', [CarritoController::class, 'update'])->name('carrito.update');
    Route::get('/carrito/{id}/edit', [CarritoController::class, 'edit'])->name('carrito.edit');

    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');

    Route::get('/pagar', [CompraController::class, 'pagar'])->name('pagar');
    Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');

    Route::get('/cliente', [HomeController::class, 'cliente'])->name('cliente');


    Route::put('/autopartes/{id}', [AutopartController::class, 'update'])->name('autopartes.update');
    Route::get('/autopartes/{id}/edit', [AutopartController::class, 'edit'])->name('autopartes.edit');
    Route::delete('/autopartes/{id}', [AutopartController::class, 'destroy'])->name('autopartes.destroy');
});

// Rutas para el rol Empleado
Route::middleware(['auth', 'role:Empleado'])->group(function () {
    Route::get('/empleado', [HomeController::class, 'empleado'])->name('empleado');
    Route::get('/autopartes/create', [AutopartController::class, 'create'])->name('autopartes.create');
    Route::post('/autopartes', [AutopartController::class, 'store'])->name('autopartes.store');
    Route::put('/autopartes/{id}', [AutopartController::class, 'update'])->name('autopartes.update');
    Route::get('/autopartes/{id}/edit', [AutopartController::class, 'edit'])->name('autopartes.edit');
    Route::delete('/autopartes/{id}', [AutopartController::class, 'destroy'])->name('autopartes.destroy');
});