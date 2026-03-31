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

    return back()->with('ok', 'Reseña enviada correctamente.');
}
public function index()
{
    $pendientes = Review::where('estatus','pendiente')->orderByDesc('created_at')->get();
    $activos    = Review::where('estatus','activo')->orderByDesc('created_at')->get();

    return view('admin.reviews.index', compact('pendientes','activos'));
}

public function estado(Request $request, $id)
{
    $request->validate([
        'estatus' => 'required|in:pendiente,activo',
    ]);

    Review::where('id', $id)->update([
        'estatus' => $request->estatus
    ]);

    return back()->with('ok','Estatus actualizado');
}

public function destroy($id)
{
    Review::where('id',$id)->delete();

    return back()->with('ok','Reseña eliminada');
}
}
