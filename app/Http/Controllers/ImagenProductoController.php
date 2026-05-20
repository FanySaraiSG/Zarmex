<?php

namespace App\Http\Controllers;

// 1. IMPORTACIONES
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenProductoController extends Controller
{
    public function guardarTodo(Request $request,int $producto_id)
    {
        $request->validate([
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'ordenes' => 'nullable|array',
            'ordenes.*' => 'nullable',
            'video' => 'nullable|file|mimes:mp4|max:51200',
        ]);

        $ordenes = $request->input('ordenes', []);
        $producto = Producto::findOrFail($producto_id);

        // 1) Reordenar imágenes existentes
        if (is_array($ordenes) && !empty($ordenes)) {
            foreach ($ordenes as $slot => $imgId) {
                $slot = (int) $slot;
                if ($slot < 1 || $slot > 6) continue;
                if (empty($imgId)) continue;

                $imagen = ImagenProducto::where('producto_id', $producto_id)
                    ->where('id', $imgId)
                    ->first();

                if (!$imagen) continue;

                $imagen->orden = $slot;
                $imagen->save();
            }
        }

        // 2) Subir imágenes nuevas
        $archivos = $request->file('imagenes', []);
        if (!is_array($archivos)) $archivos = [];

        $cantidadActual = ImagenProducto::where('producto_id', $producto_id)->count();
        $espaciosDisponibles = max(0, 6 - (int)$cantidadActual);

        if ($espaciosDisponibles > 0 && count($archivos) > 0) {
            $archivos = array_slice($archivos, 0, $espaciosDisponibles);

            $slotsOcupados = ImagenProducto::where('producto_id', $producto_id)
                ->orderBy('orden', 'asc')
                ->pluck('orden')
                ->map(fn($o) => (int)$o)
                ->toArray();

            $slotsOcupadosSet = array_flip($slotsOcupados);
            $siguienteSlot = 1;

            $rutaRelativa = "images/productos/$producto_id";
            $rutaAbsoluta = public_path($rutaRelativa);
            if (!file_exists($rutaAbsoluta)) {
                mkdir($rutaAbsoluta, 0755, true);
            }

            foreach ($archivos as $archivo) {
                while (isset($slotsOcupadosSet[$siguienteSlot]) && $siguienteSlot <= 6) {
                    $siguienteSlot++;
                }
                if ($siguienteSlot > 6) break;

                $nombreImagen = time() . '_' . uniqid() . '_' . $archivo->getClientOriginalName();
                $archivo->move($rutaAbsoluta, $nombreImagen);

                $slot = $siguienteSlot;
                $slotsOcupadosSet[$slot] = true;
                $siguienteSlot++;

                $idImagen = "{$producto_id}_{$slot}_" . time();

                ImagenProducto::create([
                    'id' => $idImagen,
                    'producto_id' => $producto_id,
                    'ruta' => "$rutaRelativa/$nombreImagen",
                    'orden' => $slot,
                ]);
            }
        }

        // 3) Guardar video
        if ($request->hasFile('video')) {
            $rutaProducto = public_path("images/productos/$producto_id");
            if (!file_exists($rutaProducto)) {
                mkdir($rutaProducto, 0755, true);
            }

            if (!empty($producto->video_url) && file_exists(public_path($producto->video_url))) {
                @unlink(public_path($producto->video_url));
            }

            $nombre = 'video_' . time() . '.mp4';
            $request->file('video')->move($rutaProducto, $nombre);

            $producto->video_url = "images/productos/{$producto_id}/{$nombre}";
            $producto->save();
        }

        return redirect()->route('productos.imagenes.index', $producto_id)
            ->with('success', 'Cambios guardados correctamente.');
    }

    public function reordenar(Request $request,int  $producto_id)
    {
        $request->validate([
            'ordenes' => 'required|array',
            'ordenes.*' => 'nullable',
        ]);

        $ordenes = $request->input('ordenes', []);

        foreach ($ordenes as $slot => $imgId) {
            $slot = (int) $slot;
            if ($slot < 1 || $slot > 6) continue;
            if (empty($imgId)) continue;

            $imagen = ImagenProducto::where('id', $imgId)->first();
            if (!$imagen || $imagen->producto_id != $producto_id) {
                continue;
            }

            $imagen->orden = $slot;
            $imagen->save();
        }

        return redirect()->route('productos.imagenes.show', $producto_id)
            ->with('success', 'Imágenes reordenadas correctamente.');
    }

    // SE CAMBIÓ EL NOMBRE AQUÍ PARA EVITAR EL DUPLICADO
    public function subirVideo(Request $request, int $producto_id)
    {
        $request->validate([
            'video' => 'required|mimetypes:video/mp4,video/quicktime|max:51200',
        ]);

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $nombreVideo = time() . '_' . $file->getClientOriginalName();
            $ruta = $file->storeAs('videos_productos', $nombreVideo, 'public');
        }

        return back()->with('success', '¡Video propio subido con éxito!');
    }


  
    // Método para almacenar una o varias imágenes (imagenes[]) de un producto
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'imagenes' => 'required|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $producto_id = $request->input('producto_id');
        $archivos = $request->file('imagenes');

        $cantidadActual = ImagenProducto::where('producto_id', $producto_id)->count();
        $espaciosDisponibles = max(0, 6 - (int) $cantidadActual);

        if ($espaciosDisponibles <= 0) {
            return redirect()->route('productos.imagenes.show', $producto_id)
                ->with('error', 'Ya tienes 6 imágenes. Elimina alguna para subir una nueva.');
        }

        $archivos = array_slice($archivos, 0, $espaciosDisponibles);

        $slotsOcupados = ImagenProducto::where('producto_id', $producto_id)
            ->orderBy('orden', 'asc')
            ->pluck('orden')
            ->map(fn($o) => (int)$o)
            ->toArray();

        $slotsOcupadosSet = array_flip($slotsOcupados);
        $siguienteSlot = 1;

        $rutaRelativa = "images/productos/$producto_id";
        $rutaAbsoluta = public_path($rutaRelativa);
        if (!file_exists($rutaAbsoluta)) {
            mkdir($rutaAbsoluta, 0755, true);
        }

        foreach ($archivos as $archivo) {
            while (isset($slotsOcupadosSet[$siguienteSlot]) && $siguienteSlot <= 6) {
                $siguienteSlot++;
            }
            if ($siguienteSlot > 6) break;

            $nombreImagen = time() . '_' . uniqid() . '_' . $archivo->getClientOriginalName();
            $archivo->move($rutaAbsoluta, $nombreImagen);

            $slot = $siguienteSlot;
            $slotsOcupadosSet[$slot] = true;
            $siguienteSlot++;

            $idImagen = "{$producto_id}_{$slot}_" . time();

            ImagenProducto::create([
                'id' => $idImagen,
                'producto_id' => $producto_id,
                'ruta' => "$rutaRelativa/$nombreImagen",
                'orden' => $slot,
            ]);
        }

        return redirect()->route('productos.imagenes.show', $producto_id)
            ->with('success', 'Imágenes subidas correctamente.');
    }

    public function edit(string $id)
    {
        $imagen = ImagenProducto::findOrFail($id);
        return view('productos.imagen.edit', compact('imagen'));
    }

    // Método para actualizar una imagen existente
    public function update(Request $request, string $id)
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

    // Se cambió de 'int $id' a 'string $id' porque tus IDs son textos complejos
    public function destroy(string $id)
    {
        $imagenProducto = ImagenProducto::findOrFail($id); 
        $rutaImagen = public_path($imagenProducto->ruta);

        if (file_exists($rutaImagen)) {
            @unlink($rutaImagen);
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