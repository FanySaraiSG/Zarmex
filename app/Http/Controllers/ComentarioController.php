<?php
namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{

    public function index(Request $request)
    {
        $orden = $request->input('orden', 'asc'); // Orden por defecto: ascendente

        $comentarios = Comentario::with('usuario', 'producto')
            ->orderBy('calificacion', $orden)
            ->paginate(10)
            ->appends(['orden' => $orden]);

        return view('comentarios.index', compact('comentarios', 'orden'));
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->route('comentarios.index')->with('success', 'Comentario eliminado correctamente.');
    }
    
    public function store(Request $request, $producto_id)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
        ]);

        Comentario::create([
            'producto_id' => $producto_id,
            'user_id' => Auth::id(),
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
        ]);

        return redirect()->back()->with('success', 'Comentario agregado correctamente.');
    }

    public function getComentarios(Request $request, $producto_id, $offset = 0)
    {
        $orden = $request->input('orden', 'recientes'); // "recientes" por defecto
    
        $query = Comentario::where('producto_id', $producto_id)->with('usuario');
    
        if ($orden === 'recientes') {
            $query->orderBy('created_at', 'desc');
        } elseif ($orden === 'antiguos') {
            $query->orderBy('created_at', 'asc');
        } elseif ($orden === 'mejor_calificacion') {
            $query->orderBy('calificacion', 'desc');
        } elseif ($orden === 'peor_calificacion') {
            $query->orderBy('calificacion', 'asc');
        }
    
        $comentarios = $query->offset($offset)->limit(3)->get();
    
        return response()->json($comentarios);
    }
    
}
