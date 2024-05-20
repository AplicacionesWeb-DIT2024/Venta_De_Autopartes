<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutopartController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar el formulario de creación
Route::get('/autoparts/create', [AutopartController::class, 'create'])->name('autopartes.create');

// Ruta para manejar el formulario de creación
Route::post('/autoparts', [AutopartController::class, 'store'])->name('autopartes.store');