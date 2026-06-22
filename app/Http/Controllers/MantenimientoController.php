<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoImagen;
use App\Models\Mantenimiento;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    /* ══════════════════════════════════════════════════════
       ÍNDICE Y CRUD DE SOLICITUDES (sin cambios)
    ══════════════════════════════════════════════════════ */

    public function index(Request $request)
    {
        $query = Mantenimiento::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $mantenimientos = $query->paginate(8);
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
            'nombre'             => 'required|string|max:255',
            'ocupacion'          => 'required|string|max:255',
            'tipo_maquina'       => 'required|string|max:255',
            'codigo_equipo'      => 'required|exists:productos,id',
            'descripcion'        => 'required|string',
            'direccion'          => 'required|string|max:255',
            'estado'             => 'required|string|max:255',
            'codigo_postal'      => 'required|string|max:20',
            'numero_celular'     => 'nullable|string|max:255',
            'correo_electronico' => 'nullable|email|max:255',
        ]);

        try {
            if (auth()->check()) {
                $validatedData['correo_electronico'] = auth()->user()->email;
            }

            Mantenimiento::create($validatedData);
            return redirect()->route('dashboard')->with('success', '¡Solicitud de mantenimiento enviada con éxito!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar la solicitud: ' . $e->getMessage());
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
            'nombre'        => 'required|string|max:255',
            'ocupacion'     => 'required|string|max:255',
            'tipo_maquina'  => 'required|string|max:255',
            'codigo_equipo' => 'required|exists:productos,id',
            'descripcion'   => 'required|string',
            'direccion'     => 'required|string|max:255',
            'estado'        => 'required|string|max:255',
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
        $mantenimiento = Mantenimiento::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|in:En revisión,En procedimiento,En camino,Finalizado',
        ]);

        $mantenimiento->status = $validatedData['status'];
        $mantenimiento->save();

        return redirect()->route('mantenimientos.index')->with('success', 'Estado actualizado con éxito');
    }

    public function eliminar($id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (!$mantenimiento) {
            return redirect()->route('mantenimientos.index')->with('error', 'Mantenimiento no encontrado');
        }

        $mantenimiento->delete();

        $userId = Auth::id();
        return redirect()->route('solicitudes.usuario', ['id' => $userId])
            ->with('success', 'Mantenimiento eliminado correctamente');
    }

    /* ══════════════════════════════════════════════════════
       GESTIÓN DE IMÁGENES — ADMIN
       Soporta hasta 3 imágenes por columna + layout 1/2/3
    ══════════════════════════════════════════════════════ */

    /**
     * Mapa de claves JSON → posición en BD
     * izq_1, izq_2, izq_3, der_1, der_2, der_3
     */
    private array $slots = [
        'izq_1' => 'izquierda_1',
        'izq_2' => 'izquierda_2',
        'izq_3' => 'izquierda_3',
        'der_1' => 'derecha_1',
        'der_2' => 'derecha_2',
        'der_3' => 'derecha_3',
    ];

    public function editImagenes()
    {
        $imagenes = MantenimientoImagen::whereIn('posicion', array_values($this->slots))
            ->where('activo', true)
            ->get()
            ->keyBy('posicion');

        // Leer las URLs de cada columna y compactar (eliminar huecos)
        // para que el JS del admin reciba siempre slots consecutivos sin vacíos
        $compactarCol = function (array $posiciones) use ($imagenes) {
            $urls = array_values(array_filter(
                array_map(fn($pos) => ($reg = $imagenes->get($pos)) ? asset($reg->ruta_imagen) : null, $posiciones)
            ));
            // Normalizar a 3 elementos (null para los vacíos al final)
            while (count($urls) < 3) $urls[] = null;
            return $urls;
        };

        [$izq1, $izq2, $izq3] = $compactarCol(['izquierda_1', 'izquierda_2', 'izquierda_3']);
        [$der1, $der2, $der3] = $compactarCol(['derecha_1',   'derecha_2',   'derecha_3']);

        $imagenesActuales = [
            'izq_1' => $izq1, 'izq_2' => $izq2, 'izq_3' => $izq3,
            'der_1' => $der1, 'der_2' => $der2, 'der_3' => $der3,
        ];

        return view('mantenimientos.imagenes', compact('imagenesActuales'));
    }

    public function updateImagenes(Request $request)
    {
        $request->validate([
            'izq_1' => 'nullable|string',
            'izq_2' => 'nullable|string',
            'izq_3' => 'nullable|string',
            'der_1' => 'nullable|string',
            'der_2' => 'nullable|string',
            'der_3' => 'nullable|string',
        ]);

        try {
            $destinationPath = public_path('img/mantenimiento');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // 1. Recompactar: juntar las imágenes que vienen sin dejar huecos
            foreach (['izq', 'der'] as $col) {
                $filled = [];
                foreach ([1, 2, 3] as $i) {
                    $val = $request->input("{$col}_{$i}");
                    if (!empty($val)) $filled[] = $val;
                }
                // Rellenar con null hasta 3 para normalizar
                while (count($filled) < 3) $filled[] = null;
                // Sobreescribir en el request
                $request->merge([
                    "{$col}_1" => $filled[0],
                    "{$col}_2" => $filled[1],
                    "{$col}_3" => $filled[2],
                ]);
            }

            // 2. NUEVO: Extraer todas las rutas que SÍ se van a conservar tras reordenar.
            $rutasAConservar = [];
            foreach (['izq', 'der'] as $col) {
                foreach ([1, 2, 3] as $i) {
                    $val = $request->input("{$col}_{$i}");
                    if (!empty($val) && filter_var($val, FILTER_VALIDATE_URL)) {
                        $parsedUrl    = parse_url($val, PHP_URL_PATH);
                        $relativePath = ltrim(preg_replace('/^\/(index\.php\/)?/', '', $parsedUrl), '/');
                        $rutasAConservar[] = $relativePath;
                    }
                }
            }

            // 3. Procesar cada slot de imagen
            foreach ($this->slots as $jsonKey => $posicion) {
                $data    = $request->input($jsonKey);
                $registro = MantenimientoImagen::where('posicion', $posicion)->first();

                // Slot vacío → borrar si existía
                if (empty($data)) {
                    if ($registro) {
                        // FIX: Solo eliminar el archivo físico si NINGÚN otro slot lo va a usar
                        if (!in_array($registro->ruta_imagen, $rutasAConservar)) {
                            $this->eliminarArchivoFisico($registro->ruta_imagen);
                        }
                        $registro->delete();
                    }
                    continue;
                }

                // Nueva imagen en Base64
                if (str_starts_with($data, 'data:image')) {
                    if ($registro) {
                        // FIX: Misma validación al sobrescribir
                        if (!in_array($registro->ruta_imagen, $rutasAConservar)) {
                            $this->eliminarArchivoFisico($registro->ruta_imagen);
                        }
                    }

                    preg_match('/data:image\/(.*?);base64,/', $data, $matches);
                    $extension = $matches[1] ?? 'jpg';
                    if ($extension === 'jpeg') $extension = 'jpg';

                    $prefix   = $matches[0] ?? null;
                    $image    = $prefix ? str_replace($prefix, '', $data) : $data;
                    $image    = str_replace(' ', '+', $image);
                    $filename = 'img_' . $posicion . '_' . time() . '_' . uniqid() . '.' . $extension;

                    file_put_contents($destinationPath . '/' . $filename, base64_decode($image));
                    $nuevaRuta = 'img/mantenimiento/' . $filename;

                    MantenimientoImagen::updateOrCreate(
                        ['posicion' => $posicion],
                        ['ruta_imagen' => $nuevaRuta, 'activo' => true]
                    );
                }
                // URL existente (sin cambios o intercambiada)
                elseif (filter_var($data, FILTER_VALIDATE_URL)) {
                    $parsedUrl    = parse_url($data, PHP_URL_PATH);
                    $relativePath = ltrim(preg_replace('/^\/(index\.php\/)?/', '', $parsedUrl), '/');

                    if ($registro) {
                        if ($registro->ruta_imagen !== $relativePath) {
                            $registro->update(['ruta_imagen' => $relativePath]);
                        }
                    } else {
                        MantenimientoImagen::create([
                            'posicion'    => $posicion,
                            'ruta_imagen' => $relativePath,
                            'activo'      => true,
                        ]);
                    }
                }
            }

            // Regresar las rutas finales guardadas para que el blade actualice su state
            $imagenesGuardadas = [];
            foreach ($this->slots as $jsonKey => $posicion) {
                $reg = MantenimientoImagen::where('posicion', $posicion)->where('activo', true)->first();
                $imagenesGuardadas[$jsonKey] = $reg ? asset($reg->ruta_imagen) : null;
            }

            return response()->json([
                'success'  => true,
                'message'  => '¡Cambios realizados!',
                'imagenes' => $imagenesGuardadas,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /* ══════════════════════════════════════════════════════
       FORMULARIO PÚBLICO — muestra las imágenes al usuario
    ══════════════════════════════════════════════════════ */

    public function mostrarFormularioPublico($vista = 'mantenimiento')
    {
        // Leer todas las posiciones y filtrar nulls para evitar huecos en la vista
        $izq = collect([
            MantenimientoImagen::where('posicion', 'izquierda_1')->where('activo', true)->first(),
            MantenimientoImagen::where('posicion', 'izquierda_2')->where('activo', true)->first(),
            MantenimientoImagen::where('posicion', 'izquierda_3')->where('activo', true)->first(),
        ])->filter()->values(); // elimina nulls y re-indexa 0,1,2

        $der = collect([
            MantenimientoImagen::where('posicion', 'derecha_1')->where('activo', true)->first(),
            MantenimientoImagen::where('posicion', 'derecha_2')->where('activo', true)->first(),
            MantenimientoImagen::where('posicion', 'derecha_3')->where('activo', true)->first(),
        ])->filter()->values(); // elimina nulls y re-indexa 0,1,2

        // Asignar por índice compactado — sin huecos aunque la BD tenga posiciones salteadas
        $img_izq_1 = $izq->get(0);
        $img_izq_2 = $izq->get(1);
        $img_izq_3 = $izq->get(2);
        $img_der_1 = $der->get(0);
        $img_der_2 = $der->get(1);
        $img_der_3 = $der->get(2);

        // Layout calculado dinámicamente según cuántas imágenes existen
        $layout_izq = max($izq->count(), 1);
        $layout_der = max($der->count(), 1);

        return view($vista, compact(
            'layout_izq', 'layout_der',
            'img_izq_1', 'img_izq_2', 'img_izq_3',
            'img_der_1', 'img_der_2', 'img_der_3'
        ));
    }

    /* ══════════════════════════════════════════════════════
       HELPER
    ══════════════════════════════════════════════════════ */

    private function eliminarArchivoFisico($rutaRelativa)
    {
        if ($rutaRelativa && $rutaRelativa !== 'config') {
            $pathCompleto = public_path($rutaRelativa);
            if (file_exists($pathCompleto) && is_file($pathCompleto)) {
                @unlink($pathCompleto);
            }
        }
    }
}