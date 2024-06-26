<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito';

    protected $fillable = [
        'autopart_id',
        'pedido_id',
        'quantity'
    ];

    public function autopart()
    {
        return $this->belongsTo(Autopart::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}