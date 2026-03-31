<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\AuthController;

// Rutas para la gestión de autopartes
Route::prefix('autoparts')->group(function () {
    Route::get('/', [AutopartController::class, 'index']);
    Route::post('/', [AutopartController::class, 'store']);
    Route::get('/{id}', [AutopartController::class, 'show']);
    Route::put('/{id}', [AutopartController::class, 'update']);
    Route::patch('/{id}', [AutopartController::class, 'updatePartial']);
    Route::delete('/{id}', [AutopartController::class, 'destroy']);
});

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'login])']);
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');

// Rutas para la compra
Route::get('/pagar', [CompraController::class, 'pagar'])->name('pagar');
Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');


// Rutas para autenticación
Route::post('/login', [AuthController::class, 'login'])->name('login');
