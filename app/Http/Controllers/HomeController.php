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
        $reseñas = Review::where('estatus', 'activo')->get();

        // Obtener los 5 productos más vendidos
        $topProducts = TopProduct::with('product')->take(5)->get();

        // Pasar las variables a la vista
        return view('index', compact('reseñas', 'topProducts'));
    }
}
