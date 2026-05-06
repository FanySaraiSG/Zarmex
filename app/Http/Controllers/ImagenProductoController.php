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
        $numImagenes = ImagenProducto::where('producto_id', $producto_id)->count();
        $nuevoNumero = $numImagenes + 1;

        // Generar el ID de la imagen basado en producto_id + número
        $idImagen = "{$producto_id}_{$nuevoNumero}";

        // MODIFICACIÓN: Usar un nombre único con timestamp para evitar colisiones de archivos
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

        // Ruta donde se guardará la imagen
        $rutaRelativa = "images/productos/$producto_id";
        $rutaAbsoluta = public_path($rutaRelativa);

        // Crear el directorio si no existe
        if (!file_exists($rutaAbsoluta)) {
            mkdir($rutaAbsoluta, 0755, true);
        }

        // Mover la imagen a la carpeta
        $imagen->move($rutaAbsoluta, $nombreImagen);

        // Guardar en la base de datos
        ImagenProducto::create([
            'id' => $idImagen, 
            'producto_id' => $producto_id,
            'ruta' => "$rutaRelativa/$nombreImagen"
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