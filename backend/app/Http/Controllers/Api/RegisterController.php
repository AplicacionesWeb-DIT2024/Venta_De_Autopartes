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
            'role' => 'required|string|in:Cliente',
        ], [
            'email.unique' => 'El correo electrónico ya está registrado.'
        ]);

        // El registro público solo puede crear clientes
        $role = Role::where('name', 'Cliente')->where('guard_name', 'web')->first();
        if (!$role) {
            return response()->json([
                'message' => 'Rol no encontrado.'
            ], 500);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'Cliente',
        ]);

        $user->assignRole($role); // Asignar el rol al usuario
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
