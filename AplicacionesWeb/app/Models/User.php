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

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}