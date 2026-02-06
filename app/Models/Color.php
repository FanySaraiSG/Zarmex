<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $primaryKey = 'id_color';  // Indica que la clave primaria es 'id_color'
    public $incrementing = false;        // Indica que la clave primaria NO es un número autoincremental
    protected $keyType = 'string';       // Especifica que la clave primaria es de tipo string

    protected $fillable = [
        'id_color',
        'nombre',
    ];
}
