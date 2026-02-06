<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'direccion_id',
        'metodo_pago',
        'monto_total',
        'estado',
        'transaccion_id',
        'detalles',
        'productos',
        'estado_interno', // Agregar el nuevo campo aquí
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }
}