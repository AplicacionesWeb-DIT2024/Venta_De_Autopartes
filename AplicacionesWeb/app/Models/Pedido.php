<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha_cierre',
        'costo_total',
        'tipo_pago'
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}