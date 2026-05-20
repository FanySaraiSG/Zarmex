<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\ImagenProducto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductoController extends Controller
{
    // Listado principal (Admin y catálogo base)
    public function index($categoria = null)
    {
        $categorias = Categoria::all();

        if ($categoria) {
            $categoriaNombre = DB::table('categorias')
                ->where('id_categoria', $categoria)
                ->value('nombre');

            $productos = Producto::where('categoria_id', $categoria)->get();
        } else {
            $categoriaNombre = 'Todos los productos';
            $productos = Producto::all();
        }

        return view('productos.index', compact('categoriaNombre', 'productos', 'categorias'));
    }

    // Formulario de creación
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:productos,id',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'imagen_url' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'doc1' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        $idProducto = $request->input('id');
        $nombreAuto = 'Producto ' . $idProducto;

        // Crear carpeta física del producto
        $rutaProducto = public_path("images/productos/{$idProducto}");
        if (!file_exists($rutaProducto)) {
            mkdir($rutaProducto, 0755, true);
        }

        // Procesar imagen principal con Intervention Image
        $nombreImagen = 'principal.jpg';
        $rutaImagenFisica = $rutaProducto . '/' . $nombreImagen;
        $imagenPath = "images/productos/{$idProducto}/{$nombreImagen}";

        if ($request->hasFile('imagen_url')) {
            foreach (glob($rutaProducto . "/principal.*") as $archivo) {
                @unlink($archivo);
            }

            $manager = new ImageManager(new Driver());
            $imagenProcesada = $manager->read($request->file('imagen_url'))
                ->cover(1200, 1200)
                ->toJpeg(85);

            file_put_contents($rutaImagenFisica, (string) $imagenProcesada);
        }

        // Crear el registro en la BD
        $producto = Producto::create([
            'id' => $idProducto,
            'nombre' => $nombreAuto,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'imagen_url' => $imagenPath,
        ]);

        // Subir documentos utilizando el método optimizado privado
        $this->procesarDocumentos($request, $producto);
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Formulario de edición
    public function edit(int $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            abort(404, 'Producto no encontrado');
        }

        $categorias = Categoria::all();
        $imagenesExtra = ImagenProducto::where('producto_id', $producto->id)
            ->orderBy('orden')
            ->get();

        return view('productos.edit', compact('producto', 'categorias', 'imagenesExtra'));
    }

    // Actualizar producto existente
    public function update(Request $request, int $id)
    {
        $request->validate([
            'id' => 'required|string|max:50|unique:productos,id,' . $id . ',id',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0', 
            'stock' => 'nullable|integer|min:0',  
            'categoria_id' => 'nullable|exists:categorias,id_categoria',
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'imagenes'    => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'doc1' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        $producto = Producto::findOrFail($id);
        $idAnterior = $producto->id;
        $nuevoId = $request->input('id');

        // LÓGICA CRÍTICA: Migración por cambio manual de ID
        if ($idAnterior !== $nuevoId) {
            DB::beginTransaction();
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                ImagenProducto::where('producto_id', $idAnterior)->update(['producto_id' => $nuevoId]);
                DB::table('productos')->where('id', $idAnterior)->update(['id' => $nuevoId]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                return back()->withErrors(['error' => 'Error al actualizar el ID: ' . $e->getMessage()]);
            }

            // Renombrar carpetas físicas en el servidor
            $this->renombrarCarpetasFisicas($idAnterior, $nuevoId);

            // Reemplazar textos de rutas antiguas por las nuevas en la BD
            $this->actualizarRutasEnBaseDatos($idAnterior, $nuevoId);

            $producto = Producto::findOrFail($nuevoId);
        }

        // Actualizar datos básicos (Excepto archivos e IDs masivos)
        $datos = $request->except(['imagen_url', 'imagenes', 'id', 'nombre', 'doc1', 'doc2', 'doc3']);
        $producto->update($datos);

        $rutaProducto = public_path("images/productos/{$producto->id}");
        if (!file_exists($rutaProducto)) {
            mkdir($rutaProducto, 0755, true);
        }

        // Actualizar Imagen Principal
        if ($request->hasFile('imagen_url')) {
            foreach (glob($rutaProducto . "/principal.*") as $archivo) {
                @unlink($archivo);
            }

            $nombreImagen = 'principal.jpg';
            $manager = new ImageManager(new Driver());
            $imagenProcesada = $manager->read($request->file('imagen_url'))->cover(1200, 1200)->toJpeg(85);
            file_put_contents($rutaProducto . '/' . $nombreImagen, (string) $imagenProcesada);

            $producto->imagen_url = "images/productos/{$producto->id}/{$nombreImagen}";
        }

       // Subir imágenes de la Galería Extra
        if ($request->hasFile('imagenes')) {
            $ultimoOrden = (int) ImagenProducto::where('producto_id', $producto->id)->max('orden');
            $orden = $ultimoOrden + 1;

            foreach ($request->file('imagenes') as $img) {
                $nombre = "extra_" . time() . "_" . uniqid() . ".jpg";
                $manager = new ImageManager(new Driver());
                $imagenExtraProcesada = $manager->read($img)->cover(1200, 1200)->toJpeg(85);
                file_put_contents($rutaProducto . '/' . $nombre, (string) $imagenExtraProcesada);

                // 💡 SOLUCIÓN DEFINITIVA: Generamos un ID único de texto para el VARCHAR
                $idUnicoTexto = 'IMG_' . time() . '_' . strtoupper(Str::random(5));

                // Guardamos con Eloquent usando la estructura real de tu BD
                ImagenProducto::create([
                    'id'          => $idUnicoTexto, // Le pasamos un string único (ej: IMG_1779222_A8F2K)
                    'producto_id' => (string) $producto->id, 
                    'ruta'        => "images/productos/{$producto->id}/{$nombre}",
                    'orden'       => $orden,
                ]);

                $orden++;
            }
        }
            

        // Eliminar documentos si se marcó su respectiva casilla
        foreach (['doc1', 'doc2', 'doc3'] as $campo) {
            $columna = $campo . '_url';
            if ($request->has('eliminar_' . $campo) && !empty($producto->$columna)) {
                if (file_exists(public_path($producto->$columna))) {
                    @unlink(public_path($producto->$columna));
                }
                $producto->$columna = null;
            }
        }

        // Procesar y subir nuevos documentos reemplazando los viejos
        $this->procesarDocumentos($request, $producto);
        $producto->save();

        return redirect()->route('productos.edit', $producto->id)
            ->with('success_edit', 'Producto actualizado correctamente.');
    }

    // Catálogo público por categoría
    public function mostrarProductosPorCategoria( $id_categoria)
    {
        $productos = Producto::query()->where('categoria_id', $id_categoria)->paginate(8);
        $categorias = Categoria::all();
        $categoriaNombre = DB::table('categorias')->where('id_categoria', $id_categoria)->value('nombre');

        return view('catalogo', compact('productos', 'categorias', 'categoriaNombre'));
    }

    // Vista pública de "Ver más"
    // Vista pública de "Ver más"x|
    public function verMas(int $id)
    {
        $producto = Producto::findOrFail($id);
        $nombreCategoria = DB::table('categorias')->where('id_categoria', $producto->categoria_id)->value('nombre');
        
        // 💡 CONEXIÓN DIRECTA Y SEGURA: Traemos las imágenes extras usando Query Builder directo para evitar fallas de relación
        $imagenes = DB::table('imagenes_productos')
            ->where('producto_id', $producto->id)
            ->orderBy('orden')
            ->get();

        return view('vermas', compact('producto', 'nombreCategoria', 'imagenes'));
    }

    // Eliminar producto y todos sus archivos asociados
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Borrar galería extra
        $imagenes = ImagenProducto::where('producto_id', $producto->id)->get();
        foreach ($imagenes as $imagen) {
            if (file_exists(public_path($imagen->ruta))) @unlink(public_path($imagen->ruta));
            $imagen->delete();
        }

        // Borrar imagen principal
        if ($producto->imagen_url && file_exists(public_path($producto->imagen_url))) {
            @unlink(public_path($producto->imagen_url));
        }

        // Borrar documentos técnicos
        foreach (['doc1_url', 'doc2_url', 'doc3_url'] as $col) {
            if (!empty($producto->$col) && file_exists(public_path($producto->$col))) {
                @unlink(public_path($producto->$col));
            }
        }

        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    // Gestionar el Video promocional
    public function updateVideo(Request $request, $id)
    {
        $request->validate(['video' => 'required|file|mimes:mp4|max:51200']);

        $producto = Producto::findOrFail($id);
        $rutaProducto = public_path("images/productos/{$producto->id}");

        if (!file_exists($rutaProducto)) mkdir($rutaProducto, 0755, true);

        if (!empty($producto->video_url) && file_exists(public_path($producto->video_url))) {
            @unlink(public_path($producto->video_url));
        }

        $nombre = 'video_' . time() . '.mp4';
        $request->file('video')->move($rutaProducto, $nombre);
        $producto->video_url = "images/productos/{$producto->id}/{$nombre}";
        $producto->save();

        return redirect()->back()->with('success', 'Video actualizado correctamente.');
    }

    public function destroyVideo($id)
    {
        $producto = Producto::findOrFail($id);

        if (!empty($producto->video_url) && file_exists(public_path($producto->video_url))) {
            @unlink(public_path($producto->video_url));
        }

        $producto->video_url = null;
        $producto->save();

        return response()->json(['success' => true]);
    }

    /* ==========================================================================
       MÉTODOS PRIVADOS DE OPTIMIZACIÓN (Limpieza de código duplicado)
       ========================================================================== */

    private function procesarDocumentos(Request $request, $producto)
    {
        foreach (['doc1', 'doc2', 'doc3'] as $campo) {
            if ($request->hasFile($campo)) {
                $columna = $campo . '_url';

                // Si ya existía un archivo viejo asignado, borrarlo físicamente antes
                if (!empty($producto->$columna) && file_exists(public_path($producto->$columna))) {
                    @unlink(public_path($producto->$columna));
                }

                $archivo = $request->file($campo);
                $ext = strtolower($archivo->getClientOriginalExtension());
                $nombreBase = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME));
                $nombreFinal = $nombreBase . '_' . time() . '.' . $ext;

                $destino = public_path("docs/productos/{$producto->id}");
                if (!file_exists($destino)) mkdir($destino, 0755, true);

                $archivo->move($destino, $nombreFinal);
                $producto->$columna = "docs/productos/{$producto->id}/{$nombreFinal}";
            }
        }
    }

    private function renombrarCarpetasFisicas($idAnterior, $nuevoId)
    {
        $rutaVieja = public_path("images/productos/{$idAnterior}");
        $rutaNueva = public_path("images/productos/{$nuevoId}");
        if (file_exists($rutaVieja) && !file_exists($rutaNueva)) @rename($rutaVieja, $rutaNueva);

        $docsViejos = public_path("docs/productos/{$idAnterior}");
        $docsNuevos = public_path("docs/productos/{$nuevoId}");
        if (file_exists($docsViejos) && !file_exists($docsNuevos)) @rename($docsViejos, $docsNuevos);
    }

    private function actualizarRutasEnBaseDatos($idAnterior, $nuevoId)
    {
        DB::table('productos')
            ->where('id', $nuevoId)
            ->update([
                'imagen_url' => DB::raw("REPLACE(imagen_url, 'images/productos/{$idAnterior}/', 'images/productos/{$nuevoId}/')"),
                'doc1_url'   => DB::raw("REPLACE(doc1_url, 'docs/productos/{$idAnterior}/', 'docs/productos/{$nuevoId}/')"),
                'doc2_url'   => DB::raw("REPLACE(doc2_url, 'docs/productos/{$idAnterior}/', 'docs/productos/{$nuevoId}/')"),
                'doc3_url'   => DB::raw("REPLACE(doc3_url, 'docs/productos/{$idAnterior}/', 'docs/productos/{$nuevoId}/')")
            ]);

        // 💡 CORREGIDO EN PLURAL: Sincronizado con el nombre de tu tabla imagenes_productos
        DB::table('imagenes_productos')
            ->where('producto_id', $nuevoId)
            ->update([
                'ruta' => DB::raw("REPLACE(ruta, 'images/productos/{$idAnterior}/', 'images/productos/{$nuevoId}/')")
            ]);
    }
}