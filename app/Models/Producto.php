<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $incrementing = false; // ID tipo ZAR-CQP-001
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'imagen_url',
        'fecha_creacion'
    ];

    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    // ✅ Imágenes extra del carrusel (tabla imagenes_productos)
    public function imagenes()
    {
        return $this->hasMany(\App\Models\ImagenProducto::class, 'producto_id', 'id')
            ->orderBy('orden', 'asc');
    }

    public function medida()
    {
        return $this->hasOne(Medida::class, 'producto_id', 'id');
    }
}
