<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;

//Auth
Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

// Categorías
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::middleware('jwt.verify')->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::patch('/categories/{id}', [CategoryController::class, 'updatePartial']);
});

// Servicios
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);

Route::middleware('jwt.verify')->group(function () {
    Route::post('/services', [ServiceController::class, 'store']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::patch('/services/{id}', [ServiceController::class, 'updatePartial']);
});

//Clientes
Route::middleware('jwt.verify')->group(function () {
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::patch('/clients/{id}', [ClientController::class, 'updatePartial']);
});