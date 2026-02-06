<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReseñaController extends Controller
{
    /**
     * Muestra todas las reseñas.
     */
    public function index(Request $request)
    {
        $estatus = $request->input('estatus');

        $reseñas = Review::when($estatus, function ($query, $estatus) {
            return $query->where('estatus', $estatus);
        })->paginate(10);

        return view('reseñas.index', compact('reseñas'));
    }

    /**
     * Muestra el formulario para crear una nueva reseña.
     */
    public function create()
    {
        return view('reseñas.create');
    }

    /**
     * Guarda una nueva reseña en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'descripcion' => 'required',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'email' => $request->email,
            'descripcion' => $request->descripcion,
            'calificacion' => $request->calificacion,
            'estatus' => 'inactivo',
        ]);

        return redirect()->route('dashboard')->with('success', 'Reseña creada exitosamente.');
    }

    /**
     * Muestra una reseña específica.
     */
    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

    /**
     * Muestra el formulario para editar una reseña.
     */
    public function edit($id)
    {
        $reseña = Review::findOrFail($id);
        return view('reviews.edit', compact('reseña'));
    }

    /**
     * Actualiza una reseña en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'estatus' => 'required|in:activo,inactivo',
        ]);

        $reseña = Review::findOrFail($id);
        $reseña->update([
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('reseñas.index')->with('success', 'Reseña actualizada exitosamente.');
    }

    /**
     * Elimina una reseña de la base de datos.
     */
    public function destroy($id)
    {
        $reseña = Review::findOrFail($id);
        $reseña->delete();

        return redirect()->route('reseñas.index')->with('success', 'Reseña eliminada exitosamente.');
    }
}