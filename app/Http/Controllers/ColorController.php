<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('colors.index', compact('colors'));
    }

    public function create()
    {
        return view('colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_color' => 'required|string|size:6|unique:colors,id_color', // Acepta sólo códigos Hex sin '#'
            'nombre' => 'required|string|max:255'
        ]);

        $colorData = $request->all();
        $colorData['id_color'] = ltrim($request->id_color, '#'); // Elimina el '#'

        Color::create($colorData);

        return redirect()->route('colors.index')->with('success', 'Color creado exitosamente.');
    }

    public function destroy($id_color)
    {
        $color = Color::findOrFail($id_color); // No se agrega el '#'
        $color->delete();

        return redirect()->route('colors.index')->with('success', 'Color eliminado correctamente.');
    }


    public function edit($id_color)
{
    $color = Color::findOrFail($id_color); // Buscar usando 'id_color'
    return view('colors.edit', compact('color'));
}

public function update(Request $request, $id_color)
{
    $request->validate([
        'id_color' => 'required|string|size:6|unique:colors,id_color,' . $id_color . ',id_color', // Sin '#'
        'nombre' => 'required|string|max:255'
    ]);

    $color = Color::findOrFail($id_color);
    $color->update([
        'id_color' => ltrim($request->id_color, '#'), // Elimina '#' por si acaso
        'nombre' => $request->nombre,
    ]);

    return redirect()->route('colors.index')->with('success', 'Color actualizado exitosamente.');
}

}
