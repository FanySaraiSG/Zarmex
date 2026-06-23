<?php

namespace App\Http\Controllers;

use App\Models\ReparacionImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReparacionImagenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Panel admin: mostrar editor de imágenes
    |--------------------------------------------------------------------------
    */
    public function editImagenes()
    {
        // Construir el mismo $imagenesActuales que espera la vista blade
        $imagenesActuales = [];
        foreach (['izq_1','izq_2','izq_3','der_1','der_2','der_3'] as $pos) {
            $reg = ReparacionImagen::where('posicion', $pos)
                       ->where('activo', true)
                       ->first();
            // La vista JS necesita la URL pública completa para mostrar el preview
            $imagenesActuales[$pos] = $reg ? asset($reg->ruta_imagen) : null;
        }

        return view('admin.reparacion.imagenes', compact('imagenesActuales'));
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar imágenes (recibe JSON con base64, igual que mantenimiento)
    |--------------------------------------------------------------------------
    */
    public function updateImagenes(Request $request)
    {
        $data = $request->json()->all();
        // $data = ['izq_1' => 'data:image/...', 'izq_2' => null, ...]

        $resultado = [];

        foreach (['izq_1','izq_2','izq_3','der_1','der_2','der_3'] as $pos) {
            $valor = $data[$pos] ?? null;

            $registro = ReparacionImagen::firstOrNew(['posicion' => $pos]);

            if (!$valor) {
                // Posición vacía: eliminar si existía
                if ($registro->exists && $registro->ruta_imagen) {
                    $this->borrarArchivo($registro->ruta_imagen);
                    $registro->delete();
                }
                $resultado[$pos] = null;
                continue;
            }

            // Si ya es una URL pública (no base64), no tocar el archivo
            if (!str_starts_with($valor, 'data:')) {
                $resultado[$pos] = $valor;
                continue;
            }

            // Decodificar base64 y guardar
            [$meta, $base64] = explode(',', $valor, 2);
            preg_match('/data:image\/(\w+);/', $meta, $m);
            $ext  = $m[1] ?? 'jpg';
            $nombre = 'img_' . $pos . '_' . time() . '_' . uniqid() . '.' . $ext;
            $ruta   = 'imagenes/reparacion/' . $nombre;

            Storage::disk('public')->put($ruta, base64_decode($base64));
            $rutaPublica = 'storage/' . $ruta;

            // Borrar archivo anterior si existía
            if ($registro->exists && $registro->ruta_imagen) {
                $this->borrarArchivo($registro->ruta_imagen);
            }

            $registro->ruta_imagen = $rutaPublica;
            $registro->activo      = true;
            $registro->save();

            $resultado[$pos] = asset($rutaPublica);
        }

        return response()->json([
            'success'   => true,
            'imagenes'  => $resultado,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Página pública de Reparación
    |--------------------------------------------------------------------------
    */
    public function mostrarFormularioPublico()
    {
        $helper = fn(string $pos) => ReparacionImagen::where('posicion', $pos)
            ->where('activo', true)
            ->first();

        return view('reparacion', [
            'img_izq_1' => $helper('izq_1'),
            'img_izq_2' => $helper('izq_2'),
            'img_izq_3' => $helper('izq_3'),
            'img_der_1' => $helper('der_1'),
            'img_der_2' => $helper('der_2'),
            'img_der_3' => $helper('der_3'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: borrar archivo del disco
    |--------------------------------------------------------------------------
    */
    private function borrarArchivo(?string $rutaPublica): void
    {
        if (!$rutaPublica) return;
        $path = str_replace('storage/', '', $rutaPublica);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}