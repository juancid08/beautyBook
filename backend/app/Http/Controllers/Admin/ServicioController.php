<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Salon;

class ServicioController extends Controller
{
    /**
     * Muestra el listado de servicios en la vista HTML.
     */
    public function index()
    {
        // Trae todos los servicios (puedes hacer eager‐loading si quieres: ->with('salon'))
        $servicios = Servicio::all();

        // Devuelve la vista index.blade.php pasándole la colección
        return view('admin.servicios.index', compact('servicios'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        // Para el <select> necesito la lista de salones: [id_salon => nombre]
        $salones = Salon::pluck('nombre', 'id_salon');

        return view('admin.servicios.create', compact('salones'));
    }

    /**
     * Almacena un nuevo servicio.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'id_salon'    => 'required|exists:salon,id_salon',
        ]);

        Servicio::create($data);

        return redirect()
            ->route('admin.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Servicio $servicio)
    {
        $salones = Salon::pluck('nombre', 'id_salon');

        return view('admin.servicios.edit', compact('servicio', 'salones'));
    }

    /**
     * Actualiza un servicio existente.
     */
    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'id_salon'    => 'required|exists:salon,id_salon',
        ]);

        $servicio->update($data);

        return redirect()
            ->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Elimina un servicio.
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return back()->with('success', 'Servicio eliminado correctamente.');
    }
}
