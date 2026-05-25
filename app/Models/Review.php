<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    // ← Elimina la línea de primaryKey, 'id' es el default de Laravel
    
    protected $fillable = [
        'producto_id',
        'guest_nombre',
        'guest_email',
        'descripcion',
        'calificacion',
        'estatus',
        'likes_count',
    ];

    public function product()
    {
        // producto_id es string tipo "ZAR-CQP-002", ajusta la FK del Producto
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}