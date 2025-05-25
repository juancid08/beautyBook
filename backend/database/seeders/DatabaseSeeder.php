<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Salon;
use App\Models\Empleado;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Resena;
use App\Models\Pago;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        
        $this->call(SalonSeeder::class);

        Usuario::factory(10)->create();

        Salon::factory(15)->create();

        Empleado::factory(30)->create();

        Servicio::factory(30)->create();

        Cita::factory(50)->create();

        Resena::factory(50)->create();

        Pago::factory(50)->create();


    }
}
