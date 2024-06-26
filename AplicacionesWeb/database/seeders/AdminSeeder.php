<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Cambia esto por una contraseña segura
        ]);

        $role = Role::where('name', 'Empleado')->first();
        $user->assignRole($role);
    }
}