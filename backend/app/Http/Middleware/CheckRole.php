<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if(!$user) {
            return $this->denyAccess($request);
        }

        foreach ($roles as $role) {
            $rolAuth = ucfirst(strtolower($role));

            if ($user->hasRole($rolAuth) || $user->role === $rolAuth) {
                return $next($request);
            }
        }

        return $this->denyAccess($request);

    }

    private function denyAccess(Request $request)
    {
        if ($request->expectsJson()){
            return response()->json([
                'message' => 'No tienes permisos para realizar esta acción.'
            ], 403);
        }

        return redirect('/')->with('error', 'No tienes acceso a esta sección.');
    }
}
