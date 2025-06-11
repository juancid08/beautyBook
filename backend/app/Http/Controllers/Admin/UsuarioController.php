<?php
// app/Http/Controllers/Admin/UsuarioController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.form');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'nombre'     => 'required|string|max:255',
            'apellidos'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:usuario,email',
            'telefono'   => 'nullable|string|max:20',
            'rol'        => 'required|in:cliente,administrador',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        Usuario::create($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.form', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre'     => 'required|string|max:255',
            'apellidos'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:usuario,email,' . $usuario->id_usuario . ',id_usuario',
            'telefono'   => 'nullable|string|max:20',
            'rol'        => 'required|in:cliente,administrador',
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }
    

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return back()->with('success','Usuario eliminado');
    }
}

