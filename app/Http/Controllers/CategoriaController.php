<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|unique:categorias,id_categoria|string|max:36',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500'
        ]);
        

        Categoria::create([
            'id_categoria' => $request->id_categoria, // Usar el ID proporcionado por el usuario
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:categorias,nombre,' . $categoria->id_categoria . ',id_categoria',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->only(['nombre', 'descripcion']));

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}
