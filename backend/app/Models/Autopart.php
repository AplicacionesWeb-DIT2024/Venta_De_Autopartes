<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Autopart extends Model
{
    use HasFactory;

    protected $table = "autoparts";

    protected $casts = [
        'foto' => 'array',
    ];

    protected $appends = ['fotos_urls'];

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

    protected function getFotosUrlsAttribute()
    {
        $fotos = $this->foto;

        if (empty($fotos)) {
            return [];
        }

        if (!is_array($fotos)) {
            $fotos = [$fotos];
        }

        return array_map(fn($f) => Storage::disk('public')->url($f), $fotos);
    }

    public function carrito()
    {
        return $this->hasMany(Carrito::class);
    }
}
