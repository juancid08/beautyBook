<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resena;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargamos reseñas junto con su servicio y usuario para mostrar detalles
        $resenas = Resena::with(['servicio', 'usuario'])->get();
        return view('admin.resenas.index', compact('resenas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Listados para selects
        $servicios = Servicio::pluck('nombre', 'id_servicio');
        $usuarios  = Usuario::pluck('nombre', 'id_usuario');
        return view('admin.resenas.form', compact('servicios', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'comentario'   => 'nullable|string',
            'calificacion'   => 'required|integer|min:1|max:5',
            'id_servicio'  => 'required|exists:servicios,id_servicio',
            'id_usuario'   => 'required|exists:usuario,id_usuario',
        ]);

        Resena::create($data);

        return redirect()
            ->route('admin.resenas.index')
            ->with('success', 'Reseña creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resena $resena)
    {
        return view('admin.resenas.show', compact('resena'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resena $resena)
    {
        $servicios = Servicio::pluck('nombre', 'id_servicio');
        $usuarios  = Usuario::pluck('nombre', 'id_usuario');
        return view('admin.resenas.form', compact('resena', 'servicios', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resena $resena)
    {
        $data = $request->validate([
            'comentario'   => 'nullable|string',
            'calificacion'   => 'required|integer|min:1|max:5',
            'id_servicio'  => 'required|exists:servicios,id_servicio',
            'id_usuario'   => 'required|exists:usuario,id_usuario',
        ]);

        $resena->update($data);

        return redirect()
            ->route('admin.resenas.index')
            ->with('success', 'Reseña actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resena $resena)
    {
        $resena->delete();

        return back()->with('success', 'Reseña eliminada correctamente');
    }
}
