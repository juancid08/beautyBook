<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    public function definition()
    {
        return [
            'nombre'      => $this->faker->name(),
            'telefono'    => $this->faker->phoneNumber(),
        ];
    }
}

