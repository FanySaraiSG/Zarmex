<?php
namespace App\Http\Controllers;

use App\Models\TopProduct;
use App\Models\Producto;
use Illuminate\Http\Request;

class TopProductController extends Controller
{
    public function index()
    {
        $topProducts = TopProduct::with('product')->get();
        $products = Producto::all();
        return view('top_products.index', compact('topProducts', 'products'));
    }

    public function update(Request $request, TopProduct $topProduct)
    {
        $request->validate([
            'product_id' => 'nullable|string|exists:productos,id',
        ]);

        $topProduct->update(['product_id' => $request->product_id]);

        return redirect()->route('top-products.index')->with('success', 'Producto actualizado.');
    }

    public function showTopProducts()
    {
        // Obtener los 5 productos más vendidos
        $topProducts = TopProduct::with('product')->take(5)->get();

        // Pasar los productos a la vista
        return view('top_products', compact('topProducts'));
    }

}
