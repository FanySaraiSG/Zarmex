<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $producto_id)
    {
        $request->validate([
            'guest_nombre' => 'nullable|string|max:60',
            'guest_email'  => 'nullable|email|max:120',
            'calificacion' => 'required|integer|min:1|max:5',
            'descripcion'  => 'required|string|min:5|max:1000',
        ]);

        Review::create([
            'producto_id'  => $producto_id,
            'guest_nombre' => $request->guest_nombre,
            'guest_email'  => $request->guest_email,
            'descripcion'  => $request->descripcion,
            'calificacion' => $request->calificacion,
            'estatus'      => 'pendiente',
        ]);

        return back()->with('ok', 'Reseña enviada. Será visible tras su aprobación.');
    }

    public function index()
    {
        $pendientes = Review::where('estatus', 'pendiente')->orderByDesc('created_at')->get();
        $activos    = Review::where('estatus', 'aprobado')->orderByDesc('created_at')->get();

        return view('admin.reviews.index', compact('pendientes', 'activos'));
    }

    // ✅ NUEVO: dar like a una reseña
    public function like($id)
    {
        $review = Review::findOrFail($id);
        $review->increment('likes_count');

        return response()->json([
            'ok'          => true,
            'likes_count' => $review->likes_count,
        ]);
    }

    // ✅ CORREGIDO: Enfoque directo con save() para asegurar la persistencia
    public function estado(Request $request, $id)
    {
        $request->validate([
            'estatus' => 'required|in:pendiente,aprobado,oculto',
        ]);

        // Buscamos la reseña por ID, si no existe arroja un error 404
        $review = Review::findOrFail($id);
        
        // Asignamos el estatus validado ('aprobado', 'pendiente' u 'oculto')
        $review->estatus = $request->estatus;
        $review->save();

        return back()->with('ok', 'Estatus actualizado con éxito');
    }

    public function destroy($id)
    {
        Review::where('id', $id)->delete();

        return back()->with('ok', 'Reseña eliminada');
    }
}