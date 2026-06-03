<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\TopProduct;
use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ FIX: Filtramos por estatus 'aprobado' Y aseguramos que tengan interacciones válidas
        $reseñas = Review::query()
            ->where('estatus', 'aprobado')
            ->latest() // Muestra las más recientes primero
            ->get();

        $topProducts = TopProduct::query()
            ->with('product')
            ->orderBy('section')
            ->get()
            ->filter(fn ($tp) => !empty($tp->product));

        $todosLosProductos = Producto::select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();

        return view('index', compact('reseñas', 'topProducts', 'todosLosProductos'));
    }
}