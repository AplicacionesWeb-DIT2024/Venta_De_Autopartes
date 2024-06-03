<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'autoparte',
        'precio',
        'cantidad'
    ];

    public function autoparte()
    {
        return $this->belongsTo(Autopart::class, 'autoparte', 'autoparte');
    }
}