<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de creación de autopartes//
// Ruta para mostrar el formulario de creación
Route::get('/autoparts/create', [AutopartController::class, 'create'])->name('autopartes.create');

// Ruta para manejar el formulario de creación
Route::post('/autoparts', [AutopartController::class, 'store'])->name('autopartes.store');



// Ruta para ver el listado de autopartes.
Route::get('/autoparts', [AutopartController::class, 'showAutoparts'])->name('autopartes.index');


//Rutas de edición de autpartes//
// Ruta para mostrar el formulario de edición
//Route::get('/autoparts/edit', [AutopartController::class, 'edit'])->name('autopartes.edit');

// Ruta para manejar el formulario de edición
//Route::put('/autoparts', [AutopartController::class, 'store'])->name('autopartes.store');
