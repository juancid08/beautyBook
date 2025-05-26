<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resena;
use App\Models\Usuario;
use App\Models\Servicio;

class ResenaSeeder extends Seeder
{
    public function run()
    {
        $usuarios  = Usuario::all();
        $servicios = Servicio::all();

        for ($i = 0; $i < 50; $i++) {
            Resena::factory()->create([
                'id_usuario'  => $usuarios->random()->id_usuario,
                'id_servicio' => $servicios->random()->id_servicio,
            ]);
        }
    }
}
