// app/Http/Middleware/RoleKeyMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $key = $request->input('key');
        $user = Auth::user();

        if ($key === 'cliente' && $user->hasRole('Cliente')) {
            return $next($request);
        } elseif ($key === 'empleado' && $user->hasRole('Empleado')) {
            return $next($request);
        }

        return redirect('/login')->withErrors(['message' => 'Clave de acceso incorrecta o falta de permisos.']);
    }
}