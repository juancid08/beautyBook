<?php


namespace Database\Factories;

use App\Models\Pago;
use App\Models\Cita;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    protected $model = Pago::class;

    public function definition()
    {
        return [
            'monto'        => $this->faker->randomFloat(2, 20, 500),
            'metodo_pago'  => $this->faker->randomElement(['efectivo', 'tarjeta', 'transferencia']),
            'estado_pago'  => $this->faker->randomElement(['pendiente', 'pagado', 'fallido']),
            'id_cita'      => Cita::factory(),
        ];
    }
}