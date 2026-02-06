<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión para empleados.
     */
    public function showLoginForm()
    {
        return view('auth.employee-login');
    }

    /**
     * Maneja el inicio de sesión de empleados.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('employee')->attempt($credentials, $request->remember)) {
            $employee = Auth::guard('employee')->user();
    
            if ($employee->rol === 'admin' || $employee->rol === 'administrador') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($employee->rol === 'soporte') {
                return redirect()->intended(route('soporte.dashboard'));
            } elseif ($employee->rol === 'tecnico') {
                return redirect()->intended(route('tecnico.dashboard'));
            }
    
            return redirect()->intended('/dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
    }
    


    /**
     * Cierra la sesión del empleado.
     */
    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect('/');
    }
}
