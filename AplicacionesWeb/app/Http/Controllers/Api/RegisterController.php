<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Asignar el rol de "cliente" al nuevo usuario
        $role = Role::firstOrCreate(['name' => 'cliente']);
        $user->assignRole($role);

        // Asignar el rol de "Empleado" al nuevo usuario
        $roleEmpleado = Role::firstOrCreate(['name' => 'Empleado']);
        $user->assignRole($roleEmpleado);

        return response()->json(['message' => 'Usuario registrado con éxito'], 201);
    }
}