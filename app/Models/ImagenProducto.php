<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'imagenes_productos';

    // 💡 CORREGIDO: Ajustado a lo que muestra tu phpMyAdmin
    protected $primaryKey = 'id'; 
    public $incrementing = "true"; 
    protected $keyType = 'int';

    public $timestamps = true;

    protected $casts = [
        'id'          => 'string',
        'producto_id' => 'string',
    ];

    protected $fillable = [
        'id', // Permitimos llenarlo manualmente
        'producto_id',
        'ruta',
        'orden',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}