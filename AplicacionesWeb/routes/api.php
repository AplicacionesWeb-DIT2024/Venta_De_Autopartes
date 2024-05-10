<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/autopartes', function () {
    return 'Creando Autopartes';
});

Route::put('/autopartes/{id}', function () {
    return 'Actualizando una Autoparte';
});

Route::get('/autopartes', function () {
    return 'Mostrando listado de Autopartes';
});

Route::get('/autopartes/{id}', function () {
    return 'Mostrando una Autoparte';
});


Route::delete('/autopartes/{id}', function () {
    return 'Eliminando una Autopartes';
});