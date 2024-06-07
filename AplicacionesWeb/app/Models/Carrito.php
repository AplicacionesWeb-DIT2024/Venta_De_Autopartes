<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = ['autopart_id', 'cantidad'];

    public function autopart()
    {
        return $this->belongsTo(Autopart::class);
    }
}