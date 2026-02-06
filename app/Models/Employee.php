<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = 'employees';

    protected $primaryKey = 'id_empleado'; // Aquí especificamos el ID personalizado

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'rol'
    ];

    protected $hidden = [
        'password'
    ];

    const CREATED_AT = 'creado_en'; // Cambiamos a las columnas correctas
    const UPDATED_AT = 'actualizado_en';

    public function hasRole($role)
    {
        return $this->rol === $role;
    }
}
