<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $incrementing = false; // Importante para usar un ID personalizado
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

    public $timestamps = false; // Laravel no manejará automáticamente created_at y updated_at

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }
    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id', 'id');
    }
    public function medida()
    {
        return $this->hasOne(Medida::class, 'producto_id', 'id');
    }

}
