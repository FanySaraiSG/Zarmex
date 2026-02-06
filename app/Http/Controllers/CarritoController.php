<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Método para mostrar el carrito
    public function mostrarCarrito()
    {
        $id_usuario = Auth::id();
        if (!$id_usuario) {
            return redirect('/login')->with('error', 'Debes iniciar sesión para ver el carrito.');
        }

        // Obtiene los elementos del carrito, incluso si está vacío
        $carrito = Carrito::with(['producto', 'color'])->where('id_usuario', $id_usuario)->get();

        // Asegúrate de pasar $carrito a la vista
        return view('carrito', compact('carrito'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'id_color' => 'required|exists:colors,id_color',
            'cantidad' => 'required|integer|min:1',
        ]);
    
        $id_usuario = Auth::id();
        if (!$id_usuario) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para agregar productos al carrito.');
        }
    
        $id_producto = $request->input('id_producto');
        $id_color = $request->input('id_color');
        $cantidad = $request->input('cantidad');
    
        $producto = Producto::find($id_producto);
        if (!$producto) {
            return redirect()->back()->with('error', 'El producto no existe.');
        }
    
        $precioTotal = $producto->precio * $cantidad;
    
        Carrito::create([
            'id_usuario' => $id_usuario,
            'id_producto' => $id_producto,
            'id_color' => $id_color,
            'cantidad' => $cantidad,
            'precio' => $precioTotal,
        ]);
    
        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }
    


    // Método para obtener los productos del carrito de un usuario
    public function obtener()
    {
        $id_usuario = Auth::id(); // Obtener el ID del usuario autenticado
        if (!$id_usuario) {
            return response()->json(['error' => 'Debes iniciar sesión para ver el carrito.'], 401);
        }

        $carrito = Carrito::with(['usuario', 'producto', 'color'])
            ->where('id_usuario', $id_usuario)
            ->get();

        return response()->json($carrito); // Retornar los productos del carrito
    }

    // Método para actualizar la cantidad de un producto en el carrito
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $item = Carrito::find($id);
        if (!$item) {
            return response()->json(['error' => 'Producto no encontrado en el carrito.'], 404);
        }

        $item->cantidad = $request->cantidad;
        $item->precio = $item->producto->precio * $item->cantidad; // Actualiza el precio basado en la nueva cantidad
        $item->save();

        return response()->json(['success' => 'Cantidad actualizada correctamente.', 'precio' => $item->precio]);
    }

    // Método para eliminar un producto del carrito
    public function eliminar($id)
    {
        $carrito = Carrito::where('id', $id)->delete();

        if ($carrito) {
            return response()->json(['success' => 'Producto eliminado del carrito.'], 200);
        } else {
            return response()->json(['error' => 'Error al eliminar el producto.'], 500);
        }
    }
}