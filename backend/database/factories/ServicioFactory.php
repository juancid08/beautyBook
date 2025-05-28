<?php

namespace Database\Factories;

use App\Models\Servicio;
use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    protected $model = Servicio::class;

    public function definition()
    {
        return [
            'nombre'      => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'precio'      => $this->faker->randomFloat(2, 10, 200),
            'duracion'    => $this->faker->numberBetween(15, 120),
        ];
    }
}
