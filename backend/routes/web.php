<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\SalonController;
use App\Http\Controllers\Admin\ResenaController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login / Logout
Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

// Rutas protegidas para administración
Route::middleware(['auth', IsAdmin::class])
     ->prefix('admin')
     ->name('admin.')
     ->group(function(){
         // Dashboard
         Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

         // Recursos
         Route::resource('usuarios',  UsuarioController::class);
         // Aquí forzamos el singular {salon} en lugar de {salone}
         Route::resource('salones',   SalonController::class)
              ->parameters(['salones' => 'salon']);
         Route::resource('servicios', ServicioController::class);
         Route::resource('empleados', EmpleadoController::class);
         Route::resource('citas',     CitaController::class);
         Route::resource('resenas',   ResenaController::class);
});

Route::get('lang/{locale}', function($locale){
    if (in_array($locale, ['es','en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');
