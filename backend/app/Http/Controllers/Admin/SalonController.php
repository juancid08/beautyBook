<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salon;

class SalonController extends Controller
{
    public function index()
    {
        $salones = Salon::all();
        return view('admin.salones.index', compact('salones'));
    }

    public function create()
    {
        $usuarios = \App\Models\Usuario::pluck('nombre', 'id_usuario');
        return view('admin.salones.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:255',
            'direccion'         => 'required|string|max:500',
            'telefono'          => 'nullable|string|max:20',
            'horario_apertura'  => 'required|date_format:H:i',
            'horario_cierre'    => 'required|date_format:H:i|after:horario_apertura',
            'descripcion'       => 'nullable|string',
            'especializacion'   => 'nullable|string|max:255',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'id_usuario'        => 'required|exists:usuario,id_usuario',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('salones', 'public');
            $data['foto'] = basename($path);
        }

        Salon::create($data);

        return redirect()
            ->route('admin.salones.index')
            ->with('success', 'Salón creado correctamente');
    }

    public function edit(Salon $salon)
    {
        $usuarios = \App\Models\Usuario::pluck('nombre', 'id_usuario');
        return view('admin.salones.edit', compact('salon', 'usuarios'));
    }

    public function update(Request $request, Salon $salon)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:255',
            'direccion'         => 'required|string|max:500',
            'telefono'          => 'nullable|string|max:20',
            'horario_apertura'  => 'required|date_format:H:i',
            'horario_cierre'    => 'required|date_format:H:i|after:horario_apertura',
            'descripcion'       => 'nullable|string',
            'especializacion'   => 'nullable|string|max:255',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'id_usuario'        => 'required|exists:usuario,id_usuario',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('salones', 'public');
            $data['foto'] = basename($path);
        }

        $salon->update($data);

        return redirect()
            ->route('admin.salones.index')
            ->with('success', 'Salón actualizado correctamente');
    }

    public function destroy(Salon $salon)
    {
        $salon->delete();
        return back()->with('success', 'Salón eliminado correctamente');
    }
}
