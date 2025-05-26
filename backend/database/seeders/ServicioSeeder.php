<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;
use App\Models\Salon;

class ServicioSeeder extends Seeder
{
    public function run()
    {
        $salones = Salon::all();

        foreach ($salones as $salon) {
            Servicio::factory(3)->create([
                'id_salon' => $salon->id_salon,
            ]);
        }
    }
}
