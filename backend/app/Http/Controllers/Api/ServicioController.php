<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Listar todos los servicios (GET /api/servicios)
     */
    public function index(Request $request)
    {
        // Si se pasa un id_salon, filtramos por él
        if ($request->has('id_salon')) {
            return Servicio::where('id_salon', $request->id_salon)->get();
        }

        // Si no, devolvemos todos los servicios
        return Servicio::all();
    }

    /**
     * Crear un nuevo servicio (POST /api/servicios)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'     => 'required|string|max:255',
            'descripcion'=> 'required|string|max:500',
            'precio'     => 'required|numeric|min:0',
            'duracion'   => 'required|integer|min:1',
            'id_salon'   => 'required|exists:salon,id_salon',
        ]);

        $servicio = Servicio::create($validated);

        return response()->json($servicio, 201);
    }

    /**
     * Mostrar un servicio por ID (GET /api/servicios/{id})
     */
    public function show(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return response()->json($servicio);
    }

    /**
     * Actualizar un servicio (PUT/PATCH /api/servicios/{id})
     */
    public function update(Request $request, string $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validated = $request->validate([
            'nombre'     => 'sometimes|required|string|max:255',
            'descripcion'=> 'sometimes|required|string|max:500',
            'precio'     => 'sometimes|required|numeric|min:0',
            'duracion'   => 'sometimes|required|integer|min:1',
            'id_salon'   => 'sometimes|required|exists:salon,id_salon',
        ]);

        $servicio->update($validated);

        return response()->json($servicio);
    }

    /**
     * Eliminar un servicio (DELETE /api/servicios/{id})
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente']);
    }
}
