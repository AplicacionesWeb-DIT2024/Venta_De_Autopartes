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

        return array_map(function ($f) {
            if (!$f) {
                return null;
            }

            // Si ya viene con la URL completa, no la modificamos
            if (filter_var($f, FILTER_VALIDATE_URL)) {
                return $f;
            }

            // Limpiamos posibles prefijos
            $f = ltrim(str_replace(['storage/', 'public/'], '', $f), '/');

            // Usamos asset() para que tome APP_URL
            return asset('storage/' . $f);
        }, $fotos);
    }

    public function carrito()
    {
        return $this->hasMany(Carrito::class);
    }
}
