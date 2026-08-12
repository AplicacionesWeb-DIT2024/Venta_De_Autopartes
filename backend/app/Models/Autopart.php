<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autopart extends Model
{
    use HasFactory;
    protected $table = "autoparts";
    protected $fillable = [
        'autoparte',
        'marca',
        'modelo',
        'anioVehiculo',
        'codigo',
        'estado',
        'precio',
        'color',
        'stock',
        'foto'
    ];

    public function carrito()
    {
        return $this->hasMany(Carrito::class);
    }
}
