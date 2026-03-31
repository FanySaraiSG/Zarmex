<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'id_reseña'; // 👈 IMPORTANTE

    protected $fillable = [
        'producto_id',
        'guest_nombre',
        'guest_email',
        'descripcion',
        'calificacion',
        'estatus',
    ];
}