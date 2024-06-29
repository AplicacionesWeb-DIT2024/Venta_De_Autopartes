<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';

    // Definición de la relación con Autopart
    public function autopart()
    {
        return $this->belongsTo(Autopart::class, 'autopart_id');
    }




    protected $fillable = [
        'autopart_id',
        'user_id',
        'quantity'
    ];

    public function autoparte()
    {
        return $this->belongsTo(Autopart::class, 'autopart_id');
    }

    // En el modelo Carrito.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}