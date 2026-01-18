<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crea permisos no existente
        Permission::firstOrCreate(['name' => 'generar facturas', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'editar datos', 'guard_name' => 'web']);

        // Crear roles solo si no existen
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $empleado = Role::firstOrCreate(['name' => 'empleado', 'guard_name' => 'web']);

        // Asigna permisos
        $admin->givePermissionTo(Permission::all());
        $empleado->givePermissionTo('generar facturas');
    }
}
