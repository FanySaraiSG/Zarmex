<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantenimientoImagen extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento_imagenes';

    protected $fillable = [
        'posicion',
        'ruta_imagen',
        'lado',
        'tamano',
        'orden',
        'activo'
    ];
}