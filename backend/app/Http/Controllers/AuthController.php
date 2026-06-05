<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Cliente,Empleado',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Guardar el rol en la columna role de la tabla users
        ]);

        // Asegurar que el rol existe, si no, crearlo
        $role = Role::firstOrCreate(
            ['name' => $request->role, 'guard_name' => 'web'],
            ['name' => $request->role, 'guard_name' => 'web']
        );

        // Asignar el rol al usuario en la tabla model_has_roles
        $user->assignRole($role);

        Auth::login($user);

        // Generar token de autenticación
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retornar los datos del usuario con el rol asignado
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $request->role, // Retornar el rol que se acaba de asignar
            ],
            'token' => $token,
        ]);
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Obtener el primer rol del usuario
            ],
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}