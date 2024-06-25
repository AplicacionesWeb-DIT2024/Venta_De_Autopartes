<?php
use App\Http\Controllers\Api\AutopartController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de creación de autopartes
Route::get('/autoparts/create', [AutopartController::class, 'create'])->name('autopartes.create');
Route::post('/autoparts', [AutopartController::class, 'store'])->name('autopartes.store');

// Ruta para ver el listado de autopartes
Route::get('/autoparts', [AutopartController::class, 'showAutoparts'])->name('autopartes.index');

// Rutas de edición de autopartes
Route::put('/autoparts/{id}', [AutopartController::class, 'update'])->name('autopartes.update');
Route::get('/autoparts/{id}/edit', [AutopartController::class, 'edit'])->name('autopartes.edit');

// Rutas de eliminación de autopartes
Route::delete('/autoparts/{id}', [AutopartController::class, 'destroy'])->name('autopartes.destroy');

// Ruta para ver el listado de pedidos
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');

// Rutas de creación de pedidos
Route::post('/carrito/store', [CarritoController::class, 'store'])->name('carrito.store');

// Rutas de edición de autopartes
Route::put('/carrito/{id}', [AutopartController::class, 'update'])->name('carrito.update');
Route::get('/carrito/{id}/edit', [AutopartController::class, 'edit'])->name('carrito.edit');

// Rutas de eliminación de pedidos
Route::delete('/carrito/{id}', [AutopartController::class, 'destroy'])->name('carrito.destroy');
Route::resource('carrito', CarritoController::class);

// Ruta de eliminación de productos del carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::delete('/carrito/{id}', [CarritoController::class, 'destroy'])->name('carrito.destroy');

// Para ver el detalle de las autopartes.
Route::get('/autopartes/{id}', [AutopartController::class, 'show'])->name('autopartes.show');

// Rutas para confirmar el pago
Route::get('/pagar', [CompraController::class, 'pagar'])->name('pagar');
Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');


Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');