<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Festividad extends Model
{
    protected $table = 'festividades';
    protected $fillable = [
        'nombre',
        'texto_header',
        'color_texto',
        'efecto',
        'decoraciones',
        'fecha_inicio',
        'fecha_fin',
        'activa',
    ];

    protected $casts = [
        'decoraciones' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'activa'       => 'boolean',
    ];

    public static function getActiva(): ?self
    {
        $hoy = Carbon::today();

        // 1. Activa manualmente
        $manual = self::where('activa', true)->first();
        if ($manual) return $manual;

        // 2. Automática por fecha
        return self::whereNotNull('fecha_inicio')
            ->whereNotNull('fecha_fin')
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->first();
    }
}