<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // Otros campos necesarios
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los detalles del pedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id', 'id');
    }

    public function autopartes()
    {
        return $this->belongsToMany(Autopart::class);
    }
}