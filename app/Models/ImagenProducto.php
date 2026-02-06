<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'imagenes_productos';
    protected $primaryKey = 'id';   
    public $incrementing = false; // No autoincremental
    protected $keyType = 'string'; // ID es un string

    protected $fillable = ['id', 'producto_id', 'ruta'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}
