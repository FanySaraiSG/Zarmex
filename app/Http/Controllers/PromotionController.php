<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Actualiza nombre e imagen de una promoción.
     * Ruta: PUT /promociones/{id} → promociones.update
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nombre'  => 'required|string|max:120',
            'imagen'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $promo = Promotion::findOrFail($id);

        $promo->nombre = $request->input('nombre');
        $promo->activo = true; // ✅ se activa al guardar por primera vez

        if ($request->hasFile('imagen')) {
            // Elimina la imagen anterior si existe y no es una URL externa
            if ($promo->imagen_url && !str_starts_with($promo->imagen_url, 'http')) {
                $rutaAnterior = public_path($promo->imagen_url);
                if (file_exists($rutaAnterior)) {
                    @unlink($rutaAnterior);
                }
            }

            // Guarda la nueva imagen en public/imagenes/promociones/
            $archivo       = $request->file('imagen');
            $nombreArchivo = 'promo_' . $id . '_' . time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('imagenes/promociones'), $nombreArchivo);

            $promo->imagen_url = 'imagenes/promociones/' . $nombreArchivo;
        }

        $promo->save();

        return redirect()->back()->with('success', "Promoción {$id} actualizada correctamente.");
    }
}