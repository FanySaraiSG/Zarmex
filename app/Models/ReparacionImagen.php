<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReparacionImagen extends Model
{
    protected $table = 'reparacion_imagenes';

    protected $fillable = [
        'posicion',
        'ruta_imagen',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Posiciones válidas (espejo de la vista: izq_1..3 y der_1..3)
    |--------------------------------------------------------------------------
    */
    public const POSICIONES = [
        'izq_1', 'izq_2', 'izq_3',
        'der_1', 'der_2', 'der_3',
    ];
}