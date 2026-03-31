<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Categoria; // Importa el modelo Categoria
use App\Models\Producto; // Importa el modelo Producto
use Illuminate\Support\Facades\Auth;


class MantenimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Mantenimiento::query();

        // Filtrado por status (si existe)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Paginado de 8 registros por página
        $mantenimientos = $query->paginate(8);

        // Opcional: Pasar los estados a la vista para que los pueda usar el filtro
        $statuses = ['En revisión', 'En procedimiento', 'En camino', 'Finalizado'];

        return view('mantenimientos.index', compact('mantenimientos', 'statuses'));
    }



    public function create()
    {
        $categorias = Categoria::all();
        return view('mantenimientos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'ocupacion' => 'required|string|max:255',
            'tipo_maquina' => 'required|string|max:255',
            'codigo_equipo' => 'required|exists:productos,id',
            'descripcion' => 'required|string',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'numero_celular' => 'nullable|string|max:255',
            'correo_electronico' => 'nullable|email|max:255', // Permitir nulo si no está autenticado
        ]);

        try {
            // Si el usuario está autenticado, reemplazamos el correo electrónico con el del usuario autenticado
            if (auth()->check()) {
                $validatedData['correo_electronico'] = auth()->user()->email;
            }

            $mantenimiento = Mantenimiento::create($validatedData);
            return redirect()->route('dashboard')->with('success', '¡Solicitud de mantenimiento enviada con éxito!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar la solicitud de mantenimiento: ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        return view('mantenimientos.edit', compact('mantenimiento'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'ocupacion' => 'required|string|max:255',
            'tipo_maquina' => 'required|string|max:255',
            'codigo_equipo' => 'required|exists:productos,id', // Verifica si el producto existe
            'descripcion' => 'required|string',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
        ]);

        try {
            $mantenimiento = Mantenimiento::findOrFail($id);
            $mantenimiento->update($validatedData);
            return redirect()->route('mantenimientos.index')->with('success', '¡Mantenimiento actualizado con éxito!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el mantenimiento: ' . $e->getMessage());
        }
    }

    public function destroy($id)
{
    $mantenimiento = Mantenimiento::findOrFail($id);
    $mantenimiento->delete();

    return redirect()->route('mantenimientos.index')
        ->with('success', 'Mantenimiento eliminado correctamente');
}
    public function updateStatus(Request $request, $id)
    {
        // Encuentra el mantenimiento por su id
        $mantenimiento = Mantenimiento::findOrFail($id);

        // Valida el status, si es necesario
        $validatedData = $request->validate([
            'status' => 'required|in:En revisión,En procedimiento,En camino,Finalizado',
        ]);

        // Actualiza el estado
        $mantenimiento->status = $validatedData['status'];
        $mantenimiento->save();

        // Redirige con un mensaje de éxito
        return redirect()->route('mantenimientos.index')->with('success', 'Estado actualizado con éxito');
    }

    public function eliminar($id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (!$mantenimiento) {
            return redirect()->route('mantenimientos.index')->with('error', 'Mantenimiento no encontrado');
        }

        // Eliminar mantenimiento
        $mantenimiento->delete();

        // Obtener el id del usuario autenticado
        $userId = Auth::id();

        // Redirigir al usuario con su id
        return redirect()->route('solicitudes.usuario', ['id' => $userId])
            ->with('success', 'Mantenimiento eliminado correctamente');
    }
    
}