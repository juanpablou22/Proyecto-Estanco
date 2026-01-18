<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name' => fake()->name(),
            // Cambiado de 'email' a 'username' para coincidir con tu migración
            'username' => fake()->unique()->userName(),
            // 'email_verified_at' ha sido eliminado porque la columna ya no existe
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            // Opcional: puedes definir un rol por defecto aquí si lo deseas
            'role' => 'empleado',
        ];
    }

    /**
     * Ya no es necesario el método unverified() ya que no existe la columna email_verified_at.
     * Si decides mantenerlo por estructura, debería estar vacío o comentarizado.
     */
}
