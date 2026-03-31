<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentarioController extends Controller
{
    public function index()
    {
        // Admin: ver todos
        $comentarios = DB::table('comentarios')->orderByDesc('created_at')->paginate(20);
        return view('admin.comentarios.index', compact('comentarios'));
    }

    public function getComentarios($producto_id, $offset)
    {
        $comentarios = DB::table('comentarios')
            ->where('producto_id', $producto_id)
            ->orderByDesc('created_at')
            ->offset((int)$offset)
            ->limit(5)
            ->get();

        return response()->json($comentarios);
    }

    // Público: guardar sin login
    public function store(Request $request, $producto_id)
    {
        $request->validate([
            'guest_nombre' => 'nullable|string|max:60',
            'guest_email'  => 'nullable|email|max:120',
            'comentario'   => 'required|string|min:5|max:1000',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        DB::table('comentarios')->insert([
            'producto_id'  => $producto_id,
            'user_id'      => null,
            'guest_nombre' => $request->guest_nombre,
            'guest_email'  => $request->guest_email,
            'comentario'   => $request->comentario,
            'calificacion' => $request->calificacion,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('ok', 'Comentario enviado correctamente');
    }

    public function destroy($id)
    {
        DB::table('comentarios')->where('id', $id)->delete();
        return back()->with('ok', 'Comentario eliminado');
    }
}