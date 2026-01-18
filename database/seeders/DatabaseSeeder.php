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
            'username' => 'admin', // Cambiado: de 'email' a 'username'
            'password' => bcrypt('password'),
            'role' => 'admin', // Asegúrate de asignar el rol también en la columna si es necesario
        ]);
        $admin->assignRole('admin');

        // Crear usuario Empleado de prueba
        $empleado = User::factory()->create([
            'name' => 'Empleado User',
            'username' => 'empleado', // Cambiado: de 'email' a 'username'
            'password' => bcrypt('password'),
            'role' => 'empleado',
        ]);
        $empleado->assignRole('empleado');
    }
}
