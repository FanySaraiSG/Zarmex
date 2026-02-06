<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tipo_reporte',
        'descripcion',
        'estado',
        'id_empleado',
        'creado_en',
        'actualizado_en'
    ];

    protected $casts = [
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
    ];

    // Relación con el usuario que reporta
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Relación con el empleado asignado
    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }
}