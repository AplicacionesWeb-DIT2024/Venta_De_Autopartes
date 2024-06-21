<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'numero_pedido',
        'fecha_cierre',
        'costo_total',
        'tipo_pago',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pedido) {
            // Asignar el próximo número de pedido secuencial
            $lastOrder = Pedido::orderBy('numero_pedido', 'desc')->first();
            $pedido->numero_pedido = $lastOrder ? $lastOrder->numero_pedido + 1 : 1;
        });
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}