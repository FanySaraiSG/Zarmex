<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        // agrega aquí los campos de tu tabla promotions
        // ejemplo: 'titulo', 'descripcion', 'imagen', 'activo'
    ];
}