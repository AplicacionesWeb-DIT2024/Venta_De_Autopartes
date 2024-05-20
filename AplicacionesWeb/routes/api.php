<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutopartController;

Route::get('/autoparts', [AutopartController::class, 'index']);
Route::get('/autoparts/{id}', [AutopartController::class, 'show']);
Route::post('/autoparts', [AutopartController::class, 'store']);
Route::put('/autoparts/{id}', [AutopartController::class, 'update']);
Route::patch('/autoparts/{id}', [AutopartController::class, 'updatePartial']);
Route::delete('/autoparts/{id}', [AutopartController::class, 'destroy']);