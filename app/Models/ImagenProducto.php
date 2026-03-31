<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'imagenes_productos';

    protected $primaryKey = 'img_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // TABLA SÍ TIENE TIMESTAMPS
    public $timestamps = true;

    protected $fillable = [
        'producto_id',
        'ruta',
        'orden',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}
