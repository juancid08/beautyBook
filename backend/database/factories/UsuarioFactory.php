<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UsuarioFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'       => $this->faker->name(),
            'apellidos'    => $this->faker->lastName(),
            'email'        => $this->faker->unique()->safeEmail(),
            'password'     => Hash::make('password'), 
            'telefono'     => $this->faker->phoneNumber(),
            'rol'          => $this->faker->randomElement(['cliente', 'administrador']),
            'foto_perfil'  => $this->faker->imageUrl(200, 200, 'people', true, 'perfil'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
