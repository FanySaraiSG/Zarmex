<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'largo', 'ancho', 'altura'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}

