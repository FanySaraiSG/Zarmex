<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\TopProduct;  // Asegúrate de importar el modelo TopProduct

class HomeController extends Controller
{
    public function index()
    {
        // Obtener las reseñas activas
        $reseñas = Review::query()->where('estatus', 'activo')->get();

        // Obtener productos destacados (ahora ya existen secciones: todos/novedades/populares)
        $topProducts = TopProduct::query()
            ->with('product')
            ->orderBy('section')
            ->get()
            ->filter(fn ($tp) => !empty($tp->product));



        // Pasar las variables a la vista
        return view('index', compact('reseñas', 'topProducts'));
    }
}
