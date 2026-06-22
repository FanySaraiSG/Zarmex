<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'categoria_id',
        'imagen_url',
        'video_url',
        'doc1_url',
        'doc2_url',
        'doc3_url',
        'fecha_creacion'
    ];

    public $timestamps = false;

    // Accessor: devuelve la URL completa con asset()
    // Si ya es URL completa la devuelve tal cual
    public function getImagenUrlAttribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return asset($value);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    // Imágenes extra del carrusel (tabla imagenes_productos)
    public function imagenes()
    {
        return $this->hasMany(\App\Models\ImagenProducto::class, 'producto_id', 'id')
            ->orderBy('orden', 'asc');
    }

    public function medida()
    {
        return $this->hasOne(Medida::class, 'producto_id', 'id');
    }

    /**
     * Colores disponibles para este producto.
     * Administrados desde el panel de administración.
     * Tabla pivote: color_producto (producto_id, color_id → id_color de colors)
     */
    public function colores()
    {
        return $this->belongsToMany(
            Color::class,     // modelo App\Models\Color
            'color_producto', // tabla pivote
            'producto_id',    // FK de productos en la pivote
            'color_id'        // FK de colors en la pivote (apunta a id_color)
        );
    }
}