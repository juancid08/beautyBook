<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CadenaSalon;
use Illuminate\Http\Request;

class CadenaSalonController extends Controller
{
    /**
     * Listar todas las cadenas (GET /api/cadenas)
     */
    public function index()
    {
        return response()->json(CadenaSalon::all());
    }

    /**
     * Crear una nueva cadena (POST /api/cadenas)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'             => 'required|string|max:255',
            'direccion_central'  => 'required|string|max:255',
            'telefono'           => 'required|string|max:20',
            'correo_contacto'    => 'required|email|max:255',
            'website'            => 'nullable|string|max:255',
            'descripcion'        => 'nullable|string|max:500',
        ]);

        $cadena = CadenaSalon::create($validated);

        return response()->json($cadena, 201);
    }

    /**
     * Mostrar una cadena específica (GET /api/cadenas/{id})
     */
    public function show(string $id)
    {
        $cadena = CadenaSalon::findOrFail($id);
        return response()->json($cadena);
    }

    /**
     * Actualizar una cadena (PUT/PATCH /api/cadenas/{id})
     */
    public function update(Request $request, string $id)
    {
        $cadena = CadenaSalon::findOrFail($id);

        $validated = $request->validate([
            'nombre'             => 'sometimes|required|string|max:255',
            'direccion_central'  => 'sometimes|required|string|max:255',
            'telefono'           => 'sometimes|required|string|max:20',
            'correo_contacto'    => 'sometimes|required|email|max:255',
            'website'            => 'nullable|string|max:255',
            'descripcion'        => 'nullable|string|max:500',
        ]);

        $cadena->update($validated);

        return response()->json($cadena);
    }

    /**
     * Eliminar una cadena (DELETE /api/cadenas/{id})
     */
    public function destroy(string $id)
    {
        $cadena = CadenaSalon::findOrFail($id);
        $cadena->delete();

        return response()->json(['message' => 'Cadena eliminada correctamente']);
    }
}
