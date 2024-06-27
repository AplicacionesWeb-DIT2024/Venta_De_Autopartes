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

// Redirigir a los usuarios al listado de autopartes después de iniciar sesión
Route::get('/home', [AutopartController::class, 'showAutoparts'])->name('home');

// Rutas para el rol Empleado
Route::middleware(['auth', 'role:Empleado'])->group(function () {
    Route::get('/empleado', [HomeController::class, 'empleado'])->name('empleado');
    Route::get('/autoparts/create', [AutopartController::class, 'create'])->name('autopartes.create');
    Route::post('/autoparts', [AutopartController::class, 'store'])->name('autopartes.store');
    Route::get('/autoparts', [AutopartController::class, 'showAutoparts'])->name('autopartes.index');
    Route::put('/autoparts/{id}', [AutopartController::class, 'update'])->name('autopartes.update');
    Route::get('/autoparts/{id}/edit', [AutopartController::class, 'edit'])->name('autopartes.edit');
    Route::delete('/autoparts/{id}', [AutopartController::class, 'destroy'])->name('autopartes.destroy');
});

// Rutas para el rol Cliente
Route::middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('/cliente', [HomeController::class, 'cliente'])->name('cliente');
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/store', [CarritoController::class, 'store'])->name('carrito.store');
    Route::put('/carrito/{id}', [CarritoController::class, 'update'])->name('carrito.update');
    Route::get('/carrito/{id}/edit', [CarritoController::class, 'edit'])->name('carrito.edit');
    Route::delete('/carrito/{id}', [CarritoController::class, 'destroy'])->name('carrito.destroy');
    Route::get('/autopartes/{id}', [AutopartController::class, 'show'])->name('autopartes.show');
    Route::get('/pagar', [CompraController::class, 'pagar'])->name('pagar');
    Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
});