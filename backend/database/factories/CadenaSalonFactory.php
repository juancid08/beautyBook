<?php

namespace Database\Factories;

use App\Models\CadenaSalon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CadenaSalonFactory extends Factory
{
    protected $model = CadenaSalon::class;

    public function definition()
    {
        return [
            'nombre'            => $this->faker->company(),
            'direccion_central' => $this->faker->address(),
            'telefono'          => $this->faker->phoneNumber(),
            'correo_contacto'   => $this->faker->unique()->safeEmail(),
            'website'           => $this->faker->url(),
            'descripcion'       => $this->faker->paragraph(),
        ];
    }
}
