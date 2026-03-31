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
            'logo' => ['required','file','mimes:jpg,jpeg,png,bmp,webp','max:4096'],
        ]);

        // Obtén setting actual
        $setting = Setting::firstOrCreate(['key' => 'site_logo_path'], ['value' => null]);

        // Borra logo anterior si existe
        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        // Guarda el nuevo
        $path = $request->file('logo')->store('site-branding', 'public');

        $setting->value = $path;
        $setting->save();

        return back()->with('success', '✅ Logo actualizado.');
    }

    public function reset()
    {
        $setting = Setting::where('key', 'site_logo_path')->first();

        if ($setting && $setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        if ($setting) {
            $setting->delete(); // vuelve al logo default
        }

        return back()->with('success', '✅ Logo restaurado al predeterminado.');
    }
}