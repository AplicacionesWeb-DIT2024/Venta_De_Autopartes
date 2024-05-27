<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;

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