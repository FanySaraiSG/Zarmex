<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes'; // Nombre de la tabla

    protected $primaryKey = 'id'; // Clave primaria

    protected $fillable = ['nombre', 'imagen_url', 'seccion', 'link_url'];

    public $timestamps = true; // Activa 'created_at' y 'updated_at'
}
