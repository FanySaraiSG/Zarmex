<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'imagenes_productos';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'producto_id',
        'ruta',
        'orden',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}