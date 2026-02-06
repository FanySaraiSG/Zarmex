<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'creado_en',
        'actualizado_en'
    ];
    // En tu modelo Categoria.php
public function productos()
{
    return $this->hasMany(Producto::class, 'categoria_id');
}
}