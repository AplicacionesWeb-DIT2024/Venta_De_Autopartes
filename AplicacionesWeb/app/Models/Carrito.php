<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = ['autopart_id', 'user_id', 'quantity'];

    public function autoparte()
    {
        return $this->belongsTo(Autopart::class, 'autopart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
