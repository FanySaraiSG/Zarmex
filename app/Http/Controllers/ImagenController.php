<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    // Mostrar todas las imágenes
    public function indexImagen()
    {
        $imagenes = Imagen::all();
        $logoImage = $this->getLogoImage();
        return view('imagenes.index', compact('imagenes'));
    }

    // Mostrar el formulario para crear una nueva imagen
    public function createImagen()
    {
        return view('imagenes.create');
    }

    // Almacenar una nueva imagen
    public function storeImagen(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seccion' => 'required|string|max:255',
        ]);

        // Lógica para verificar secciones con límite de imágenes
        if ($request->seccion === 'banner') {
            $existingImagesCount = Imagen::where('seccion', 'banner')->count();
            if ($existingImagesCount >= 6) {
                return redirect()->back()->withErrors(['seccion' => 'Ya se han subido 6 imágenes en la sección banner.']);
            }
        } elseif ($request->seccion === 'nosotros_banner') {
            $existingImagesCount = Imagen::where('seccion', 'nosotros_banner')->count();
            if ($existingImagesCount >= 3) {
                return redirect()->back()->withErrors(['seccion' => 'Ya se han subido 3 imágenes en la sección nosotros_banner.']);
            }
        }

        $imagen = $request->file('imagen');
        $nombreImagen = $imagen->getClientOriginalName();
        $rutaImagen = 'imagenes/' . $nombreImagen;

        $imagen->move(public_path('imagenes'), $nombreImagen);

        Imagen::create([
            'nombre' => $nombreImagen,
            'imagen_url' => $rutaImagen,
            'seccion' => $request->seccion,
        ]);

        return redirect()->route('imagenes.index')->with('success', 'Imagen subida correctamente.');
    }

    // Mostrar una imagen específica
    public function showImagen($id)
    {
        $imagen = Imagen::findOrFail($id); // Obtener la imagen por ID
        return view('imagenes.show', compact('imagen')); // Retornar la vista de la imagen
    }

    // Mostrar el formulario para editar una imagen existente
    public function editImagen($id)
    {
        $imagen = Imagen::findOrFail($id); // Obtener la imagen por ID
        return view('imagenes.edit', compact('imagen')); // Retornar la vista del formulario de edición
    }

    // Actualizar una imagen existente
    public function updateImagen(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'seccion' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagen = Imagen::findOrFail($id);

        // Verificar reglas de secciones
        if ($request->seccion !== 'nosotros' && $imagen->seccion !== $request->seccion) {
            $existingImage = Imagen::where('seccion', $request->seccion)->first();
            if ($existingImage) {
                return redirect()->back()->withErrors(['seccion' => 'Ya existe una imagen en la sección ' . $request->seccion]);
            }
        } elseif ($request->seccion === 'nosotros' && $imagen->seccion !== 'nosotros') {
            $existingImagesCount = Imagen::where('seccion', 'nosotros')->count();
            if ($existingImagesCount >= 3) {
                return redirect()->back()->withErrors(['seccion' => 'Ya se han subido 3 imágenes en la sección nosotros.']);
            }
        }

        // Si se sube una nueva imagen, actualizarla
        if ($request->hasFile('imagen')) {
            $newImagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $newImagen->getClientOriginalName(); // Evitar nombres duplicados
            $rutaImagen = 'imagenes/' . $nombreImagen;

            // Mover la imagen a la carpeta pública
            $newImagen->move(public_path('imagenes'), $nombreImagen);

            // Eliminar la imagen anterior si existe
            if ($imagen->imagen_url && file_exists(public_path($imagen->imagen_url))) {
                unlink(public_path($imagen->imagen_url));
            }

            $imagen->imagen_url = $rutaImagen;
        }

        // Actualizar los otros campos
        $imagen->nombre = $request->nombre;
        $imagen->seccion = $request->seccion;
        $imagen->save();

        return redirect()->route('imagenes.index')->with('success', 'Imagen actualizada correctamente.');
    }


    // Eliminar una imagen
    public function destroyImagen($id)
    {
        $imagen = Imagen::findOrFail($id); // Obtener la imagen por ID
        // Opcional: eliminar la imagen del disco
        // if (file_exists(public_path($imagen->imagen_url))) {
        //     unlink(public_path($imagen->imagen_url));
        // }

        $imagen->delete(); // Eliminar la imagen de la base de datos
        return redirect()->route('imagenes.index')->with('success', 'Imagen eliminada correctamente.');
    }
    public function getLogoImage()
    {
        return Imagen::where('seccion', 'logo')->first(); // Obtener la imagen del logo
    }
    public function mostrarBanner()
    {
        $bannerImage = Imagen::where('seccion', 'banner')->get();
        return view('index', compact('bannerImage'));
    }
    public function mostrarBannerN()
    {
        $bannerNImage = Imagen::where('seccion', 'nosotros_banner')->first();
        return view('nosotros', compact('bannerNImage'));
    }
    public function mostrarNosotros()
{
    $nosotrosImages = Imagen::where('seccion', 'nosotros')->get(); // Obtener todas las imágenes de la sección "nosotros"
    return view('nosotros', compact('nosotrosImages')); // Retornar la vista con las imágenes
}

}
