<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions(); // Limpia la caché de permisos para evitar problemas con roles y permisos antiguos
        
        $roles = ['Cliente', 'Empleado'];

        foreach ($roles as $role) {

            // Crea el rol si no existe
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web' // Especifica el guard para el rol, generalmente 'web' para aplicaciones web
            ]);

        }
    }
}
