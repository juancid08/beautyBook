<?php

namespace Database\Factories;

use App\Models\Resena;
use App\Models\Usuario;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResenaFactory extends Factory
{
    protected $model = Resena::class;

    public function definition()
    {
        return [
            'comentario'    => $this->faker->sentence(),
            'calificacion'  => $this->faker->numberBetween(1, 5),
            'fecha_resena'  => $this->faker->date(),
            'id_usuario'    => Usuario::factory(),
            'id_servicio'   => Servicio::factory(),
        ];
    }
}