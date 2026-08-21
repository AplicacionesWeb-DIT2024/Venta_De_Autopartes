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
        // Normalizar el rol para evitar problemas de mayúsculas/minúsculas y espacios
        $request->merge([
            'role' => ucfirst(strtolower(trim($request->role)))
        ]);

        // Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    $dominiosPermitidos = [
                        'gmail.com',
                        'outlook.com',
                        'hotmail.com',
                        'yahoo.com',
                        'yahoo.com.ar',
                        'icloud.com',
                        'proton.me',
                        'protonmail.com',
                        'tuta.com',
                        'zoho.com',
                        'aol.com',
                        'live.com',
                        'gmx.com',
                        'gmx.de',
                        'mail.ru',
                        'yandex.ru'
                    ];
                    $dominio = strtolower(explode('@', $value)[1] ?? '');
                    if (!in_array($dominio, $dominiosPermitidos)) {
                        $fail('El correo debe ser de un proveedor de email válido (Gmail, Outlook, Yahoo, etc.).');
                    }
                }
            ],
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Cliente,Empleado',
        ], [
            'email.unique' => 'El correo electrónico ya está registrado.'
        ]);

        // Asignar el rol al usuario primero (antes de crear)
        $role = Role::where('name', $validated['role'])
            ->where('guard_name', 'web')
            ->first();

        if (!$role) {
            return response()->json([
                'message' => 'Rol no encontrado.'
            ], 500);
        }

        // Crear el usuario con el rol en la columna role
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'], // Asignar el rol a la columna role también
        ]);

        // Asignar el rol del sistema de Spatie al usuario
        $user->assignRole($role);

        $user->refresh(); // Refrescar el modelo para asegurarse de que los roles se carguen correctamente

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Obtener el nombre del rol asignado
            ],
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => 'Usuario registrado exitosamente.'
        ], 201);
    }
}
