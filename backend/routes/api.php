<?php

/* Acá es donde se registran las rutas API para que las registre Laravel. */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PedidoController;

// Rutas para la gestión de autopartes
Route::middleware('auth:sanctum')->prefix('autoparts')->group(function () {
    Route::get('/', [AutopartController::class, 'index']);
    Route::post('/', [AutopartController::class, 'store']);
    Route::get('/{id}', [AutopartController::class, 'show']);
    Route::put('/{id}', [AutopartController::class, 'update']);
    Route::patch('/{id}', [AutopartController::class, 'updatePartial']);
    Route::delete('/{id}', [AutopartController::class, 'destroy']);
});

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Rutas para la gestión del carrito de compras
Route::middleware('auth:sanctum')->prefix('carrito')->group(function () {
    Route::get('/', [CarritoController::class, 'index']);
    Route::post('/', [CarritoController::class, 'store']);
    Route::put('/{id}', [CarritoController::class, 'update']);
    Route::delete('/{id}', [CarritoController::class, 'destroy']);
    Route::delete('/', [CarritoController::class, 'clear']);
});

// Ruta para confirmar la compra
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comprar', [CompraController::class, 'procesarCompra']);
});

//Rutas para los pedidos
Route::middleware('auth:sanctum')->prefix('pedidos')->group(function () {
    Route::get('/', [PedidoController::class, 'index']);
    Route::get('/{id}', [PedidoController::class, 'show']);
});
