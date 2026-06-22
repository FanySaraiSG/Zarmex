<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Festividad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Listas de valores válidos para festividad, deben coincidir con las opciones del formulario (create_festividad.blade.php)
const FESTIVIDAD_EFECTOS = [
    'none', 'glow', 'tricolor', 'shadow', 'outline', 'rainbow', 'fire', 'ice',
    'neon', 'vintage', 'pulse', 'shimmer', 'retro', 'matrix', 'pirate',
    'carnival', 'coral', 'aurora', 'lava',
];

const FESTIVIDAD_DECORACIONES = [
    'nieve', 'flores', 'velas', 'murcielagos', 'fantasmas', 'calabazas',
    'corazones', 'confetti', 'estrellas', 'rosas', 'acebo', 'banderas',
    'fuegos', 'arboles', 'regalos', 'campanas', 'globos', 'soles', 'lunas',
    'arcoiris', 'mariposas', 'diamantes', 'coronas', 'notas', 'serpentinas',
    'brujitas',
];

class ImagenController extends Controller
{
    public function indexImagen()
    {
        $imagenes = Imagen::orderBy('id', 'desc')->get();
        $festividadActiva = Festividad::getActiva();
        $festividades = Festividad::orderBy('fecha_inicio', 'desc')->get();
        return view('imagenes.index', compact('imagenes', 'festividadActiva', 'festividades'));
    }

    public function createImagen()
    {
        return view('imagenes.create');
    }

    public function storeImagen(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'imagen'  => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'seccion' => 'required|string|max:255',
            'link_url'=> 'nullable|url|max:2048',
        ]);

        if ($request->seccion === 'banner') {
            $existingImagesCount = Imagen::where('seccion', 'banner')->count();
            if ($existingImagesCount >= 6) {
                return redirect()->back()->withErrors(['seccion' => 'Ya se han subido 6 imágenes en la sección banner.'])->withInput();
            }
        }

        $file = $request->file('imagen');
        $safeName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move(public_path('imagenes'), $safeName);

        Imagen::create([
            'nombre'    => $request->nombre . '_' . time(),
            'imagen_url'=> 'imagenes/' . $safeName,
            'seccion'   => $request->seccion,
            'link_url'  => $request->link_url,
        ]);

        return redirect()->route('imagenes.index')->with('success', 'Imagen subida correctamente.');
    }

    public function showImagen($id) { return view('imagenes.show', ['imagen' => Imagen::findOrFail($id)]); }

    public function editImagen($id) { return view('imagenes.edit', ['imagen' => Imagen::findOrFail($id)]); }

    public function updateImagen(Request $request, $id)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'seccion' => 'required|string|max:255',
            'imagen'  => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link_url'=> 'nullable|url|max:2048',
        ]);
        $imagen = Imagen::findOrFail($id);

        if ($request->hasFile('imagen')) {
            if ($imagen->imagen_url && file_exists(public_path($imagen->imagen_url))) @unlink(public_path($imagen->imagen_url));
            $safeName = time() . '_' . preg_replace('/\s+/', '_', $request->file('imagen')->getClientOriginalName());
            $request->file('imagen')->move(public_path('imagenes'), $safeName);
            $imagen->imagen_url = 'imagenes/' . $safeName;
        }

        $imagen->update([
            'nombre'  => $request->nombre,
            'seccion' => $request->seccion,
            'link_url'=> $request->link_url,
        ]);
        return redirect()->route('imagenes.index')->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroyImagen($id)
    {
        $imagen = Imagen::findOrFail($id);
        if ($imagen->imagen_url && file_exists(public_path($imagen->imagen_url))) @unlink(public_path($imagen->imagen_url));
        $imagen->delete();
        return redirect()->route('imagenes.index')->with('success', 'Recurso eliminado correctamente.');
    }

    public function getLogoImage() { return Imagen::where('seccion', 'logo')->orderBy('id', 'desc')->first(); }

    public function mostrarBanner()
    {
        $bannerImages = Imagen::whereIn('seccion', ['banner', 'banner_principal'])->orderBy('id', 'desc')->get();
        return view('index', compact('bannerImages'));
    }

    // ✅ CORREGIDO: ahora también pasa $nosotrosVideos a la vista
    public function mostrarBannerN()
    {
        $nosotrosBannerImages = Imagen::where('seccion', 'nosotros_banner')->orderBy('id', 'desc')->get();
        $nosotrosVideos       = Imagen::where('seccion', 'nosotros_video')->orderBy('id', 'desc')->get();

        return view('nosotros', compact('nosotrosBannerImages', 'nosotrosVideos'));
    }

    public function createVideoBanner() { return view('videos.create_videos_banner'); }

    public function storeVideoBanner(Request $request)
    {
        $request->validate(['seccion' => 'required|string', 'video' => 'required|file|mimes:mp4,webm,mov,avi|max:61440']);

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('videos/banners'), $filename);

            Imagen::create([
                'nombre'     => 'video_banner_' . time(),
                'imagen_url' => 'videos/banners/' . $filename,
                'seccion'    => $request->seccion,
            ]);
            return redirect()->route('imagenes.index')->with('success', '¡Video del banner subido con éxito!');
        }
        return back()->with('error', 'Ocurrió un error al intentar subir el archivo.');
    }

    // ==========================================================
    // FESTIVIDADES
    // ==========================================================

    public function createFestividad()
    {
        return view('imagenes.create_festividad');
    }

    public function storeFestividad(Request $request)
    {
        $validated = $this->validateFestividad($request);

        Festividad::create($validated);

        return redirect()->route('imagenes.index')->with('success', 'Festividad creada correctamente.');
    }

    public function editFestividad(Festividad $festividad)
    {
        return view('imagenes.edit_festividad', compact('festividad'));
    }

    public function updateFestividad(Request $request, Festividad $festividad)
    {
        $validated = $this->validateFestividad($request);

        $festividad->update($validated);

        return redirect()->route('imagenes.index')->with('success', 'Festividad actualizada correctamente.');
    }

    public function destroyFestividad(Festividad $festividad)
    {
        $festividad->delete();

        return redirect()->route('imagenes.index')->with('success', 'Festividad eliminada correctamente.');
    }

    // Activa esta festividad y desactiva cualquier otra que estuviera activa,
    // para que getActiva() nunca tenga ambigüedad sobre cuál mostrar.
    public function activarFestividad(Festividad $festividad)
    {
        Festividad::where('activa', true)->update(['activa' => false]);
        $festividad->update(['activa' => true]);

        return redirect()->route('imagenes.index')->with('success', 'Festividad activada correctamente.');
    }

    public function desactivarFestividad(Request $request)
    {
        Festividad::where('activa', true)->update(['activa' => false]);

        return redirect()->route('imagenes.index')->with('success', 'Festividad desactivada correctamente.');
    }

    // Reglas de validación compartidas entre storeFestividad y updateFestividad
    private function validateFestividad(Request $request): array
    {
        return $request->validate([
            'nombre'          => 'required|string|max:255',
            'texto_header'    => 'required|string|max:50',
            'color_texto'     => 'nullable|string|max:20',
            'efecto'          => 'nullable|in:' . implode(',', FESTIVIDAD_EFECTOS),
            'decoraciones'    => 'nullable|array',
            'decoraciones.*'  => 'in:' . implode(',', FESTIVIDAD_DECORACIONES),
            'fecha_inicio'    => 'nullable|date',
            'fecha_fin'       => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
    }
}