<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registrar nuevo usuario y devolver token.
     */
    public function register(Request $request)
    {
        // 1. Validación
        $data = $request->validate([
            'nombre'                  => 'required|string|max:255',
            'apellidos'               => 'required|string|max:255',
            'email'                   => 'required|email|unique:usuario,email',
            'password'                => 'required|string|min:6|confirmed',
            'password_confirmation'   => 'required|string|min:6'
        ]);

        // 2. Crear usuario
        $usuario = Usuario::create([
            'nombre'     => $data['nombre'],
            'apellidos'  => $data['apellidos'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 3. Generar token
        $token = $usuario->createToken('token-api')->plainTextToken;

        // 4. Devolver JSON con usuario y token
        return response()->json([
            'usuario' => $usuario,
            'token'   => $token,
        ], 201);
    }

    /**
     * Iniciar sesión de usuario y generar un token de acceso.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (! $usuario || ! Hash::check($request->password, $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        $token = $usuario->createToken('token-api')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'token'   => $token,
        ]);
    }

    /**
     * Cerrar sesión del usuario autenticado (revoca el token actual).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada']);
    }
}
