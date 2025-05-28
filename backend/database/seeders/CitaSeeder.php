<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cita;
use App\Models\Usuario;
use App\Models\Empleado;
use App\Models\Servicio;

class CitaSeeder extends Seeder
{
    public function run()
    {
        $usuarios  = Usuario::all();
        $empleados = Empleado::all();
        $servicios = Servicio::all();

        for ($i = 0; $i < 50; $i++) {
            Cita::factory()->create([
                'id_usuario'  => $usuarios->random()->id_usuario,
                'id_empleado' => $empleados->random()->id_empleado,
                'id_servicio' => $servicios->random()->id_servicio,
            ]);
        }
    }
}
