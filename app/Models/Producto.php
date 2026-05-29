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
        //'precio',
        //'stock',
        'categoria_id',
        'imagen_url',
        'video_url',   // ✅ Agregado para permitir la subida de videos directos
        'doc1_url',    // ✅ Agregado para el documento 1 (Manual)
        'doc2_url',    // ✅ Agregado para el documento 2 (Ficha)
        'doc3_url',    // ✅ Agregado para el documento 3 (Extra)
        'fecha_creacion'
    ];

    public $timestamps = false;

    // ✅ Accessor: convierte la ruta relativa de la BD en URL completa con asset()
    // Ejemplo BD: "images/productos/ZAR-CQP-001/principal.jpg"
    // Resultado:  "http://127.0.0.1:8000/images/productos/ZAR-CQP-001/principal.jpg"
    public function getImagenUrlAttribute($value): ?string
    {
        if (!$value) return null;
        // Si ya es una URL completa (http/https), la devuelve tal cual
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return asset($value);
    }

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