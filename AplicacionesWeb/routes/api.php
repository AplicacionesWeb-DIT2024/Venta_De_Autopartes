<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;

Route::get('/autoparts', [AutopartController::class, 'index']);
Route::post('/autoparts', [AutopartController::class, 'store']);
Route::get('/autoparts/{id}', [AutopartController::class, 'show']);
Route::put('/autoparts/{id}', [AutopartController::class, 'update']);
Route::patch('/autoparts/{id}', [AutopartController::class, 'updatePartial']);
Route::delete('/autoparts/{id}', [AutopartController::class, 'destroy']);
//Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');