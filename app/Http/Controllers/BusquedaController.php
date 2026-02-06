<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
    
        $resultados = Producto::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('descripcion', 'LIKE', "%{$query}%")
            ->orWhere('id', 'LIKE', "%{$query}%")
            ->paginate(8); // Puedes cambiar 8 por la cantidad de productos por página
    
        return view('busqueda', compact('resultados', 'query'));
    }
    
}
