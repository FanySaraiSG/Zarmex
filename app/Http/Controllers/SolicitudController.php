<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Reporte;

class SolicitudController extends Controller
{
    public function index()
    {
        $mantenimientos = Mantenimiento::all();
        $reportes = Reporte::all();

        return view('solicitudes.index', compact('mantenimientos', 'reportes'));
    }
    public function usuario($id)
    {
        // Mantenimientos que coincidan con el correo del usuario
        $correoUsuario = \App\Models\User::findOrFail($id)->email;

        $mantenimientos = Mantenimiento::where('correo_electronico', $correoUsuario)->get();
        $reportes = Reporte::where('id', $id)->get();

        return view('solicitudes.usuario', compact('mantenimientos', 'reportes'));
    }

    public function usuarioSolicitudes()
    {
        $userId = auth()->id();
        $email = auth()->user()->email;

        // Buscar mantenimientos por correo del usuario autenticado
        $mantenimientos = Mantenimiento::where('correo_electronico', $email)->get();

        // Buscar reportes por id del usuario autenticado
        $reportes = Reporte::where('id', $userId)->get();

        return view('solicitudes.usuario', compact('mantenimientos', 'reportes'));
    }

}
