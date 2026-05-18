<?php

namespace App\Http\Controllers;

// 1. IMPORTACIONES (Solo una vez cada una)
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenProductoController extends Controller
{
    // --- NUEVO MÉTODO PARA VIDEOS (Ahora dentro de la clase) ---
    public function storeVideo(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            // Validamos que sea video mp4/mov y máximo 50MB
            'video' => 'required|mimetypes:video/mp4,video/quicktime|max:51200',
        ]);

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $nombreVideo = time() . '_' . $file->getClientOriginalName();
            
            // Guarda en storage/app/public/videos_productos
            $ruta = $file->storeAs('videos_productos', $nombreVideo, 'public');

            // Aquí puedes guardar en la BD si tienes una tabla de videos
            /*
            VideoProducto::create([
                'producto_id' => $request->producto_id,
                'ruta' => $ruta,
            ]);
            */
        }

        return back()->with('success', '¡Video propio subido con éxito!');
    }

    // --- MÉTODOS EXISTENTES ---

    public function create(int $producto_id)
    {
        $producto = Producto::findOrFail($producto_id);
        return view('productos.imagen.create', compact('producto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto_id = $request->producto_id;
        $imagen = $request->file('imagen');

        $numImagenes = ImagenProducto::query()->where('producto_id', $producto_id)->count();
        $nuevoNumero = $numImagenes + 1;

        $idImagen = "{$producto_id}_{$nuevoNumero}";
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

        $rutaRelativa = "images/productos/$producto_id";
        $rutaAbsoluta = public_path($rutaRelativa);

        if (!file_exists($rutaAbsoluta)) {
            mkdir($rutaAbsoluta, 0755, true);
        }

        $imagen->move($rutaAbsoluta, $nombreImagen);

        ImagenProducto::create([
            'id' => $idImagen, 
            'producto_id' => $producto_id,
            'ruta' => "$rutaRelativa/$nombreImagen"
        ]);

        return redirect()->route('productos.imagenes.show', $producto_id)->with('success', 'Imagen subida correctamente.');
    }

    public function edit(int $id)
    {
        $imagen = ImagenProducto::findOrFail($id);
        return view('productos.imagen.edit', compact('imagen'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagenProducto = ImagenProducto::findOrFail($id);
        $producto_id = $imagenProducto->producto_id;
        $nuevaImagen = $request->file('imagen');

        $nombreImagen = time() . '_' . $nuevaImagen->getClientOriginalName();
        $rutaRelativa = "images/productos/$producto_id";
        $rutaAbsoluta = public_path($rutaRelativa);

        if (!file_exists($rutaAbsoluta)) {
            mkdir($rutaAbsoluta, 0755, true);
        }

        if (file_exists(public_path($imagenProducto->ruta))) {
            unlink(public_path($imagenProducto->ruta));
        }

        $nuevaImagen->move($rutaAbsoluta, $nombreImagen);

        $imagenProducto->ruta = "$rutaRelativa/$nombreImagen";
        $imagenProducto->save();

        return redirect()->route('productos.imagenes.show', $producto_id)->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroy(int $id)
    {
        $imagenProducto = ImagenProducto::findOrFail($id); 
        $rutaImagen = public_path($imagenProducto->ruta);

        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        $imagenProducto->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function show(int $id)
    {
        $producto = Producto::findOrFail($id);
        $imagenes = $producto->imagenes; 
        return view('productos.imagen.index', compact('producto', 'imagenes'));
    }
}