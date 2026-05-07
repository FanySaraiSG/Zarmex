<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLogoController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'file', 'mimes:jpg,jpeg,png,bmp,webp', 'max:4096'],
        ]);

        // Buscamos el registro del logo o lo creamos si no existe
        $setting = Setting::firstOrCreate(
            ['key' => 'site_logo_path'],
            ['value' => null]
        );

        // Borra el archivo físico anterior si existe para no llenar el disco de basura
        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        // Guarda el nuevo archivo en la carpeta storage/app/public/site-branding
        $path = $request->file('logo')->store('site-branding', 'public');

        // Actualizamos la ruta en la base de datos
        $setting->value = $path;
        $setting->save();

        return back()->with('success', '✅ Logo actualizado correctamente.');
    }

    public function reset()
    {
        $setting = Setting::where('key', 'site_logo_path')->first();

        if ($setting) {
            // Borramos el archivo físico antes de eliminar el registro
            if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            
            // Eliminamos el registro de la base de datos
            $setting->delete();
        }

        return back()->with('success', '✅ Logo restaurado al predeterminado.');
    }
}