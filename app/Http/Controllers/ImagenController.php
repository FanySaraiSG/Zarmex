<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $safeName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
        $rutaImagen = 'imagenes/' . $safeName;

        $file->move(public_path('imagenes'), $safeName);

        Imagen::create([
            'nombre'    => $request->nombre . '_' . time(),
            'imagen_url'=> $rutaImagen,
            'seccion'   => $request->seccion,
        ]);

        return redirect()->route('imagenes.index')->with('success', 'Imagen subida correctamente.');
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

    // Eliminar imagen / video
    public function destroyImagen($id)
    {
        $imagen = Imagen::findOrFail($id);

        if ($imagen->imagen_url && file_exists(public_path($imagen->imagen_url))) {
            @unlink(public_path($imagen->imagen_url));
        }

        $imagen->delete();

        return redirect()->route('imagenes.index')->with('success', 'Recurso eliminado correctamente.');
    }

    // Logo (frontend)
    public function getLogoImage()
    {
        return Imagen::where('seccion', 'logo')->orderBy('id', 'desc')->first();
    }

    // Banner principal (frontend)
    public function mostrarBanner()
    {
        $bannerImages = Imagen::where('seccion', 'banner', "banner_principal")->orderBy('id', 'desc')->get();
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

    // 1. Mostrar formulario para subir video
    public function createVideoBanner()
    {
        return view('videos.create_videos_banner'); 
    }

    // 2. Procesar, limpiar y guardar el video del banner
    public function storeVideoBanner(Request $request)
    {
        // Validamos que sea un video y que no pase de ~60MB
        $request->validate([
            'seccion' => 'required|string',
            'video' => 'required|file|mimes:mp4,webm,mov,avi|max:61440', 
        ]);

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            
            // 1. Obtenemos el nombre original sin la extensión
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            
            // 2. Obtenemos la extensión (mp4, webm, etc.)
            $extension = $file->getClientOriginalExtension();
            
            // 3. Limpiamos por completo caracteres extraños y hashtags (#) convirtiéndolos en guiones
            $cleanName = Str::slug($originalName);
            
            // 4. Armamos el nombre final seguro
            $filename = time() . '_' . $cleanName . '.' . $extension;
            
            // Movemos el archivo purificado a la carpeta que creaste
            $file->move(public_path('videos/banners'), $filename);
            
            // Guardamos usando el modelo Imagen incluyendo el campo 'nombre' para evitar fallos de DB
            Imagen::create([
                'nombre'     => 'video_banner_' . time(),
                'imagen_url' => 'videos/banners/' . $filename, 
                'seccion'    => $request->seccion,
            ]);

            return redirect()->route('imagenes.index')->with('success', '¡Video del banner subido con éxito!');
        }

        return back()->with('error', 'Ocurrió un error al intentar subir el archivo.');
    }
}