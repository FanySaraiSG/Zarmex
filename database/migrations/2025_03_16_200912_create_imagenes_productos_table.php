<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'imagenes_productos'; // Nombre de la tabla

    // IMPORTANTE: Indica que el ID no es autoincremental
    public $incrementing = false;

    // IMPORTANTE: Indica que el tipo de la llave primaria es un string
    protected $keyType = 'string';

    protected $fillable = [
        'id', 
        'producto_id', 
        'ruta'
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}