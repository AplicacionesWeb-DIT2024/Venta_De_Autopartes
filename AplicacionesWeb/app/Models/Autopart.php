<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autopart extends Model
{
    use HasFactory;

    protected $table = 'autopart';

    protected $fillable = [
        'autoparte',
        'marca',
        'modelo',
        'añoVehiculo',
        'codigo',
        'estado',
        'precio',
        'color',
    ];
}