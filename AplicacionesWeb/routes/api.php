<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\PedidoController;

Route::get('/autoparts', [AutopartController::class, 'index']);
Route::post('/autoparts', [AutopartController::class, 'store']);
Route::get('/autoparts/{id}', [AutopartController::class, 'show']);
Route::put('/autoparts/{id}', [AutopartController::class, 'update']);
Route::patch('/autoparts/{id}', [AutopartController::class, 'updatePartial']);
Route::delete('/autoparts/{id}', [AutopartController::class, 'destroy']);
Route::post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');

// Rutas para la compra
Route::get('/pagar', [CompraController::class, 'pagar'])->name('pagar');
Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');