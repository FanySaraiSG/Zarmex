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
        //'precio',
        //'stock',
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
}