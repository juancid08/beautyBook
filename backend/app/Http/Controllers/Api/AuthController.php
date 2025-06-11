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
        $rules = [
            'nombre'                => 'required|string|max:255',
            'apellidos'             => 'required|string|max:255',
            'email'                 => 'required|email|unique:usuario,email',
            'password'              => 'required|string|min:7|confirmed',
            'password_confirmation' => 'required|string|min:7',
        ];

        $messages = [
            'nombre.required'                  => 'El nombre es obligatorio.',
            'apellidos.required'               => 'Los apellidos son obligatorios.',
            'email.required'                   => 'El correo electrónico es obligatorio.',
            'email.email'                      => 'Debe ingresar un correo electrónico válido.',
            'email.unique'                     => 'Ese correo ya está registrado.',
            'password.required'                => 'La contraseña es obligatoria.',
            'password.min'                     => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed'               => 'Las contraseñas no coinciden.',
            'password_confirmation.required'   => 'Debe repetir la contraseña.',
            'password_confirmation.min'        => 'La confirmación debe tener al menos :min caracteres.',
        ];

        $data = $request->validate($rules, $messages);

        $usuario = Usuario::create([
            'nombre'     => $data['nombre'],
            'apellidos'  => $data['apellidos'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        $token = $usuario->createToken('token-api')->plainTextToken;

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
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Debe ingresar un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
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
