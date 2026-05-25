<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\TopProduct;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ FIX: el enum es 'aprobado', no 'activo'
        $reseñas = Review::query()->where('estatus', 'aprobado')->get();

        $topProducts = TopProduct::query()
            ->with('product')
            ->orderBy('section')
            ->get()
            ->filter(fn ($tp) => !empty($tp->product));

        return view('index', compact('reseñas', 'topProducts'));
    }
}