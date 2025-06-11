<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  
use App\Models\Usuario;
use App\Models\Salon;
use App\Models\Servicio;
use App\Models\Empleado;
use App\Models\Cita;
use App\Models\Resena;


use App\Http\Middleware\IsAdmin;

class DashboardController extends Controller     
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.dashboard', [
            'usuarios'  => Usuario::all(),
            'salones'   => Salon::all(),
            'servicios' => Servicio::all(),
            'empleados' => Empleado::all(),
            'citas'     => Cita::all(),
            'resenas'   => Resena::all(),
        ]);
    
    }

    public function create()
    {
        return view('admin.usuarios.form');
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.form', compact('usuario'));
    }
}
