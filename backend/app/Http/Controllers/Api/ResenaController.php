<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resena;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        // Si no, devolvemos todas las reseñas
        return Resena::all();
    }

    /**
     * Crear una nueva reseña (POST /api/resenas)
     * Validaciones adicionales:
     *   - El usuario debe haber tenido al menos una cita con estado distinto de 'pendiente'
     *     para el servicio indicado.
     */
    public function store(Request $request)
    {
        // 1) Validar campos básicos
        $validator = Validator::make($request->all(), [
            'comentario'    => 'required|string|max:500',
            'calificacion'  => 'required|integer|min:1|max:5',
            'fecha_resena'  => 'required|date',
            'id_usuario'    => 'required|exists:usuario,id_usuario',
            'id_servicio'   => 'required|exists:servicio,id_servicio',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos para crear la reseña.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $idUsuario  = $request->input('id_usuario');
        $idServicio = $request->input('id_servicio');

        // 2) Verificar que exista al menos una cita de ese usuario para ese servicio
        //    y que la cita no tenga estado "pendiente".
        $existeCita = Cita::where('id_usuario', $idUsuario)
            ->where('id_servicio', $idServicio)
            ->where(function ($query) {
                // Suponemos que cualquier estado distinto de 'pendiente' es válido
                $query->where('estado', '<>', 'pendiente');
            })
            ->exists();

        if (! $existeCita) {
            return response()->json([
                'message' => 'No puedes crear una reseña si no has asistido a ese servicio.'
            ], 403);
        }

        // 3) Todos los chequeos pasaron, crear la reseña
        $resena = Resena::create([
            'comentario'    => $request->input('comentario'),
            'calificacion'  => $request->input('calificacion'),
            'fecha_resena'  => $request->input('fecha_resena'),
            'id_usuario'    => $idUsuario,
            'id_servicio'   => $idServicio,
        ]);

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
     * 
     * Si se cambian id_usuario o id_servicio, se vuelve a verificar que aquella combo
     * usuario-servicio tenga al menos una cita confirmada/completada.
     */
    public function update(Request $request, string $id)
    {
        $resena = Resena::findOrFail($id);

        // 1) Validar campos editables
        $validator = Validator::make($request->all(), [
            'comentario'    => 'sometimes|required|string|max:500',
            'calificacion'  => 'sometimes|required|integer|min:1|max:5',
            'fecha_resena'  => 'sometimes|required|date',
            'id_usuario'    => 'sometimes|required|exists:usuario,id_usuario',
            'id_servicio'   => 'sometimes|required|exists:servicio,id_servicio',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos para actualizar la reseña.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // 2) Si cambiaron id_usuario o id_servicio, volver a validar la cita
        $nuevoUsuario  = $request->has('id_usuario')  ? $request->input('id_usuario')  : $resena->id_usuario;
        $nuevoServicio = $request->has('id_servicio') ? $request->input('id_servicio') : $resena->id_servicio;

        if (
            $nuevoUsuario  != $resena->id_usuario ||
            $nuevoServicio != $resena->id_servicio
        ) {
            $existeCita = Cita::where('id_usuario', $nuevoUsuario)
                ->where('id_servicio', $nuevoServicio)
                ->where(function ($query) {
                    $query->where('estado', '<>', 'pendiente');
                })
                ->exists();

            if (! $existeCita) {
                return response()->json([
                    'message' => 'No puedes asociar la reseña a ese usuario/servicio porque no hay cita válida.'
                ], 403);
            }
        }

        // 3) Actualizar campos permitidos
        if ($request->has('comentario')) {
            $resena->comentario = $request->input('comentario');
        }
        if ($request->has('calificacion')) {
            $resena->calificacion = $request->input('calificacion');
        }
        if ($request->has('fecha_resena')) {
            $resena->fecha_resena = $request->input('fecha_resena');
        }
        if ($request->has('id_usuario')) {
            $resena->id_usuario = $nuevoUsuario;
        }
        if ($request->has('id_servicio')) {
            $resena->id_servicio = $nuevoServicio;
        }

        $resena->save();

        return response()->json($resena);
    }

    /**
     * Eliminar una reseña (DELETE /api/resenas/{id})
     */
    public function destroy(string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return response()->json(['message' => 'Reseña eliminada correctamente.']);
    }

    /**
     * Obtener reseñas por salón (GET /api/salones/{id}/resenas)
     * Asume que la relación Resena -> Servicio existe y Servicio tiene un campo id_salon.
     */
    public function porSalon($id)
    {
        return Resena::whereHas('servicio', function ($query) use ($id) {
            $query->where('id_salon', $id);
        })->get();
    }

    /**
     * Obtener reseñas por servicio (GET /api/servicios/{id}/resenas)
     */
    public function porServicio($idServicio)
    {
        return Resena::where('id_servicio', $idServicio)->get();
    }
}
