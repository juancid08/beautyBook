<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Usuario;
use App\Models\Servicio;
use App\Models\Empleado;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::with(['usuario', 'servicio', 'empleado'])->get();
        return view('admin.citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios  = Usuario::pluck('nombre', 'id_usuario');
        $servicios = Servicio::pluck('nombre', 'id_servicio');
        $empleados = Empleado::pluck('nombre', 'id_empleado');
        return view('admin.citas.form', compact('usuarios', 'servicios', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([  
            'fecha'       => 'required|date',
            'hora'        => 'required|date_format:H:i',
            'id_usuario'  => 'required|exists:usuario,id_usuario',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'id_empleado' => 'required|exists:empleados,id_empleado',
        ]);

        Cita::create($data);

        return redirect()
            ->route('admin.citas.index')
            ->with('success', 'Cita creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        return view('admin.citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        $usuarios  = Usuario::pluck('nombre', 'id_usuario');
        $servicios = Servicio::pluck('nombre', 'id_servicio');
        $empleados = Empleado::pluck('nombre', 'id_empleado');
        return view('admin.citas.form', compact('cita', 'usuarios', 'servicios', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $data = $request->validate([
            'fecha'       => 'required|date',
            'hora'        => 'required|date_format:H:i',
            'id_usuario'  => 'required|exists:usuario,id_usuario',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'id_empleado' => 'required|exists:empleados,id_empleado',
        ]);

        $cita->update($data);

        return redirect()
            ->route('admin.citas.index')
            ->with('success', 'Cita actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();

        return back()->with('success', 'Cita eliminada correctamente');
    }
}
