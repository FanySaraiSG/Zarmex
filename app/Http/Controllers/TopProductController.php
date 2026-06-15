<?php

namespace App\Http\Controllers;

use App\Models\TopProduct;
use App\Models\Producto;
use Illuminate\Http\Request;

class TopProductController extends Controller
{
    /**
     * Palabras reservadas que no pueden usarse como nombre de sección.
     * "todos" es el comodín del filtro del carrusel público.
     */
    private const SECCIONES_RESERVADAS = ['todos'];

    private function esSectionReservada(string $section): bool
    {
        return in_array(strtolower(trim($section)), self::SECCIONES_RESERVADAS, true);
    }

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
            'section'    => 'required|string|max:100',
        ]);

        if ($this->esSectionReservada($request->section)) {
            return response()->json([
                'success' => false,
                'message' => '"' . $request->section . '" es una palabra reservada y no puede usarse como nombre de sección.',
            ], 422);
        }

        $productId = $request->product_id ?: null;

        if (empty($productId)) {
            $defaultProductId = Producto::query()->value('id');
            if (!$defaultProductId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No existen productos en la base de datos. Crea un producto primero.',
                ], 422);
            }
            $productId = $defaultProductId;
        }

        $topProduct = TopProduct::create([
            'product_id' => $productId,
            'section'    => strtolower(trim($request->section)),
        ]);

        $topProduct->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Registro creado correctamente',
            'data'    => $topProduct,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_id' => 'nullable|exists:productos,id',
            'section'    => 'required|string|max:100',
        ]);

        if ($this->esSectionReservada($request->section)) {
            return response()->json([
                'success' => false,
                'message' => '"' . $request->section . '" es una palabra reservada y no puede usarse como nombre de sección.',
            ], 422);
        }

        $topProduct = TopProduct::findOrFail($id);
        $topProduct->product_id = $request->product_id ?: null;
        $topProduct->section    = strtolower(trim($request->section));
        $topProduct->save();

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'data'    => $topProduct,
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
        $topProducts = TopProduct::with('product')->take(5)->get();
        return view('admin.reviews.index', compact('topProducts'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orden'   => 'required|array',
            'orden.*' => 'integer|exists:top_products,id',
        ]);

        foreach ($request->orden as $posicion => $id) {
            TopProduct::where('id', $id)->update(['orden' => $posicion]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Actualiza el nombre de una sección en cascada en la base de datos.
     */
    public function renameSection(Request $request)
    {
        $request->validate([
            'old_section' => 'required|string',
            'new_section' => 'required|string|max:100',
        ]);

        if ($this->esSectionReservada($request->new_section)) {
            return response()->json([
                'success' => false,
                'message' => '"' . $request->new_section . '" es una palabra reservada y no puede usarse como nombre de sección.',
            ], 422);
        }

        $oldSection = $request->old_section;
        $newSection = strtolower(trim($request->new_section));

        $afectados = TopProduct::where('section', $oldSection)
            ->update(['section' => $newSection]);

        return response()->json([
            'success' => true,
            'message' => "Se actualizó la sección a '{$newSection}'. {$afectados} productos modificados.",
        ]);
    }

    /**
     * Verifica cuántos productos pertenecen a una sección antes de proceder a borrarla.
     */
    public function checkSectionProducts(string $section)
    {
        $count = TopProduct::where('section', $section)->count();

        return response()->json([
            'success' => true,
            'count'   => $count,
        ]);
    }

    /**
     * Elimina una sección completa (remueve todos los registros asociados).
     */
    public function destroySection(string $section)
    {
        TopProduct::where('section', $section)->delete();

        return response()->json([
            'success' => true,
            'message' => "La sección '{$section}' fue eliminada correctamente.",
        ]);
    }
}