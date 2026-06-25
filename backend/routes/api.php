<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\AuthController;

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

// Rutas para la compra
Route::get('/pagar', [CompraController::class, 'pagar'])->name('pagar');

// Rutas para la gestión del carrito de compras
Route::middleware('auth:sanctum')->prefix('carrito')->group(function (){
    Route::get('/', [CarritoController::class, 'index']);
    Route::post('/', [CarritoController::class, 'store']);
    Route::put('/{id}', [CarritoController::class, 'update']);
    Route::delete('/{id}', [CarritoController::class, 'destroy']);
    Route::delete('/', [CarritoController::class, 'clear']);
});