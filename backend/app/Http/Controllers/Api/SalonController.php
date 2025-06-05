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
            'id_usuario'        => 'required|exists:usuario,id_usuario',
        ]);

        // Si existe foto y es base64, procesamos para guardarla en disco
        if (!empty($validated['foto']) && str_starts_with($validated['foto'], 'data:image')) {
            // Extraer la parte base64 (después de la coma)
            $base64str = explode(',', $validated['foto'])[1] ?? null;
            if ($base64str) {
                $imageData = base64_decode($base64str);

                // Generar nombre único para la imagen
                $filename = uniqid('salon_') . '.webp'; // o png, jpg según la imagen

                // Guardar imagen en disco public/storage/salones
                \Storage::disk('public')->put('salones/' . $filename, $imageData);

                // Reemplazar el campo foto con la ruta relativa
                $validated['foto'] = 'salones/' . $filename;
            } else {
                // Si no se pudo extraer base64, eliminar el campo para evitar guardar mal
                unset($validated['foto']);
            }
        } else {
            // No hay imagen o no es base64, eliminar para evitar guardar texto inútil
            unset($validated['foto']);
        }

        $salon = Salon::create($validated);

        // Para la respuesta puedes añadir la URL completa de la foto si quieres
        if ($salon->foto) {
            $salon->foto = asset('storage/' . $salon->foto);
        }

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
            'nombre'          => 'sometimes|required|string|max:255',
            'direccion'       => 'sometimes|required|string|max:255',
            'telefono'        => 'sometimes|required|string|max:20',
            'horario_apertura'=> 'nullable|string|max:10',
            'horario_cierre'  => 'nullable|string|max:10',
            'descripcion'     => 'nullable|string|max:500',
            'especializacion' => 'required|in:Peluquería,Barbería,Salón de uñas,Depilación,Cejas y pestañas',
            'id_usuario'      => 'required|exists:usuario,id_usuario',
        ]);

        // Procesar imagen si viene como archivo (solo si la petición es POST/multipart)
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/salones'), $filename);
            $validated['foto'] = 'salones/' . $filename;
        }

        $salon->update($validated);

        if ($salon->foto) {
            $salon->foto = asset('storage/' . $salon->foto);
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

    public function porUsuario($id)
    {
        return Salon::where('id_usuario', $id)->get();
    }
}
