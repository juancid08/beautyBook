<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Middleware\Log;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): 
     */
    public function handle(Request $request, Closure $next)
    {
        //Para cambiar los idiomas 

        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);

        // Verificación administrador o cliente
        if (! $request->user() || $request->user()->rol !== 'administrador') {
            Log::warning('IsAdmin abort, rol no válido', ['user' => $request->user()]);
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
