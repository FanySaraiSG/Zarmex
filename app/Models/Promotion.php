<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Promotion extends Model
{
    use HasFactory;
    protected $table = 'promociones';
    protected $fillable = [
        'nombre',
        'imagen_url',
        'imagen_path',
        'activo',
    ];
}  