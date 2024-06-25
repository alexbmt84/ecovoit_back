<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\EstablishmentController;

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

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Admin Middleware
Route::middleware(['auth:sanctum','admin'])->group(function () {

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'read']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);

    // Roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'read']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'delete']);

    // Vehicles
    Route::get('/vehicles', [VehicleController::class, 'index']);

    // Establishments
    Route::post('/establishments', [EstablishmentController::class ,'store']);
    Route::put('/establishments/{id}', [EstablishmentController::class , 'update'] );
    Route::delete('/establishments/{id}', [EstablishmentController::class , 'delete']);
});

// Authentication Middleware
Route::middleware(['auth:sanctum'])->group(function () {
    // Users
    Route::post('/me', [AuthController::class, 'me']);

    // Trips
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::get('/trips/{id}', [TripController::class, 'read']);
    Route::put('/trips/{id}', [TripController::class, 'update']);
    Route::delete('/trips/{id}', [TripController::class, 'delete']);

    // Vehicles
    Route::get('/vehicles/{id}', [VehicleController::class, 'read']);
    Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class, 'delete']);
    Route::post('/vehicles', [VehicleController::class, 'store']);


    // Establishments
    Route::get('/establishments', [EstablishmentController::class, 'index']);
    Route::get('/establishments/{id}', [EstablishmentController::class , 'show'] );


    Route::get('/users/{userId}/trips', [TripController::class, 'getUserTrips']);
});



