<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoDocController extends Controller
{
    public function update(Request $request, Producto $producto)
    {
        // ✅ Validación
        $request->validate([
            'doc1' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        foreach (['doc1', 'doc2', 'doc3'] as $campo) {

            if ($request->hasFile($campo)) {

                $columna = $campo . '_url';

                // ✅ Borrar archivo anterior (si existe)
                if (!empty($producto->$columna)) {
                    $rutaAnterior = public_path($producto->$columna);
                    if (file_exists($rutaAnterior)) {
                        @unlink($rutaAnterior);
                    }
                }

                $archivo = $request->file($campo);

                $ext = strtolower($archivo->getClientOriginalExtension());
                $nombre = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME));
                $nombreFinal = $nombre . '_' . time() . '.' . $ext;

                //  Carpeta destino: public/docs/productos/{id}
                $destino = public_path("docs/productos/{$producto->id}");
                if (!file_exists($destino)) {
                    mkdir($destino, 0777, true);
                }

                //  Mover archivo
                $archivo->move($destino, $nombreFinal);

                //  Guardar ruta pública en BD
                $producto->$columna = "docs/productos/{$producto->id}/{$nombreFinal}";
            }
        }

        $producto->save();

        return back()->with('success', 'Documentos guardados correctamente.');
    }
}
