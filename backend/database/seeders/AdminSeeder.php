<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'), // Cambia esto por una contraseña segura
            'role' => 'Empleado', // Asignar directamente el rol al usuario
        ]);
    }
}