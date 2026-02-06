<?php

namespace App\Http\Controllers;

use App\Models\Medida;
use Illuminate\Http\Request;

class MedidaController extends Controller
{
    // Listar todas las medidas
    public function index()
    {
        return response()->json(Medida::all());
    }

    // Mostrar una medida específica
    public function show($id)
    {
        $medida = Medida::findOrFail($id);
        return response()->json($medida);
    }

    // Crear una nueva medida (solo si el producto no tiene una ya)
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'largo' => 'required|numeric',
            'ancho' => 'required|numeric',
            'altura' => 'required|numeric',
        ]);

        // Verificar si ya existe una medida para este producto
        if (Medida::where('producto_id', $request->producto_id)->exists()) {
            return response()->json(['error' => 'Este producto ya tiene una medida registrada.'], 409);
        }

        $medida = Medida::create($request->all());

        return response()->json($medida, 201);
    }

    // Actualizar una medida existente
    public function update(Request $request, $id)
    {
        $medida = Medida::findOrFail($id);

        $request->validate([
            'largo' => 'sometimes|numeric',
            'ancho' => 'sometimes|numeric',
            'altura' => 'sometimes|numeric',
        ]);

        $medida->update($request->all());

        return response()->json($medida);
    }

    // Eliminar una medida
    public function destroy($id)
    {
        $medida = Medida::findOrFail($id);
        $medida->delete();

        return response()->json(['message' => 'Medida eliminada correctamente.']);
    }
}
