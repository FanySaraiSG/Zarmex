<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'reviews';

    protected $primaryKey = 'id_reseña';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'email',
        'descripcion',
        'calificacion',
        'estatus',
    ];

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
