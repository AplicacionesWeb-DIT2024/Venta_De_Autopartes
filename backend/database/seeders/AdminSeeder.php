<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('12345678'),
                'role' => 'Empleado',
            ]
        );

        // Asegurar que el rol existe y asignarlo en Spatie
        Role::firstOrCreate(['name' => 'Empleado', 'guard_name' => 'web']);

        if (!$user->hasRole('Empleado')) {
            $user->assignRole('Empleado');
        }
    }
}