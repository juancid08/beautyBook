<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pago;
use App\Models\Cita;

class PagoSeeder extends Seeder
{
    public function run()
    {
        $citas = Cita::inRandomOrder()->take(50)->get();

        foreach ($citas as $cita) {
            Pago::factory()->create([
                'id_cita' => $cita->id_cita,
            ]);
        }
    }
}
