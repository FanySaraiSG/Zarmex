<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    // Mostrar todas las imágenes (admin)
    public function indexImagen()
    {
        $imagenes = Imagen::orderBy('id', 'desc')->get();
        return view('imagenes.index', compact('imagenes'));
    }

    // Formulario crear (admin)
    public function createImagen()
    {
        return view('imagenes.create');
    }

    // Guardar imagen (admin)
    public function storeImagen(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'imagen'  => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'seccion' => 'required|string|max:255',
        ]);

        // Reglas por sección
        if ($request->seccion === 'banner') {
            $existingImagesCount = Imagen::where('seccion', 'banner')->count();
            if ($existingImagesCount >= 6) {
                return redirect()->back()->withErrors([
                    'seccion' => 'Ya se han subido 6 imágenes en la sección banner.'
                ])->withInput();
            }
        }



        $file = $request->file('imagen');
        $originalName = $file->getClientOriginalName();

        // nombre ÚNICO en DB (evita "Duplicate entry ... nombre_unique")
        // guardo un nombre "seguro" y único, pero conservando el original dentro del string
        $safeName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
        $rutaImagen = 'imagenes/' . $safeName;

        $file->move(public_path('imagenes'), $safeName);

        Imagen::create([
            // OJO: si tu columna "nombre" es UNIQUE, aquí debe ser único
            'nombre'    => $request->nombre . '_' . time(),
            'imagen_url'=> $rutaImagen,
            'seccion'   => $request->seccion,
        ]);

        return redirect()->route('imagenes.index')->with('success', 'Imagen subida correctamente.');
        $img = Image::make($image->getRealPath())
        ->fit(1200, 1200, function ($constraint) {
            $constraint->upsize();
        });

Storage::put('public/productos/'.$nombre, (string) $img->encode());
    }

    // Ver una imagen
    public function showImagen($id)
    {
        $imagen = Imagen::findOrFail($id);
        return view('imagenes.show', compact('imagen'));
    }

    // Editar imagen
    public function editImagen($id)
    {
        $imagen = Imagen::findOrFail($id);
        return view('imagenes.edit', compact('imagen'));
    }

    // Actualizar imagen
    public function updateImagen(Request $request, $id)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'seccion' => 'required|string|max:255',
            'imagen'  => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagen = Imagen::findOrFail($id);

        // Si suben nueva imagen
        if ($request->hasFile('imagen')) {
            $newFile = $request->file('imagen');
            $originalName = $newFile->getClientOriginalName();
            $safeName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
            $rutaImagen = 'imagenes/' . $safeName;

            $newFile->move(public_path('imagenes'), $safeName);

            // borrar archivo anterior
            if ($imagen->imagen_url && file_exists(public_path($imagen->imagen_url))) {
                @unlink(public_path($imagen->imagen_url));
            }

            $imagen->imagen_url = $rutaImagen;
        }

        $imagen->nombre  = $request->nombre;  // aquí NO forzamos unique (solo en create)
        $imagen->seccion = $request->seccion;
        $imagen->save();

        return redirect()->route('imagenes.index')->with('success', 'Imagen actualizada correctamente.');
    }

    // Eliminar imagen
    public function destroyImagen($id)
    {
        $imagen = Imagen::findOrFail($id);

        if ($imagen->imagen_url && file_exists(public_path($imagen->imagen_url))) {
            @unlink(public_path($imagen->imagen_url));
        }

        $imagen->delete();

        return redirect()->route('imagenes.index')->with('success', 'Imagen eliminada correctamente.');
    }

    // Logo (frontend)
    public function getLogoImage()
    {
        return Imagen::where('seccion', 'logo')->orderBy('id', 'desc')->first();
    }

    // Banner principal (frontend)
    public function mostrarBanner()
    {
        $bannerImages = Imagen::where('seccion', 'banner')->orderBy('id', 'desc')->get();
        return view('index', compact('bannerImages'));
    }

    // ✅ Nosotros Banner (frontend) - Carrusel abajo de “Bienvenidos”
    public function mostrarBannerN()
    {
        $nosotrosBannerImages = Imagen::where('seccion', 'nosotros_banner')
            ->orderBy('id', 'desc')
            ->get();

        return view('nosotros', compact('nosotrosBannerImages'));
    }
}