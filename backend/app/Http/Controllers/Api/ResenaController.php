<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resena;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    /**
     * Listar todas las reseñas (GET /api/resenas)
     */
    public function index(Request $request)
    {
        // Si se pasa un id_servicio, filtramos por él
        if ($request->has('id_servicio')) {
            return Resena::where('id_servicio', $request->id_servicio)->get();
        }

        // Si no, devolvemos todos los Resenas
        return Resena::all();
    }

    /**
     * Crear una nueva reseña (POST /api/resenas)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comentario'    => 'required|string|max:500',
            'calificacion'  => 'required|integer|min:1|max:5',
            'fecha_resena'  => 'required|date',
            'id_usuario'    => 'required|exists:usuario,id_usuario',
            'id_servicio'   => 'required|exists:servicio,id_servicio',
        ]);

        $resena = Resena::create($validated);

        return response()->json($resena, 201);
    }

    /**
     * Mostrar una reseña por ID (GET /api/resenas/{id})
     */
    public function show(string $id)
    {
        $resena = Resena::findOrFail($id);
        return response()->json($resena);
    }

    /**
     * Actualizar una reseña (PUT/PATCH /api/resenas/{id})
     */
    public function update(Request $request, string $id)
    {
        $resena = Resena::findOrFail($id);

        $validated = $request->validate([
            'comentario'    => 'sometimes|required|string|max:500',
            'calificacion'  => 'sometimes|required|integer|min:1|max:5',
            'fecha_resena'  => 'sometimes|required|date',
            'id_usuario'    => 'sometimes|required|exists:usuario,id_usuario',
            'id_servicio'   => 'sometimes|required|exists:servicio,id_servicio',
        ]);

        $resena->update($validated);

        return response()->json($resena);
    }

    /**
     * Eliminar una reseña (DELETE /api/resenas/{id})
     */
    public function destroy(string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return response()->json(['message' => 'Reseña eliminada correctamente']);
    }

    public function porSalon($id)
    {
        return \App\Models\Resena::whereHas('servicio', function ($query) use ($id) {
            $query->where('id_salon', $id);
        })->get();
    }
}
