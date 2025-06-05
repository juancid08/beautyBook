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
        $empleados = Empleado::all()->map(function($emp) {
            // Si tiene campo 'foto' (p.ej. "empleados/1749..."), convertirlo en URL pública
            if ($emp->foto) {
                $emp->foto = asset('storage/' . $emp->foto);
            }
            return $emp;
        });
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
            // Aceptar archivo de foto si se envía:
            'foto'      => 'sometimes|file|image|max:2048',
        ]);
        
        // Si envían nueva foto, la guardamos en public/storage/empleados
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Se guarda en storage/app/public/empleados/...
            $file->move(public_path('storage/empleados'), $filename);
            // Guardamos en la BD la ruta relativa "empleados/xxxxx"
            $validated['foto'] = 'empleados/' . $filename;
        }

        $empleado->update($validated);

        // Finalmente, devolvemos el objeto con 'foto' como URL completa:
        if ($empleado->foto) {
            $empleado->foto = asset('storage/' . $empleado->foto);
        }

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
        $empleados = Empleado::where('id_salon', $id_salon)->get()
        ->map(function($emp) {
            if ($emp->foto) {
                $emp->foto = asset('storage/' . $emp->foto);
            }
            return $emp;
        });
        return response()->json($empleados);
    }
}
