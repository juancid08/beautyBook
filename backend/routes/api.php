<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('usuarios', UsuarioController::class);

Route::apiResource('cadenas', CadenaSalonController::class);
Route::apiResource('salones', SalonController::class);

Route::apiResource('empleados', EmpleadoController::class);
Route::get('salones/{id}/empleados', [EmpleadoController::class, 'porSalon']);

Route::apiResource('servicios', ServicioController::class);

Route::apiResource('citas', CitaController::class);
Route::get('usuarios/{id}/citas', [CitaController::class, 'porUsuario']);

Route::apiResource('resenas', ResenaController::class);

Route::get('salones/{id}/empleados', [EmpleadoController::class, 'porSalon']);
Route::get('usuarios/{id}/citas', [CitaController::class, 'porUsuario']);
Route::get('servicios/{id}/resenas', [ResenaController::class, 'porServicio']);
