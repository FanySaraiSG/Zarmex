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
        Producto::class,
        'color_producto',
        'color_id',
        'producto_id',
        'id_color',
        'id'
    );
}
}