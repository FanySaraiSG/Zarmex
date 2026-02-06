<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\ImagenProducto;
use App\Models\Medida;
class ProductoController extends Controller
{
    public function index($categoria = null)
    {

        $categorias = Categoria::all();

        if ($categoria) {
            $categoriaNombre = DB::table('categorias')->where('id_categoria', $categoria)->value('nombre');
            $productos = Producto::where('categoria_id', $categoria)->paginate(6); // Aplicamos paginación
        } else {
            $categoriaNombre = 'Todos los productos';
            $productos = Producto::paginate(6); // Aplicamos paginación
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
        // Validación de datos
        $request->validate([
            'id' => 'required|unique:productos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'imagen_url' => 'nullable|image|max:2048', // Máximo 2MB
            'largo' => 'required|numeric|min:0',
            'ancho' => 'required|numeric|min:0',
            'altura' => 'required|numeric|min:0',
        ]);

        // Obtener el ID del producto
        $idProducto = $request->input('id');

        // Verificar que el ID no esté vacío
        if (empty($idProducto)) {
            return redirect()->back()->withErrors(['id' => 'El ID del producto no puede estar vacío.'])->withInput();
        }

        // Ruta de la carpeta donde se guardarán las imágenes
        $rutaProducto = public_path("images/productos/{$idProducto}");

        // Crear la carpeta del producto si no existe
        if (!file_exists($rutaProducto)) {
            mkdir($rutaProducto, 0755, true); // Crea la carpeta del producto con permisos 755
        }

        // Manejo de la imagen
        $imagenPath = null;
        if ($request->hasFile('imagen_url') && $request->file('imagen_url')->isValid()) {
            // Obtener la extensión de la imagen
            $extension = $request->file('imagen_url')->getClientOriginalExtension();

            // Definir el nombre de la imagen como "principal" con la extensión correspondiente
            $nombreImagen = "principal.{$extension}";

            // Mover la imagen a la carpeta correspondiente
            $request->file('imagen_url')->move($rutaProducto, $nombreImagen);

            // Guardar la ruta relativa para la base de datos
            $imagenPath = "images/productos/{$idProducto}/{$nombreImagen}";
        } else {
            return redirect()->back()->withErrors(['imagen_url' => 'La imagen no es válida.'])->withInput();
        }

        // Crear el producto
        $producto = Producto::create([
            'id' => $idProducto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'imagen_url' => $imagenPath,
        ]);

        // Crear la medida vinculada
        Medida::create([
            'producto_id' => $producto->id,
            'largo' => $request->largo,
            'ancho' => $request->ancho,
            'altura' => $request->altura,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function show($id)
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
        return view('productos.edit', compact('producto', 'categorias'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|unique:productos,id,' . $id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id_categoria',
            'imagen_url' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'largo' => 'required|numeric|min:0',
            'ancho' => 'required|numeric|min:0',
            'altura' => 'required|numeric|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $nuevo_id = $request->input('id'); // Nuevo ID ingresado en el formulario

        // Verificar si el ID cambió
        if ($producto->id !== $nuevo_id) {
            DB::beginTransaction();
            try {
                // Deshabilitar verificación de claves foráneas para evitar errores
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                // Actualizar todas las imágenes del producto con el nuevo ID
                ImagenProducto::where('producto_id', $producto->id)->update(['producto_id' => $nuevo_id]);

                // Actualizar el ID del producto en `productos`
                DB::table('productos')->where('id', $producto->id)->update(['id' => $nuevo_id]);

                // Habilitar verificación de claves foráneas después de la actualización
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Error al actualizar el producto: ' . $e->getMessage()]);
            }
        }

        // Actualizar otros datos del producto
        $datos = $request->except(['imagen_url', 'id']);
        $producto->update($datos);

        // Manejo de imagen
        if ($request->hasFile('imagen_url')) {
            $rutaImagenAnterior = public_path($producto->imagen_url);
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }

            // Guardar imagen con el nombre 'principal'
            $extension = $request->file('imagen_url')->getClientOriginalExtension();
            $nombreImagen = 'principal.' . $extension; // Fijo el nombre a 'principal'
            $rutaProducto = public_path("images/productos/{$producto->id}");

            // Crear la carpeta si no existe
            if (!file_exists($rutaProducto)) {
                mkdir($rutaProducto, 0755, true);
            }

            // Mover la imagen a la carpeta correspondiente
            $request->file('imagen_url')->move($rutaProducto, $nombreImagen);
            $producto->update(['imagen_url' => "images/productos/{$producto->id}/{$nombreImagen}"]);
        }

        // Actualizar medidas
        $medidas = Medida::where('producto_id', $producto->id)->first();
        if ($medidas) {
            $medidas->update([
                'largo' => $request->largo,
                'ancho' => $request->ancho,
                'altura' => $request->altura,
            ]);
        } else {
            // Si no existe la medida, crear una nueva
            Medida::create([
                'producto_id' => $producto->id,
                'largo' => $request->largo,
                'ancho' => $request->ancho,
                'altura' => $request->altura,
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }


    public function mostrarProductosPorCategoria($id_categoria)
    {
        $productos = Producto::where('categoria_id', $id_categoria)->paginate(8); // Usar paginate correctamente
        $categorias = Categoria::all();
        $categoriaNombre = DB::table('categorias')->where('id_categoria', $id_categoria)->value('nombre');

        return view('catalogo', compact('productos', 'categorias', 'categoriaNombre'));
    }
    public function verMas($id)
    {
        $producto = Producto::with('medida')->find($id); // Buscar el producto por ID y cargar medidas

        if (!$producto) {
            abort(404); // Si no se encuentra el producto, lanzar un error 404
        }

        // Obtener el nombre de la categoría del producto
        $nombreCategoria = DB::table('categorias')
            ->where('id_categoria', $producto->categoria_id)
            ->value('nombre');

        // Obtener todas las imágenes asociadas al producto
        $imagenes = $producto->imagenes; // Asumiendo que tienes la relación definida en el modelo Producto

        $colors = Color::all(); // Obtener todos los colores (si es necesario)

        // Pasar las medidas a la vista
        $medidas = $producto->medida; // Obtener medidas del producto

        return view('vermas', compact('producto', 'nombreCategoria', 'imagenes', 'colors', 'medidas'));
    }


    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id');
    }
    public function buscar(Request $request)
    {
        $query = $request->input('query');  // Obtener el término de búsqueda

        // Buscar productos por ID o nombre
        $productos = Producto::where('id', 'like', "%{$query}%")
            ->orWhere('nombre', 'like', "%{$query}%")
            ->get();

        // Devolver los resultados como JSON
        return response()->json($productos);
    }
    public function destroy($id)
    {
        // Encuentra el producto por ID
        $producto = Producto::findOrFail($id);

        // Eliminar las imágenes asociadas en la tabla ImagenProducto
        $imagenes = ImagenProducto::where('producto_id', $producto->id)->get();

        foreach ($imagenes as $imagen) {
            // Aquí asumimos que tienes un campo 'ruta' en la tabla ImagenProducto
            $rutaImagen = public_path($imagen->ruta); // Ajusta 'ruta' según el nombre del campo
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen); // Eliminar archivo físico
            }
            $imagen->delete(); // Eliminar registro de la base de datos
        }

        // Eliminar las medidas asociadas
        Medida::where('producto_id', $producto->id)->delete();

        // Eliminar la imagen principal del producto
        $rutaPrincipal = public_path($producto->imagen_url);
        if (file_exists($rutaPrincipal)) {
            unlink($rutaPrincipal); // Eliminar archivo físico
        }

        // Eliminar el producto
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function mostrarResultadosBusqueda(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $resultados = Producto::where('nombre', 'like', '%' . $query . '%')
                                ->orWhere('descripcion', 'like', '%' . $query . '%')
                                ->get();
        } else {
            $resultados = collect(); // Si no hay consulta, devuelve una colección vacía
        }

        return view('busqueda', ['resultados' => $resultados, 'query' => $query]);
    }

}