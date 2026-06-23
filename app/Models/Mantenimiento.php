<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable = [
        'nombre',
        'ocupacion',
        'tipo_maquina',
        'codigo_equipo',
        'descripcion',
        'direccion',
        'estado',
        'codigo_postal',
        'numero_celular',
        'correo_electronico',
        'status',
        'tipo',
    ];
}
