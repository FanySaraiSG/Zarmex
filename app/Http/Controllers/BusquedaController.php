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
            ->paginate(8);

        return view('busqueda', compact('resultados', 'query'));
    }

    // ✅ NUEVO: para el autocomplete (panel tipo tu imagen)
    public function sugerencias(Request $request)
    {
        $q = trim($request->input('q', ''));

        if ($q === '') {
            return response()->json(['items' => []]);
        }

        $productos = Producto::where('nombre', 'LIKE', "%{$q}%")
            ->orWhere('descripcion', 'LIKE', "%{$q}%")
            ->orWhere('id', 'LIKE', "%{$q}%")
            ->limit(20)
            ->get();

        $items = $productos->map(function ($p) {
            return [
                'titulo' => $p->id . ' - ' . ($p->nombre ?? ''),
                'descripcion' => $p->descripcion ?? '',
                // ✅ tu ruta para ver producto (ya existe en tu web.php)
                'url' => url('/vermas/' . $p->id),
            ];
        });

        return response()->json(['items' => $items]);
    }
}
