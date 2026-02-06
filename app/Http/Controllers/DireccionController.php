<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DireccionController extends Controller
{
    /**
     * Muestra las direcciones del usuario autenticado.
     */
    public function index()
    {
        $direcciones = Direccion::where('user_id', Auth::id())->get();

        return view('direcciones.index', compact('direcciones'));
    }


    /**
     * Muestra el formulario para crear una nueva dirección.
     */
    public function create()
    {
        return view('direcciones.create');
    }

    /**
     * Almacena una nueva dirección en la base de datos.
     */
    public function store(Request $request)
{
    $request->validate([
        'tipo' => 'required',
        'pais' => 'required',
        'estado' => 'required',
        'ciudad' => 'required',
        'codigo_postal' => 'required',
        'calle' => 'required',
        'numero_exterior' => 'required',
        'telefono' => 'required',
    ]);

    Direccion::create([
        'user_id' => Auth::id(), // Agregar el usuario autenticado
        'tipo' => $request->tipo,
        'pais' => $request->pais,
        'estado' => $request->estado_nombre,
        'ciudad' => $request->ciudad_nombre,
        'codigo_postal' => $request->codigo_postal,
        'calle' => $request->calle,
        'numero_exterior' => $request->numero_exterior,
        'numero_interior' => $request->numero_interior,
        'telefono' => $request->telefono,
    ]);

    return redirect()->route('direcciones.index')->with('success', 'Dirección guardada correctamente');
}
    
    // Función para obtener el nombre de un lugar desde GeoNames
    private function obtenerNombreGeoname($geonameId)
    {
        $usuarioGeoNames = 'coral220422';
        $response = Http::get("http://api.geonames.org/getJSON", [
            'geonameId' => $geonameId,
            'username' => $usuarioGeoNames
        ]);
    
        if ($response->successful()) {
            $data = $response->json();
            return $data['name'] ?? 'Desconocido';
        }
    
        return 'Desconocido';
    }


    /**
     * Muestra el formulario para editar una dirección.
     */
    public function edit($id)
    {
        $direccion = Direccion::where('id_direccion', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('direcciones.edit', compact('direccion'));
    }

    /**
     * Actualiza una dirección existente.
     */
    public function update(Request $request, $id)
    {
        $direccion = Direccion::where('id_direccion', $id)->where('user_id', Auth::id())->firstOrFail();
    
        $request->validate([
            'tipo' => 'required|in:casa,trabajo,oficina',
            'telefono' => 'required|string|min:10|max:20',
            'pais' => 'required|string',
            'estado' => 'required|string',
            'ciudad' => 'required|string',
            'codigo_postal' => 'required|string|max:10',
            'calle' => 'required|string',
            'numero_exterior' => 'required|string|max:10',
            'numero_interior' => 'nullable|string|max:10',
            'estado_nombre' => 'required|string',
            'ciudad_nombre' => 'required|string',
        ]);
    
        $direccion->update([
            'tipo' => $request->tipo,
            'telefono' => $request->telefono,
            'pais' => $request->pais,
            'estado' => $request->estado_nombre,  // Guardando el nombre del estado
            'ciudad' => $request->ciudad_nombre,  // Guardando el nombre de la ciudad
            'calle' => $request->calle,
            'numero_exterior' => $request->numero_exterior,
            'numero_interior' => $request->numero_interior,
            'codigo_postal' => $request->codigo_postal,
        ]);
    
        return redirect()->route('direcciones.index')->with('success', 'Dirección actualizada correctamente.');
    }


    /**
     * Elimina una dirección.
     */
    public function destroy($id)
    {
        $direccion = Direccion::where('id_direccion', $id)->where('user_id', Auth::id())->firstOrFail();
        $direccion->delete();

        return redirect()->route('direcciones.index')->with('success', 'Dirección eliminada correctamente.');
    }
}