<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito'; // Nombre de la tabla en la base de datos

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'id_producto',
        'id_color',
        'cantidad',
        'precio',
    ];

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    // Relación con el modelo Producto
// Relación con el modelo Producto
public function producto()
{
    return $this->belongsTo(Producto::class, 'id_producto', 'id');
}

// Relación con el modelo Color
public function color()
{
    return $this->belongsTo(Color::class, 'id_color', 'id_color');
}

}
