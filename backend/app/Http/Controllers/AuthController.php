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
        ]);

        // Asegurar que el rol existe, si no, crearlo
        $role = Role::firstOrCreate(
            ['name' => 'Cliente', 'guard_name' => 'web'],
            ['name' => 'Cliente', 'guard_name' => 'web']
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Cliente', //  Asignar el rol "Cliente" al usuario registrado
        ]);

        // Asignar el rol al usuario en la tabla model_has_roles
        $user->assignRole($role);
        Auth::login($user);

        return redirect()->route('autopartes.index');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Usuario o contraseña incorrecto'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first() ?? $user->role,
            ],
            'token' => $token,
        ]);
    }

    // Login del flujo web (Blade): inicia seesión y redirige según el rol
    public function webLogin(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Usuario o contraseña incorrectos'])->withInput();
        }
        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->getRoleNames()->first() ?? $user->role;

        return $role === 'Empleado'
            ? redirect()->route('empleado')
            : redirect()->route('cliente');

    }
    public function logoutApi(Request $request)
    {

        $token = $request->user()->currentAccessToken();

        if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
            $token->delete();
        }

        Auth::guard('web')->logout();

        return response()->json(['message' => 'Sesión cerrada correctamente']);

    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}