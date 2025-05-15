<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    /**
     * Listar todos los salones (GET /api/salones)
     */
    public function index()
    {
        return response()->json(Salon::all());
    }

    /**
     * Crear un nuevo salón (POST /api/salones)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:255',
            'direccion'         => 'required|string|max:255',
            'telefono'          => 'required|string|max:20',
            'horario_apertura'  => 'required|string|max:10',
            'horario_cierre'    => 'required|string|max:10',
            'descripcion'       => 'nullable|string|max:500',
            'foto'              => 'nullable|string',
            'id_cadena_salon'   => 'required|exists:cadena_salon,id_cadena_salon',
        ]);

        $salon = Salon::create($validated);

        return response()->json($salon, 201);
    }

    /**
     * Mostrar un salón por ID (GET /api/salones/{id})
     */
    public function show(string $id)
    {
        $salon = Salon::findOrFail($id);
        return response()->json($salon);
    }

    /**
     * Actualizar un salón (PUT/PATCH /api/salones/{id})
     */
    public function update(Request $request, string $id)
    {
        $salon = Salon::findOrFail($id);

        $validated = $request->validate([
            'nombre'            => 'sometimes|required|string|max:255',
            'direccion'         => 'sometimes|required|string|max:255',
            'telefono'          => 'sometimes|required|string|max:20',
            'horario_apertura'  => 'sometimes|required|string|max:10',
            'horario_cierre'    => 'sometimes|required|string|max:10',
            'descripcion'       => 'nullable|string|max:500',
            'foto'              => 'nullable|string',
            'id_cadena_salon'   => 'sometimes|required|exists:cadena_salon,id_cadena_salon',
        ]);

        $salon->update($validated);

        return response()->json($salon);
    }

    /**
     * Eliminar un salón (DELETE /api/salones/{id})
     */
    public function destroy(string $id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();

        return response()->json(['message' => 'Salón eliminado correctamente']);
    }
}
