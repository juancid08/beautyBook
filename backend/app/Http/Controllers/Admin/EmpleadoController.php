<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Salon;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with('salon')->get();
        return view('admin.empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salones = Salon::pluck('nombre', 'id_salon');
        return view('admin.empleados.form', compact('salones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'     => 'required|string|max:255',
            'apellidos'  => 'required|string|max:255',
            'telefono'   => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
            'id_salon'   => 'required|exists:salones,id_salon',
        ]);

        Empleado::create($data);

        return redirect()
            ->route('admin.empleados.index')
            ->with('success', 'Empleado creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        return view('admin.empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        $salones = Salon::pluck('nombre', 'id_salon');
        return view('admin.empleados.form', compact('empleado', 'salones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $data = $request->validate([
            'nombre'     => 'required|string|max:255',
            'apellidos'  => 'required|string|max:255',
            'telefono'   => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
            'id_salon'   => 'required|exists:salones,id_salon',
        ]);

        $empleado->update($data);

        return redirect()
            ->route('admin.empleados.index')
            ->with('success', 'Empleado actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return back()->with('success', 'Empleado eliminado correctamente');
    }
}
