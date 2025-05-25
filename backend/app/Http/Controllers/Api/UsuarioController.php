<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    /**
     * Mostrar todos los usuarios (GET /api/usuarios)
     */
    public function index()
    {
        return response()->json(Usuario::all());
    }

    /**
     * Crear un nuevo usuario (POST /api/usuarios)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'     => 'required|string|max:255',
            'email'      => 'required|email|unique:usuario,email',
            'password'   => 'required|string|min:6',
            'telefono'   => 'nullable|string|max:20',
            'rol'        => 'required|in:cliente,administrador',
            'foto_perfil'=> 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $usuario = Usuario::create($validated);

        return response()->json($usuario, 201);
    }

    /**
     * Mostrar un usuario específico (GET /api/usuarios/{id})
     */
    public function show(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Actualizar un usuario existente (PUT/PATCH /api/usuarios/{id})
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validated = $request->validate([
            'nombre'     => 'sometimes|required|string|max:255',
            'email'      => 'sometimes|required|email|unique:usuario,email,' . $id . ',id_usuario',
            'password'   => 'nullable|string|min:6',
            'telefono'   => 'nullable|string|max:20',
            'rol'        => 'sometimes|required|in:cliente,administrador',
            'foto_perfil' => $request->hasFile('foto_perfil')
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'nullable|string'
        ]);

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('perfiles', 'public');
            $validated['foto_perfil'] = asset('storage/' . $path);
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return response()->json($usuario);
    }

    /**
     * Eliminar un usuario (DELETE /api/usuarios/{id})
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function porSalon($id)
    {
        $servicios = Servicio::where('id_salon', $id)->get();
        return response()->json($servicios);

    }
}
