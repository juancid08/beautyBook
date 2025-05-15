<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Listar todos los empleados (GET /api/empleados)
     */
    public function index()
    {
        return response()->json(Empleado::all());
    }

    /**
     * Crear un nuevo empleado (POST /api/empleados)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:255',
            'telefono'  => 'required|string|max:20',
            'id_salon'  => 'required|exists:salon,id_salon',
        ]);

        $empleado = Empleado::create($validated);

        return response()->json($empleado, 201);
    }

    /**
     * Mostrar un empleado específico (GET /api/empleados/{id})
     */
    public function show(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }

    /**
     * Actualizar un empleado (PUT/PATCH /api/empleados/{id})
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre'    => 'sometimes|required|string|max:255',
            'telefono'  => 'sometimes|required|string|max:20',
            'id_salon'  => 'sometimes|required|exists:salon,id_salon',
        ]);

        $empleado->update($validated);

        return response()->json($empleado);
    }

    /**
     * Eliminar un empleado (DELETE /api/empleados/{id})
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado correctamente']);
    }

    /**
     * Obtener todos los empleados de un salón (GET /api/salones/{id}/empleados)
     */
    public function porSalon(string $id_salon)
    {
        $empleados = Empleado::where('id_salon', $id_salon)->get();
        return response()->json($empleados);
    }
}
