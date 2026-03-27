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

        // Asigna un rol al usuario
        $roleName = $request->input('role', 'cliente'); // Asigna 'cliente' por defecto si no se proporciona un rol
        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->assignRole($role);

        return response()->json([
            'user' => $user,
            'message' => 'Usuario registrado exitosamente',
        ], 201);
    }
}