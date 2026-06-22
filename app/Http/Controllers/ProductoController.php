<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\ImagenProducto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    // Listado principal — muestra categorías con conteo de productos
    public function index()
    {
        $categorias = Categoria::withCount('productos')
                        ->with('productos')
                        ->get();

        return view('productos.index', compact('categorias'));
    }

    // Listado de productos filtrado por categoría
    public function porCategoria($categoria)
    {
        $categorias = Categoria::all();

        $categoriaNombre = DB::table('categorias')
            ->where('id_categoria', $categoria)
            ->value('nombre');

        $productos = Producto::where('categoria_id', $categoria)->get();

        return view('productos.por_categoria', compact('categoriaNombre', 'productos', 'categorias'));
    }

    // Formulario de creación
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function obtenerSiguienteNumeroBase($categoriaId)
    {
        $categoriaId = urldecode($categoriaId);

        $ultimoProducto = Producto::where('categoria_id', $categoriaId)
            ->orderBy('id', 'desc')
            ->first();

        if (!$ultimoProducto) {
            return response()->json(['siguiente_numero' => '001']);
        }

        $partes = explode('-', $ultimoProducto->id);
        $ultimoNumero = intval(end($partes)); 
        $siguiente = str_pad($ultimoNumero + 1, 3, '0', STR_PAD_LEFT);
        
        return response()->json(['siguiente_numero' => $siguiente]);
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'id'           => 'required|unique:productos,id',
            'descripcion'  => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'video'        => 'nullable|file|mimes:mp4,mkv,avi,mov|max:51200',
            'imagenes'     => 'required|array|min:1',
            'imagenes.*'   => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'doc1'         => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2'         => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3'         => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        $idProducto = $request->input('id');
        $nombreAuto = 'Producto ' . $idProducto;

        $rutaProducto = public_path("images/productos/{$idProducto}");
        if (!file_exists($rutaProducto)) {
            mkdir($rutaProducto, 0755, true);
        }

        $imagenesCargadas = $request->file('imagenes');
        $temporalMapeo = [];

        if (!empty($imagenesCargadas)) {
            foreach ($imagenesCargadas as $indice => $img) {
                $ext = strtolower($img->getClientOriginalExtension());
                $nombreArchivo = "img_" . time() . "_" . uniqid() . '.' . $ext;
                $img->move($rutaProducto, $nombreArchivo);

                $rutaFinalDb = "images/productos/{$idProducto}/{$nombreArchivo}";
                $temporalMapeo["nueva-{$indice}"] = $rutaFinalDb;
            }
        }

        $producto = Producto::create([
            'id'           => $idProducto,
            'nombre'       => $nombreAuto,
            'descripcion'  => $request->descripcion ?? '',
            'categoria_id' => $request->categoria_id,
            'precio'       => $request->input('precio', 0) ?? 0,
            'stock'        => $request->input('stock', 0) ?? 0,
            'imagen_url'   => null,
        ]);

        $imagenPrincipalDb = null;

        if ($request->filled('orden_imagenes')) {
            $ordenMapeo = json_decode($request->input('orden_imagenes'), true);
            if (is_array($ordenMapeo)) {
                $contadorOrden = 1;
                foreach ($ordenMapeo as $idTemporalFront) {
                    if (isset($temporalMapeo[$idTemporalFront])) {
                        $rutaImagen = $temporalMapeo[$idTemporalFront];
                        $idUnicoBd = 'IMG_' . time() . '_' . strtoupper(Str::random(5));
                        if ($contadorOrden === 1) $imagenPrincipalDb = $rutaImagen;

                        ImagenProducto::create([
                            'id'          => $idUnicoBd,
                            'producto_id' => $producto->id,
                            'ruta'        => $rutaImagen,
                            'orden'       => $contadorOrden,
                        ]);
                        $contadorOrden++;
                    }
                }
            }
        }

        if (empty($imagenPrincipalDb)) $imagenPrincipalDb = reset($temporalMapeo);
        $producto->imagen_url = $imagenPrincipalDb;

        if ($request->hasFile('video')) {
            $nombreVideo = 'video_' . time() . '.mp4';
            $request->file('video')->move($rutaProducto, $nombreVideo);
            $producto->video_url = "images/productos/{$producto->id}/{$nombreVideo}";
        }

        $this->procesarDocumentos($request, $producto);
        // Guardar colores del producto
if ($request->filled('colores')) {
    $producto->colores()->sync($request->colores);
}
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::find($id);
        if (!$producto) abort(404, 'Producto no encontrado');

        $categorias = Categoria::all();
        $colores = Color::all(); 
        $imagenesExtra = ImagenProducto::where('producto_id', $producto->id)->orderBy('orden', 'asc')->get();

        return view('productos.edit', compact('producto', 'categorias', 'colores', 'imagenesExtra'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id'           => 'required|string|max:50|unique:productos,id,' . $id . ',id',
            'descripcion'  => 'nullable|string',
            'categoria_id' => 'nullable|exists:categorias,id_categoria',
            'video'        => 'nullable|file|mimes:mp4,mkv,avi,mov|max:51200',
            'video_url'    => 'nullable|url|max:500',
            'imagenes'     => 'nullable|array',
            'imagenes.*'   => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'doc1'         => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2'         => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3'         => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        $producto   = Producto::findOrFail($id);
        $idAnterior = $producto->id;
        $nuevoId    = $request->input('id');

        if ($idAnterior !== $nuevoId) {
            DB::beginTransaction();
            try {
                DB::table('imagenes_productos')->where('producto_id', $idAnterior)->update(['producto_id' => $nuevoId]);
                DB::table('productos')->where('id', $idAnterior)->update(['id' => $nuevoId]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Error al actualizar el ID: ' . $e->getMessage()]);
            }
            $this->renombrarCarpetasFisicas($idAnterior, $nuevoId);
            $this->actualizarRutasEnBaseDatos($idAnterior, $nuevoId);
            $producto = Producto::findOrFail($nuevoId);
        }

        // Solo actualizamos los campos de texto editables.
        // NO usar except() aquí — pisaría doc1_url/doc2_url/doc3_url con null
        // antes de que procesarDocumentos() los pueda guardar correctamente.
        $datos = $request->only(['descripcion', 'categoria_id']);
        $producto->fill($datos);

        $rutaProducto = public_path("images/productos/{$producto->id}");
        if (!file_exists($rutaProducto)) mkdir($rutaProducto, 0755, true);

        $eliminadasJson = $request->input('imagenes_eliminadas', '[]');
        $idsEliminar    = json_decode($eliminadasJson, true) ?? [];

        foreach ($idsEliminar as $imgId) {
            $idLimpio     = str_replace('existente-', '', $imgId);
            $imgExistente = ImagenProducto::find($idLimpio);
            if ($imgExistente && $imgExistente->producto_id == $producto->id) {
                if (file_exists(public_path($imgExistente->ruta))) @unlink(public_path($imgExistente->ruta));
                $imgExistente->delete();
            }
        }

        $nuevasRutasGuardadas = [];
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $img) {
                $ext    = strtolower($img->getClientOriginalExtension());
                $nombre = "extra_" . time() . "_" . uniqid() . '.' . $ext;
                $img->move($rutaProducto, $nombre);
                $idUnicoTexto = 'IMG_' . time() . '_' . strtoupper(Str::random(5));
                ImagenProducto::create([
                    'id'          => $idUnicoTexto,
                    'producto_id' => (string) $producto->id,
                    'ruta'        => "images/productos/{$producto->id}/{$nombre}",
                    'orden'       => 999,
                ]);
                $nuevasRutasGuardadas[] = $idUnicoTexto;
            }
        }

        if ($request->filled('orden_imagenes')) {
            $ordenMapeo = json_decode($request->input('orden_imagenes'), true);
            if (is_array($ordenMapeo)) {
                $contadorOrden = 1;
                $indiceNuevas = 0;
                foreach ($ordenMapeo as $idData) {
                    if (str_starts_with($idData, 'existente-')) {
                        $idDb = str_replace('existente-', '', $idData);
                        ImagenProducto::where('id', $idDb)->where('producto_id', $producto->id)->update(['orden' => $contadorOrden]);
                        $contadorOrden++;
                    } elseif (str_starts_with($idData, 'nueva-')) {
                        if (isset($nuevasRutasGuardadas[$indiceNuevas])) {
                            $idNuevaCreada = $nuevasRutasGuardadas[$indiceNuevas];
                            ImagenProducto::where('id', $idNuevaCreada)->update(['orden' => $contadorOrden]);
                            $indiceNuevas++;
                            $contadorOrden++;
                        }
                    }
                }
            }
        }

        $imagenPrincipalActualizada = ImagenProducto::where('producto_id', $producto->id)->orderBy('orden', 'asc')->first();
        if ($imagenPrincipalActualizada) $producto->imagen_url = $imagenPrincipalActualizada->ruta;

        if ($request->hasFile('video')) {
            if (!empty($producto->video_url) && file_exists(public_path($producto->video_url))) @unlink(public_path($producto->video_url));
            $nombreVideo = 'video_' . time() . '.mp4';
            $request->file('video')->move($rutaProducto, $nombreVideo);
            $producto->video_url = "images/productos/{$producto->id}/{$nombreVideo}";
        } elseif ($request->filled('video_url')) {
            // Guardar URL de YouTube o Vimeo (no es archivo, es texto)
            $producto->video_url = $request->input('video_url');
        } elseif ($request->has('video_url') && $request->input('video_url') === '') {
            // Campo enviado vacío = el usuario borró el video URL
            $producto->video_url = null;
        }

        foreach (['doc1', 'doc2', 'doc3'] as $campo) {
            $columna = $campo . '_url';
            if ($request->has('eliminar_' . $campo) && !empty($producto->$columna)) {
                if (file_exists(public_path($producto->$columna))) @unlink(public_path($producto->$columna));
                $producto->$columna = null;
            }
        }

        $this->procesarDocumentos($request, $producto);
        // Actualizar colores
$producto->colores()->sync($request->input('colores', []));
        $producto->save();

        return redirect()->route('productos.edit', $producto->id)->with('success_edit', 'Producto actualizado.');
    }

    // =========================================================================
    // Catálogo público por categoría — carga colores de cada producto
    // =========================================================================
    public function mostrarProductosPorCategoria($id_categoria)
    {
        $productos       = Producto::with(['imagenes', 'colores'])->where('categoria_id', $id_categoria)->get();
        $categorias      = Categoria::all();
        $categoriaNombre = DB::table('categorias')->where('id_categoria', $id_categoria)->value('nombre');
        $colores         = Color::all();

        return view('catalogo', compact('productos', 'categorias', 'categoriaNombre', 'colores'));
    }

    // =========================================================================
    // Vista pública "Ver más" — carga los colores del producto
    // =========================================================================
    public function verMas($id)
    {
        $producto        = Producto::findOrFail($id);
        $nombreCategoria = DB::table('categorias')->where('id_categoria', $producto->categoria_id)->value('nombre');

        $imagenes = DB::table('imagenes_productos')
            ->where('producto_id', $producto->id)
            ->orderBy('orden')
            ->get();

        $descCorta = \Illuminate\Support\Str::limit(strip_tags($producto->descripcion ?? ''), 180);

        // Todos los colores globales registrados en el sistema
        $colores = Color::all();

        return view('vermas', compact('producto', 'nombreCategoria', 'imagenes', 'descCorta', 'colores'));
    }

    // Eliminar producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $imagenes = ImagenProducto::where('producto_id', $producto->id)->get();
        foreach ($imagenes as $imagen) {
            if (file_exists(public_path($imagen->ruta))) @unlink(public_path($imagen->ruta));
            $imagen->delete();
        }

        if ($producto->imagen_url && file_exists(public_path($producto->imagen_url))) {
            @unlink(public_path($producto->imagen_url));
        }

        if ($producto->video_url && file_exists(public_path($producto->video_url))) {
            @unlink(public_path($producto->video_url));
        }

        foreach (['doc1_url', 'doc2_url', 'doc3_url'] as $col) {
            if (!empty($producto->$col) && file_exists(public_path($producto->$col))) {
                @unlink(public_path($producto->$col));
            }
        }

        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function updateVideo(Request $request, $id)
    {
        $request->validate(['video' => 'required|file|mimes:mp4|max:51200']);

        $producto     = Producto::findOrFail($id);
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
       MÉTODOS PRIVADOS
       ========================================================================== */

    private function procesarDocumentos(Request $request, $producto)
    {
        foreach (['doc1', 'doc2', 'doc3'] as $campo) {
            if ($request->hasFile($campo)) {
                $columna = $campo . '_url';

                if (!empty($producto->$columna) && file_exists(public_path($producto->$columna))) {
                    @unlink(public_path($producto->$columna));
                }

                $archivo     = $request->file($campo);
                $ext         = strtolower($archivo->getClientOriginalExtension());
                $nombreBase  = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME));
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
        $rutaVieja  = public_path("images/productos/{$idAnterior}");
        $rutaNueva  = public_path("images/productos/{$nuevoId}");
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
                'video_url'  => DB::raw("REPLACE(video_url,  'images/productos/{$idAnterior}/', 'images/productos/{$nuevoId}/')"),
                'doc1_url'   => DB::raw("REPLACE(doc1_url,   'docs/productos/{$idAnterior}/',   'docs/productos/{$nuevoId}/')"),
                'doc2_url'   => DB::raw("REPLACE(doc2_url,   'docs/productos/{$idAnterior}/',   'docs/productos/{$nuevoId}/')"),
                'doc3_url'   => DB::raw("REPLACE(doc3_url,   'docs/productos/{$idAnterior}/',   'docs/productos/{$nuevoId}/')")
            ]);

        DB::table('imagenes_productos')
            ->where('producto_id', $nuevoId)
            ->update([
                'ruta' => DB::raw("REPLACE(ruta, 'images/productos/{$idAnterior}/', 'images/productos/{$nuevoId}/')")
            ]);
    }
}