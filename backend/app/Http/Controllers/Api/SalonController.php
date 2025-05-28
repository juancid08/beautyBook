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
    public function index(Request $request)
    {
        $especializacion = $request->query('especializacion');
        $nombre = $request->query('nombre');

        $query = Salon::query();

        if ($especializacion) {
            $query->where('especializacion', $especializacion);
        }

        if ($nombre) {
            $query->where('nombre', 'LIKE', '%' . $nombre . '%');
        }

        $salones = $query->get();

        $salones->transform(function($salon) {
            if ($salon->foto) {
                $salon->foto = asset('storage/' . $salon->foto);
            } else {
                $salon->foto = null;
            }
            return $salon;
        });

        return response()->json($salones);
    }
    /**
     * Obtener sugerencias de nombres de salones por búsqueda parcial
     * GET /api/salones/sugerencias?nombre=texto
     */
    public function sugerencias(Request $request)
    {
        $nombre = $request->query('nombre', '');

        if (empty($nombre)) {
            return response()->json([], 200);
        }

        // Solo traemos los primeros 5 nombres que empiezan por $nombre
        $sugerencias = Salon::where('nombre', 'like', $nombre.'%')
                            ->limit(5)
                            ->pluck('nombre');

        return response()->json($sugerencias, 200);
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
            'especializacion'   => 'required|in:Peluquería,Barbería,Salón de uñas,Depilación,Cejas y pestañas',
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
        if ($salon->foto) {
            $salon->foto = asset('storage/' . $salon->foto);
        } else {
            $salon->foto = null;
        }
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
            'especializacion'   => 'required|in:Peluquería,Barbería,Salón de uñas,Depilación,Cejas y pestañas',
            'id_cadena_salon'   => 'sometimes|required|exists:cadena_salon,id_cadena_salon',
        ]);

        $salon->update($validated);

        if ($salon->foto) {
            $salon->foto = asset('storage/' . $salon->foto);
        } else {
            $salon->foto = null;
        }

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
