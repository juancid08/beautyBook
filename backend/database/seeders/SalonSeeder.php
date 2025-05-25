<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salon;

class SalonSeeder extends Seeder
{
    public function run()
    {
        $salones = [
            [
                'nombre' => 'BeautySalon A',
                'direccion' => 'Calle Mayor 1',
                'foto' => 'salon1.webp',
                'rating' => 4.5,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'Barbería B',
                'direccion' => 'Calle Luna 23',
                'foto' => 'salon2.webp',
                'rating' => 4.0,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'Nails & Spa',
                'direccion' => 'Calle Sol 45',
                'foto' => 'salon3.webp',
                'rating' => 5.0,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'Moreno Stilistas',
                'direccion' => 'Calle Mercurio 9',
                'foto' => 'salon4.webp',
                'rating' => 5.0,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'Rose Skin Barbershop',
                'direccion' => 'Calle Sondalezas 37',
                'foto' => 'salon5.webp',
                'rating' => 4.65,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'Rasec Barbershop',
                'direccion' => 'Calle Montería 20',
                'foto' => 'salon6.webp',
                'rating' => 4.9,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'No Limits Hair Studio',
                'direccion' => 'Calle Vicavaro 37',
                'foto' => 'salon7.webp',
                'rating' => 4.8,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
            [
                'nombre' => 'Jonhy García BarberS',
                'direccion' => 'Calle Virgen de la montaña 37',
                'foto' => 'salon8.webp',
                'rating' => 4.2,
                'telefono' => '123456789',
                'horario_apertura' => '09:00', 
                'horario_cierre' => '18:00', 
                'descripcion' => 'Un salón con servicios de belleza y barbería de alta calidad.',
            ],
        ];

        foreach ($salones as $salon) {
            Salon::create($salon);
        }
    }
}
