<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Reporte::query();
    
        // Aplicar filtros según el valor seleccionado
        if ($request->has('filtro')) {
            if ($request->filtro == 'soporte' || $request->filtro == 'queja') {
                $query->where('tipo_reporte', $request->filtro);
            } elseif ($request->filtro == 'no_asignado') {
                $query->whereNull('id_empleado'); // Filtra los reportes sin empleado asignado
            } elseif ($request->filtro == 'pendiente') {
                $query->where('estado', 'pendiente'); // Filtra los reportes con estado "pendiente"
            }
        }
    
        $reportes = $query->get();
    
        return view('reportes.index', compact('reportes'));
    }
    
    

    // Mostrar el formulario de creación de reporte
    public function create()
    {
        return view('reportes.create');
    }

    // Guardar un nuevo reporte en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'tipo_reporte' => 'required|in:soporte,queja',
            'descripcion' => 'required',
            'estado' => 'nullable|in:pendiente,en proceso,resuelto',
            'id_empleado' => 'nullable|exists:employees,id_empleado'
        ]);

        Reporte::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Se ha enviado con éxito tu reporte. En un lapso de 72 horas, el equipo de soporte se comunicará contigo por correo electrónico.');
    }

    // Mostrar un reporte específico
    public function show($id)
    {
        $reporte = Reporte::findOrFail($id);
        return view('reportes.show', compact('reporte'));
    }

    // Mostrar el formulario de edición de un reporte
    public function edit($id)
    {
        $reporte = Reporte::findOrFail($id);
        $empleados = Employee::all();
        return view('reportes.edit', compact('reporte', 'empleados'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'estado' => 'nullable|in:pendiente,en proceso,resuelto',
            'id_empleado' => 'nullable|exists:employees,id_empleado'
        ]);

        $reporte = Reporte::findOrFail($id);

        $reporte->estado = $request->estado;
        $reporte->id_empleado = $request->id_empleado;

        $reporte->save();

        return redirect()->route('reportes.index')->with('success', 'Reporte actualizado exitosamente.');
    }


    // Eliminar un reporte de la base de datos
    public function destroy($id)
    {
        $reporte = Reporte::findOrFail($id);
        $reporte->delete();

        return redirect()->route('reportes.index')->with('success', 'Reporte eliminado exitosamente.');
    }

    public function eliminar($id)
    {
        // Buscar el reporte por ID
        $reporte = Reporte::find($id);

        // Verificar si el reporte existe
        if (!$reporte) {
            return redirect()->route('reportes.index')->with('error', 'Reporte no encontrado');
        }

        // Eliminar el reporte
        $reporte->delete();

        // Obtener el id del usuario autenticado
        $userId = Auth::id();

        // Redirigir al usuario con su id
        return redirect()->route('solicitudes.usuario', ['id' => $userId])
            ->with('success', 'Reporte eliminado correctamente');
    }
}