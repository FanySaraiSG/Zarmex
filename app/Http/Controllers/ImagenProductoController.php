<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class ImagenProductoController extends Controller
{
    // Método para mostrar el formulario de creación de una nueva imagen
    public function create($producto_id)
    {
        $producto = Producto::findOrFail($producto_id); // Buscar el producto por ID
        return view('productos.imagen.create', compact('producto')); // Pasar el producto a la vista
    }

    // Método para almacenar una nueva imagen
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id', // Validar que el producto exista
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar la imagen
        ]);

        $producto_id = $request->producto_id;
        $imagen = $request->file('imagen');

        // Contar cuántas imágenes tiene el producto y calcular el próximo número
        $numImagenes = ImagenProducto::where('producto_id', '=', $producto_id)->count();
        $nuevoNumero = $numImagenes + 1; // Empieza en 1 si no hay imágenes previas

        // Generar el ID de la imagen basado en producto_id + número
        $idImagen = "{$producto_id}_{$nuevoNumero}";

        // Usar el nombre original del archivo
        $nombreImagen = $imagen->getClientOriginalName();

        // Ruta donde se guardará la imagen
        $rutaImagen = public_path("images/productos/$producto_id");

        // Crear el directorio si no existe
        if (!file_exists($rutaImagen)) {
            mkdir($rutaImagen, 0755, true); // Crear la carpeta si no existe
        }

        // Mover la imagen a la carpeta
        $imagen->move($rutaImagen, $nombreImagen);

        // Guardar en la base de datos
        ImagenProducto::create([
            'id' => $idImagen, // ID personalizado
            'producto_id' => $producto_id,
            'ruta' => "images/productos/$producto_id/$nombreImagen"
        ]);

        // Redirigir a la vista de índice de imágenes del producto
        return redirect()->route('productos.imagenes.show', $producto_id)->with('success', 'Imagen subida correctamente.');
    }

    // Método para mostrar el formulario de edición de una imagen
    public function edit($id)
    {
        $imagen = ImagenProducto::findOrFail($id); // Buscar la imagen por ID
        return view('productos.imagen.edit', compact('imagen')); // Muestra la vista para editar la imagen
    }

    // Método para actualizar una imagen existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar la nueva imagen
        ]);

        $imagenProducto = ImagenProducto::findOrFail($id); // Buscar la imagen por ID
        $producto_id = $imagenProducto->producto_id; // Obtener el ID del producto al que pertenece

        // Obtener la nueva imagen
        $nuevaImagen = $request->file('imagen');

        // Ruta donde se almacenará la imagen
        $rutaImagen = public_path("images/productos/$producto_id");

        // Crear el directorio si no existe
        if (!file_exists($rutaImagen)) {
            mkdir($rutaImagen, 0755, true); // Crear la carpeta si no existe
        }

        // Eliminar la imagen anterior si existe
        if (file_exists(public_path($imagenProducto->ruta))) {
            unlink(public_path($imagenProducto->ruta)); // Eliminar la imagen anterior
        }

        // Usar el mismo nombre de archivo que la imagen anterior
        $nombreImagen = basename($imagenProducto->ruta); // Obtener el nombre de la imagen anterior

        // Mover la nueva imagen a la carpeta con el nombre anterior
        $nuevaImagen->move($rutaImagen, $nombreImagen);

        // Actualizar la ruta de la imagen en la base de datos
        $imagenProducto->ruta = "images/productos/$producto_id/$nombreImagen"; // Actualizar la ruta
        $imagenProducto->save(); // Guardar los cambios

        return redirect()->route('productos.imagenes.show', $producto_id)->with('success', 'Imagen actualizada correctamente.');
    }

    // Método para eliminar una imagen existente
    public function destroy($id)
    {
        $imagenProducto = ImagenProducto::findOrFail($id); // Buscar la imagen por ID
        $rutaImagen = public_path($imagenProducto->ruta);

        // Eliminar el archivo de la carpeta
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen); // Eliminar el archivo
        }

        // Eliminar el registro de la base de datos
        $imagenProducto->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }

    // Método para mostrar las imágenes de un producto en la vista de índice
    public function show($id)
    {
        // Buscar el producto por su ID
        $producto = Producto::findOrFail($id);

        // Obtener las imágenes relacionadas
        $imagenes = $producto->imagenes; // Asegúrate de tener esta relación en tu modelo Producto
        // Retornar una vista con el producto y las imágenes
        return view('productos.imagen.index', compact('producto', 'imagenes'));
    }
}
