<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Método para verificar si el usuario tiene un rol específico
    public function hasRole($role)
    {
        return $this->role === $role; // Verifica si el rol del usuario coincide con el rol especificado
    }

    // Otros métodos y relaciones del modelo...
}

