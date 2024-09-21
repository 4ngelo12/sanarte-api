<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UsuarioController;

//Auth
Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

// Users

Route::middleware('jwt.verify')->group(function () {
    Route::get('/users/list/{id}', [UsuarioController::class, 'index']);
    Route::get('/users/{id}', [UsuarioController::class, 'show']);
    Route::patch('/users/{id}', [UsuarioController::class, 'updatePartial']);
    Route::delete('/users/{id}', [UsuarioController::class, 'destroy']);
});

// Roles
Route::middleware('jwt.verify')->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
});

// Categorías
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::middleware('jwt.verify')->group(function () {
    Route::get('/categories/list/active', [CategoryController::class, 'categoriesActive']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::patch('/categories/{id}', [CategoryController::class, 'updatePartial']);
});

// Servicios
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);

Route::middleware('jwt.verify')->group(function () {
    Route::get('/services/list/active', [ServiceController::class, 'servicesActive']);
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

// Status
Route::middleware('jwt.verify')->group(function () {
    Route::get('/status', [StatusController::class, 'index']);
    Route::post('/status', [StatusController::class, 'store']);
});

// Reservations
Route::middleware('jwt.verify')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::patch('/reservations/{id}', [ReservationController::class, 'updatePartial']);
});

// Home
Route::middleware('jwt.verify')->group(function () {
    Route::get('/top-services-last-month', [HomeController::class, 'topServicesLastMonth']);
    Route::get('/top-days-last-month', [HomeController::class, 'topDaysLastMonth']);
});

// Personal
Route::middleware('jwt.verify')->group(function () {
    Route::get('/personal', [PersonalController::class, 'index']);
    Route::get('/personal/list/active/{id}', [PersonalController::class, 'personalActiveByServiceId']);
    Route::get('/personal/{id}', [PersonalController::class, 'show']);
    Route::post('/personal', [PersonalController::class, 'store']);
    Route::delete('/personal/{id}', [PersonalController::class, 'destroy']);
    Route::patch('/personal/{id}', [PersonalController::class, 'updatePartial']);
    Route::put('/personal/{id}', [PersonalController::class, 'update']);
});