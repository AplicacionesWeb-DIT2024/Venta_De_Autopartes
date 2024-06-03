<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;
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

//Rutas para los roles

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas para el rol Cliente
Route::middleware(['auth', 'rolekey'])->group(function () {
    Route::get('/cliente', [HomeController::class, 'cliente'])->name('cliente');
});

// Rutas para el rol Empleado
Route::middleware(['auth', 'rolekey'])->group(function () {
    Route::get('/empleado', [HomeController::class, 'empleado'])->name('empleado');
});