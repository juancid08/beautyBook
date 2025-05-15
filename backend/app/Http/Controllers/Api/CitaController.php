<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Listar todas las citas (GET /api/citas)
     */
    public function index()
    {
        return response()->json(Cita::all());
    }

    /**
     * Crear una nueva cita (POST /api/citas)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha'        => 'required|date',
            'hora'         => 'required|string|max:10',
            'estado'       => 'required|string|max:50',
            'id_usuario'   => 'required|exists:usuario,id_usuario',
            'id_servicio'  => 'required|exists:servicio,id_servicio',
            'id_empleado'  => 'required|exists:empleado,id_empleado',
        ]);

        $cita = Cita::create($validated);

        return response()->json($cita, 201);
    }

    /**
     * Mostrar una cita específica (GET /api/citas/{id})
     */
    public function show(string $id)
    {
        $cita = Cita::findOrFail($id);
        return response()->json($cita);
    }

    /**
     * Actualizar una cita (PUT/PATCH /api/citas/{id})
     */
    public function update(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        $validated = $request->validate([
            'fecha'        => 'sometimes|required|date',
            'hora'         => 'sometimes|required|string|max:10',
            'estado'       => 'sometimes|required|string|max:50',
            'id_usuario'   => 'sometimes|required|exists:usuario,id_usuario',
            'id_servicio'  => 'sometimes|required|exists:servicio,id_servicio',
            'id_empleado'  => 'sometimes|required|exists:empleado,id_empleado',
        ]);

        $cita->update($validated);

        return response()->json($cita);
    }

    /**
     * Eliminar una cita (DELETE /api/citas/{id})
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json(['message' => 'Cita eliminada correctamente']);
    }

    /**
     * Obtener todas las citas de un usuario (GET /api/usuarios/{id}/citas)
     */
    public function porUsuario(string $id_usuario)
    {
        $citas = Cita::where('id_usuario', $id_usuario)->get();
        return response()->json($citas);
    }
}
