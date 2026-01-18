<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar el seeder de roles y permisos
        $this->call(RolePermissionSeeder::class);

        // Crear usuario Admin de prueba
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // contraseña: password
        ]);
        $admin->assignRole('admin');

        // Crear usuario Empleado de prueba
        $empleado = User::factory()->create([
            'name' => 'Empleado User',
            'email' => 'empleado@example.com',
            'password' => bcrypt('password'), // contraseña: password
        ]);
        $empleado->assignRole('empleado');
    }
}
