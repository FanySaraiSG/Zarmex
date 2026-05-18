<?php

/**
 * Nota: Este controller puede generar falsos positivos en Intelephense por stubs/typing.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Color;
use App\Models\ImagenProducto;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductoController extends Controller
{
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

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:productos,id',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'imagen_url' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'doc1' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        $idProducto = $request->input('id');

        if (empty($idProducto)) {
            return redirect()->back()
                ->withErrors(['id' => 'El ID del producto no puede estar vacío.'])
                ->withInput();
        }

        $nombreAuto = 'Producto ' . $idProducto;

        $rutaProducto = public_path("images/productos/{$idProducto}");
        if (!file_exists($rutaProducto)) {
            mkdir($rutaProducto, 0755, true);
        }

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

        $producto = Producto::create([
            'id' => $idProducto,
            'nombre' => $nombreAuto,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'imagen_url' => $imagenPath,
        ]);

        foreach (['doc1', 'doc2', 'doc3'] as $campo) {
            if ($request->hasFile($campo)) {
                $columna = $campo . '_url';

                $archivo = $request->file($campo);
                $ext = strtolower($archivo->getClientOriginalExtension());
                $nombreBase = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME));
                $nombreFinal = $nombreBase . '_' . time() . '.' . $ext;

                $destino = public_path("docs/productos/{$producto->id}");
                if (!file_exists($destino)) {
                    mkdir($destino, 0755, true);
                }

                $archivo->move($destino, $nombreFinal);

                $producto->$columna = "docs/productos/{$producto->id}/{$nombreFinal}";
            }
        }

        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

public function show(int $id)
    {

        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id)
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

public function update(Request $request, $id)
    {

        $request->validate([
            'id' => 'required|unique:productos,id,' . $id,
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id_categoria',

            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            'imagenes'   => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            'doc1' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc2' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
            'doc3' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        $producto = Producto::findOrFail($id);
        $idAnterior = $producto->id;
        $nuevoId = $request->input('id');

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

                return back()->withErrors([
                    'error' => 'Error al actualizar el producto: ' . $e->getMessage()
                ]);
            }

            $rutaVieja = public_path("images/productos/{$idAnterior}");
            $rutaNueva = public_path("images/productos/{$nuevoId}");

            if (file_exists($rutaVieja) && !file_exists($rutaNueva)) {
                @rename($rutaVieja, $rutaNueva);
            }

            $docsViejos = public_path("docs/productos/{$idAnterior}");
            $docsNuevos = public_path("docs/productos/{$nuevoId}");

            if (file_exists($docsViejos) && !file_exists($docsNuevos)) {
                @rename($docsViejos, $docsNuevos);
            }

            DB::table('productos')
                ->where('id', $nuevoId)
                ->update([
                    'imagen_url' => DB::raw("REPLACE(imagen_url, 'images/productos/{$idAnterior}/', 'images/productos/{$nuevoId}/')"),
                    'doc1_url'   => DB::raw("REPLACE(doc1_url, 'docs/productos/{$idAnterior}/', 'docs/productos/{$nuevoId}/')"),
                    'doc2_url'   => DB::raw("REPLACE(doc2_url, 'docs/productos/{$idAnterior}/', 'docs/productos/{$nuevoId}/')"),
                    'doc3_url'   => DB::raw("REPLACE(doc3_url, 'docs/productos/{$idAnterior}/', 'docs/productos/{$nuevoId}/')")
                ]);

            DB::table('imagen_productos')
                ->where('producto_id', $nuevoId)
                ->update([
                    'ruta' => DB::raw("REPLACE(ruta, 'images/productos/{$idAnterior}/', 'images/productos/{$nuevoId}/')")
                ]);

            $producto = Producto::findOrFail($nuevoId);
        }

        $datos = $request->except([
            'imagen_url', 'imagenes', 'id', 'nombre',
            'doc1', 'doc2', 'doc3'
        ]);

        $producto->update($datos);

        $rutaProducto = public_path("images/productos/{$producto->id}");
        if (!file_exists($rutaProducto)) {
            mkdir($rutaProducto, 0755, true);
        }

        if ($request->hasFile('imagen_url')) {
            foreach (glob($rutaProducto . "/principal.*") as $archivo) {
                @unlink($archivo);
            }

            $nombreImagen = 'principal.jpg';
            $rutaImagenFisica = $rutaProducto . '/' . $nombreImagen;

            $manager = new ImageManager(new Driver());

            $imagenProcesada = $manager->read($request->file('imagen_url'))
                ->cover(1200, 1200)
                ->toJpeg(85);

            file_put_contents($rutaImagenFisica, (string) $imagenProcesada);

            $producto->imagen_url = "images/productos/{$producto->id}/{$nombreImagen}";
        }

        if ($request->hasFile('imagenes')) {
            $ultimoOrden = (int) ImagenProducto::where('producto_id', $producto->id)->max('orden');
            $orden = $ultimoOrden + 1;

            foreach ($request->file('imagenes') as $img) {
                $nombre = "extra_" . time() . "_" . uniqid() . ".jpg";
                $rutaExtraFisica = $rutaProducto . '/' . $nombre;

                $manager = new ImageManager(new Driver());

                $imagenExtraProcesada = $manager->read($img)
                    ->cover(1200, 1200)
                    ->toJpeg(85);

                file_put_contents($rutaExtraFisica, (string) $imagenExtraProcesada);

                ImagenProducto::create([
                    'producto_id' => $producto->id,
                    'ruta'        => "images/productos/{$producto->id}/{$nombre}",
                    'orden'       => $orden,
                ]);

                $orden++;
            }
        }
        //  ELIMINAR DOCUMENTOS SI SE MARCA EL CHECKBOX
foreach (['doc1', 'doc2', 'doc3'] as $campo) {
    $checkboxEliminar = 'eliminar_' . $campo;
    $columna = $campo . '_url';

    if ($request->has($checkboxEliminar) && !empty($producto->$columna)) {
        $rutaAnterior = public_path($producto->$columna);

        if (file_exists($rutaAnterior)) {
            @unlink($rutaAnterior);
        }

        $producto->$columna = null;
    }
}

        foreach (['doc1', 'doc2', 'doc3'] as $campo) {
            if ($request->hasFile($campo)) {
                $columna = $campo . '_url';

                if (!empty($producto->$columna)) {
                    $rutaAnterior = public_path($producto->$columna);
                    if (file_exists($rutaAnterior)) {
                        @unlink($rutaAnterior);
                    }
                }

                $archivo = $request->file($campo);
                $ext = strtolower($archivo->getClientOriginalExtension());
                $nombreBase = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME));
                $nombreFinal = $nombreBase . '_' . time() . '.' . $ext;

                $destino = public_path("docs/productos/{$producto->id}");
                if (!file_exists($destino)) {
                    mkdir($destino, 0755, true);
                }

                $archivo->move($destino, $nombreFinal);

                $producto->$columna = "docs/productos/{$producto->id}/{$nombreFinal}";
            }
        }

        $producto->save();

        return redirect()->route('productos.edit', $producto->id)
            ->with('success_edit', 'Producto actualizado correctamente.');
    }

    public function mostrarProductosPorCategoria($id_categoria)
    {
        $productos = Producto::where('categoria_id', $id_categoria)->paginate(8);
        $categorias = Categoria::all();
        $categoriaNombre = DB::table('categorias')
            ->where('id_categoria', $id_categoria)
            ->value('nombre');

        return view('catalogo', compact('productos', 'categorias', 'categoriaNombre'));
    }

    public function verMas($id)
    {
        $producto = Producto::findOrFail($id);

        $nombreCategoria = DB::table('categorias')
            ->where('id_categoria', $producto->categoria_id)
            ->value('nombre');

        $imagenes = ImagenProducto::where('producto_id', $producto->id)
            ->orderBy('orden')
            ->get();

        $colors = Color::all();

        return view('vermas', compact('producto', 'nombreCategoria', 'imagenes', 'colors'));
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $productos = Producto::where('id', 'like', "%{$query}%")
            ->orWhere('descripcion', 'like', "%{$query}%")
            ->get();

        return response()->json($productos);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $imagenes = ImagenProducto::where('producto_id', $producto->id)->get();
        foreach ($imagenes as $imagen) {
            $rutaImagen = public_path($imagen->ruta);
            if (file_exists($rutaImagen)) {
                @unlink($rutaImagen);
            }
            $imagen->delete();
        }

        if ($producto->imagen_url) {
            $rutaPrincipal = public_path($producto->imagen_url);
            if (file_exists($rutaPrincipal)) {
                @unlink($rutaPrincipal);
            }
        }

        foreach (['doc1_url', 'doc2_url', 'doc3_url'] as $col) {
            if (!empty($producto->$col)) {
                $ruta = public_path($producto->$col);
                if (file_exists($ruta)) {
                    @unlink($ruta);
                }
            }
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

   public function mostrarResultadosBusqueda(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $resultados = Producto::where('id', 'like', '%' . $query . '%')
                ->orWhere('descripcion', 'like', '%' . $query . '%')
                ->get();
        } else {
            $resultados = collect();
        }

        return view('busqueda', ['resultados' => $resultados, 'query' => $query]);
    }

    public function updateVideo(Request $request, $id)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4|max:51200',
        ]);

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

}