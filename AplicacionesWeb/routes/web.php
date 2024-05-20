<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutopartController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar el formulario de creación
Route::get('/autoparts/create', [AutopartController::class, 'create'])->name('autoparts.create');

// Ruta para manejar el formulario de creación
//Route::post('/autoparts', [AutopartController::class, 'store'])->name('autoparts.store');