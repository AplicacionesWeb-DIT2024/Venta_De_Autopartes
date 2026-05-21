<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

// Instrucción para limpiar y crear la BD desde 0: php artisan migrate:fresh --seed
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'Empleado',
            'guard_name' => 'web'
        ]);

        Role::firstOrCreate([
            'name' => 'Cliente',
            'guard_name' => 'web' // Especifica el guard para el rol, generalmente 'web' para aplicaciones web
        ]);

    }
}
