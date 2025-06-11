<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\SalonController;
use App\Http\Controllers\Api\EmpleadoController;
use App\Http\Controllers\Api\ServicioController;
use App\Http\Controllers\Api\CitaController;
use App\Http\Controllers\Api\ResenaController;
use App\Http\Controllers\Api\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
}); 


// Rutas de usuarios
Route::apiResource('usuarios', UsuarioController::class);
Route::get('usuarios/{id}/citas', [CitaController::class, 'porUsuario']);
Route::get('usuarios/{id}/salones', [SalonController::class, 'porUsuario']);

// Rutas de salones
Route::get('salones/sugerencias', [SalonController::class, 'sugerencias']);
Route::apiResource('salones', SalonController::class);
Route::get('salones/{id}/resenas', [ResenaController::class, 'porSalon']);
Route::get('salones/{id}/empleados', [EmpleadoController::class, 'porSalon']);
Route::get('salones/{id}/servicios', [ServicioController::class, 'porSalon']);

// Rutas de empleados
Route::apiResource('empleados', EmpleadoController::class);

// Rutas de servicios
Route::apiResource('servicios', ServicioController::class);

// Rutas de citas
Route::apiResource('citas', CitaController::class);

// Rutas de reseñas
Route::apiResource('resenas', ResenaController::class);
Route::get('servicios/{id}/resenas', [ResenaController::class, 'porServicio']);
