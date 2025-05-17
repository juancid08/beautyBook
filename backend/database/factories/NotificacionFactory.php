<?php

namespace Database\Factories;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacionFactory extends Factory
{
    protected $model = Notificacion::class;

    public function definition()
    {
        return [
            'mensaje'      => $this->faker->sentence(),
            'fecha_envio'  => $this->faker->date(),
            'tipo'         => $this->faker->randomElement(['info', 'recordatorio', 'alerta']),
            'estado'       => $this->faker->randomElement(['enviado', 'visto', 'pendiente']),
            'id_usuario'   => Usuario::factory(),
        ];
    }
}
