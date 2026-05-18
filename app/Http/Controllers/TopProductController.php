<?php
namespace App\Http\Controllers;

use App\Models\TopProduct;
use App\Models\Producto;
use Illuminate\Http\Request;

class TopProductController extends Controller
{
    public function index()
    {
        $topProducts = TopProduct::with('product')
            ->orderBy('section')
            ->get()
            ->filter(fn ($tp) => !empty($tp->product));

        $products = Producto::all();
        return view('top_products.index', compact('topProducts', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:productos,id',
            'section' => 'required|string|in:todos,novedades,populares',
        ]);

        $productId = $request->product_id ?: null;
        
        // Si se crea sin producto (desde el botón +Agregar), asignamos un producto por defecto
        // para que el carrusel/home lo muestre.
        if (empty($productId)) {
            $defaultProductId = Producto::query()->value('id');
            if (!$defaultProductId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No existen productos en la base de datos. Crea un producto primero.'
                ], 422);
            }
            $productId = $defaultProductId;
        }

        $topProduct = TopProduct::create([
            'product_id' => $productId,
            'section' => $request->section,
        ]);

        $topProduct->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Registro creado correctamente',
            'data' => $topProduct,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_id' => 'nullable|exists:productos,id',
            'section' => 'required|string|in:todos,novedades,populares',
        ]);

        $topProduct = TopProduct::findOrFail($id);
        $topProduct->product_id = $request->product_id ?: null;
        $topProduct->section = $request->section;
        $topProduct->save();

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'data' => $topProduct
        ]);
    }

    public function destroy(int $id)
    {
        $topProduct = TopProduct::findOrFail($id);
        $topProduct->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registro eliminado correctamente',
        ]);
    }

    public function showTopProducts()
    {
        // Obtener los 5 productos más vendidos
        $topProducts = TopProduct::with('product')->take(5)->get();

        // Pasar los productos a la vista
        return view('admin.reviews.index', compact('topProducts'));
    }

}

