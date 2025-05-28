<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Salon;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        $salones = Salon::all();

        foreach ($salones as $salon) {
            Empleado::factory(2)->create([
                'id_salon' => $salon->id_salon,
            ]);
        }
    }
}
