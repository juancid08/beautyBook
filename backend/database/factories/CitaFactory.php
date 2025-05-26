<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Usuario;
use App\Models\Empleado;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitaFactory extends Factory
{
    protected $model = Cita::class;

    public function definition()
    {
        return [
            'fecha'        => $this->faker->date(),
            'hora'         => $this->faker->time('H:i'),
            'estado'       => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
        ];
    }
}
