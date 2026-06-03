<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $primaryKey = 'id_color';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_color',
        'nombre',
    ];

    /**
     * Productos que tienen este color asignado.
     */
    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,  // modelo relacionado
            'color_producto', // tabla pivote
            'color_id',       // FK de colors en la pivote
            'producto_id'     // FK de productos en la pivote
        );
    }
}