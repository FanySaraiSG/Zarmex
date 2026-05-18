<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class ImagenProductoController extends Controller
{
    /**
     * Guardar TODO (imágenes nuevas + reorden + video) en una sola request
     */
    public function guardarTodo(Request $request, int $producto_id)
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

        // 1) Reordenar imágenes existentes con base en ordenes[slot] => img_id
        if (is_array($ordenes) && !empty($ordenes)) {
            foreach ($ordenes as $slot => $imgId) {
                $slot = (int) $slot;
                if ($slot < 1 || $slot > 6) continue;
                if (empty($imgId)) continue;

                $imagen = ImagenProducto::where('producto_id', $producto_id)
                    ->where('id', (string) $imgId)
                    ->first();

                if (!$imagen) continue;

                $imagen->orden = $slot;
                $imagen->save();
            }
        }

        // 2) Subir imágenes nuevas (imagenes[]). Se colocan en slots vacíos según el estado actualizado.
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

        // 3) Guardar video (si viene)
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

    // Reordenar imágenes extra (slots 1..6) según ordenes[slot] => img_id
    public function reordenar(Request $request, $producto_id)
    {

        $request->validate([
            'ordenes' => 'required|array',
            'ordenes.*' => 'nullable',
        ]);

        $ordenes = $request->input('ordenes', []);

        foreach ($ordenes as $slot => $imgId) {

            $slot = (int) $slot;
            if ($slot < 1 || $slot > 6) {
                continue;
            }

            if (empty($imgId)) {
                continue;
            }

            // En tu proyecto el primary key es string (id como "{producto_id}_{slot}_...")
            $imagen = ImagenProducto::find((string) $imgId);
            if (!$imagen || $imagen->producto_id != $producto_id) {
                continue;
            }

            // Actualiza orden del slot (1..6)
            $imagen->orden = $slot;
            $imagen->save();

        }

        return redirect()->route('productos.imagenes.show', $producto_id)
            ->with('success', 'Imágenes reordenadas correctamente.');
    }

    // Método para mostrar el formulario de creación de una nueva imagen
    public function create(int $producto_id)
    {
        $producto = Producto::findOrFail($producto_id); // Buscar el producto por ID
        return view('productos.imagen.create', compact('producto')); // Pasar el producto a la vista
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

        // Limitar a un máximo global de 6 imágenes extra
        $cantidadActual = ImagenProducto::where('producto_id', $producto_id)->count();
        $espaciosDisponibles = max(0, 6 - (int) $cantidadActual);

        if ($espaciosDisponibles <= 0) {
            return redirect()->route('productos.imagenes.show', $producto_id)
                ->with('error', 'Ya tienes 6 imágenes. Elimina alguna para subir una nueva.');
        }

        // Tomar solo hasta donde alcance el cupo
        $archivos = array_slice($archivos, 0, $espaciosDisponibles);

        // Slots ocupados por orden (1..6)
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
            if ($siguienteSlot > 6) {
                break;
            }

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

    // Método para mostrar el formulario de edición de una imagen
    public function edit(string $id)
    {
        $imagen = ImagenProducto::findOrFail($id); // Buscar la imagen por ID
        return view('productos.imagen.edit', compact('imagen')); // Muestra la vista para editar la imagen
    }

    // Método para actualizar una imagen existente
    public function update(Request $request, string $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar la nueva imagen
        ]);

        $imagenProducto = ImagenProducto::findOrFail($id); // Buscar la imagen por ID
        $producto_id = $imagenProducto->producto_id;

        $nuevaImagen = $request->file('imagen');

        // MODIFICACIÓN: Nuevo nombre para la actualización
        $nombreImagen = time() . '_' . $nuevaImagen->getClientOriginalName();
        $rutaRelativa = "images/productos/$producto_id";
        $rutaAbsoluta = public_path($rutaRelativa);

        if (!file_exists($rutaAbsoluta)) {
            mkdir($rutaAbsoluta, 0755, true);
        }

        // Eliminar la imagen anterior físicamente si existe para no dejar basura en el servidor
        if (file_exists(public_path($imagenProducto->ruta))) {
            unlink(public_path($imagenProducto->ruta));
        }

        // Mover la nueva imagen
        $nuevaImagen->move($rutaAbsoluta, $nombreImagen);

        // Actualizar la ruta en la base de datos
        $imagenProducto->ruta = "$rutaRelativa/$nombreImagen";
        $imagenProducto->save();

        return redirect()->route('productos.imagenes.show', $producto_id)->with('success', 'Imagen actualizada correctamente.');
    }

    // Método para eliminar una imagen existente
    public function destroy($id)
    {
        $imagenProducto = ImagenProducto::findOrFail($id); 
        $rutaImagen = public_path($imagenProducto->ruta);

        // Eliminar el archivo de la carpeta
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        // Eliminar el registro de la base de datos
        $imagenProducto->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }

    // Método para mostrar las imágenes de un producto en la vista de índice
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        $imagenes = $producto->imagenes; 
        return view('productos.imagen.index', compact('producto', 'imagenes'));
    }
}