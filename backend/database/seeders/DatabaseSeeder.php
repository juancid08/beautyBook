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
        $this->call([SalonSeeder::class]);

        $this->call([
            UsuarioSeeder::class,   // Luego: usuarios
            EmpleadoSeeder::class,  // Después: empleados asignados a salones
            ServicioSeeder::class,  // Luego: servicios asignados a salones
            CitaSeeder::class,      // Luego: citas usando usuarios, empleados y servicios
            ResenaSeeder::class,    // Después: reseñas de usuarios sobre servicios
            PagoSeeder::class,      // Finalmente: pagos asociados a citas
        ]);

    }
}
