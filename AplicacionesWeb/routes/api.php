<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\autopartController;


Route::get('/autopart', [autopartController::class, 'index']);

Route::get('/autopart/{id}', [autopartController::class, 'show']);

Route::post('/autopart', [autopartController::class, 'store']);

Route::put('/autopart/{id}', [autopartController::class, 'update']);

Route::patch('/autopart/{id}', [autopartController::class, 'updatePartial']);

Route::delete('/autopart/{id}', [autopartController::class, 'destroy']);