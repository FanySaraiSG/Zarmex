<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:employees',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:15',
            'rol' => 'in:admin,soporte,tecnico'
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => $request->rol ?? 'soporte',
        ]);

        return redirect()->route('employees.index')->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|string|email|max:100|unique:employees,email,' . $id . ',id_empleado',
            'password' => 'sometimes|string|min:6',
            'telefono' => 'sometimes|string|max:15',
            'rol' => 'sometimes|in:admin,soporte,tecnico',
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Empleado se ha actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Empleado se ha borrado correctamente');
    }

    public function redirectToDashboard()
    {
        $employee = auth()->user();  // O usa cualquier otro método para obtener el empleado

        if ($employee->hasRole('admin')) {
            return redirect()->route('admin.dashboard');  // Ruta de dashboard del admin
        }

        if ($employee->hasRole('soporte')) {
            return redirect()->route('soporte.dashboard');  // Ruta de dashboard de soporte
        }

        // Si no es admin ni soporte, puedes redirigir a algún otro lugar
        return redirect()->route('default.dashboard');
    }


}