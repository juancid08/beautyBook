<?php
namespace Database\Factories;

use App\Models\Salon;
use App\Models\CadenaSalon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalonFactory extends Factory
{
    protected $model = Salon::class;

    public function definition()
    {
        return [
            'nombre'             => $this->faker->company(),
            'direccion'          => $this->faker->address(),
            'telefono'           => $this->faker->phoneNumber(),
            'horario_apertura'   => $this->faker->time('H:i'),
            'horario_cierre'     => $this->faker->time('H:i'),
            'descripcion'        => $this->faker->sentence(),
            'foto'               => $this->faker->imageUrl(640, 480, 'business'),
            'especializacion'    => $this->faker->randomElement([
                'Peluquería',
                'Barbería',
                'Salón de uñas',
                'Depilación',
                'Cejas y pestañas'
            ]),
        ];
    }
}