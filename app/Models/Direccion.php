<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';
    protected $primaryKey = 'id_direccion';
    public $incrementing = false;

    protected $fillable = [
        'id_direccion', 'user_id', 'tipo', 'telefono', 'pais', 'estado', 'ciudad', 
        'codigo_postal', 'calle', 'numero_exterior', 'numero_interior'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($direccion) {
            $direccion->id_direccion = $direccion->user_id . '-' . uniqid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
