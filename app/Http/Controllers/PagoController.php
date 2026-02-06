<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Carrito;
use App\Models\Producto;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PayPalService;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Illuminate\Support\Facades\Log;
use PayPalHttp\HttpException;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function detallesPago($pagoId)
    {
        try {
            $pago = Pago::findOrFail($pagoId);
            $usuario = User::findOrFail($pago->user_id);
            $direccion = Direccion::findOrFail($pago->direccion_id);
            $productos = json_decode($pago->productos, true);
            $detalles_pago = json_decode($pago->detalles_pago, true) ?? [];

            return view('detalles_pago', [
                'pago' => $pago,
                'usuario' => $usuario,
                'direccion' => $direccion,
                'productos' => $productos,
                'detalles_pago' => $detalles_pago,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pagos.gestion')->with('error', 'Registro no encontrado');
        } catch (\Exception $e) {
            \Log::error('Error en detallesPago: ' . $e->getMessage());
            return redirect()->route('pagos.gestion')->with('error', 'Error interno del servidor');
        }
    }

    public function gestionPedidos(Request $request)
    {
        $query = Pago::query();

        // Filtro por estado interno
        if ($request->has('estado_interno')) {
            $query->where('estado_interno', $request->estado_interno);
        }

        $pagos = $query->paginate(10);

        foreach ($pagos as $pago) {
            $direccion = Direccion::find($pago->direccion_id);
            $pago->direccion = $direccion;
        }

        return view('gestion_pedidos', compact('pagos'));
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado_interno' => 'required|in:PENDIENTE,PREPARANDO,ENVIADO,ENTREGADO,CANCELADO'
        ]);

        $pago = Pago::find($id);
        if ($pago) {
            $pago->estado_interno = $request->estado_interno; // Actualiza el estado interno
            $pago->save();
            return redirect()->route('pagos.gestion')->with('success', 'Estado del pedido actualizado.');
        } else {
            return redirect()->route('pagos.gestion')->with('error', 'Pedido no encontrado.');
        }
    }

    public function index()
    {
        $user = Auth::user();
        Log::info('Usuario autenticado: ' . json_encode($user));

        $pagos = Pago::where('user_id', $user->id)->paginate(6); // Paginación de 6 en 6
        Log::info('Pagos encontrados: ' . json_encode($pagos));

        foreach ($pagos as $pago) {
            $direccion = Direccion::find($pago->direccion_id);
            $pago->direccion = $direccion; // Agregar la dirección al objeto pago
        }

        return view('pedido', compact('pagos'));
    }

    public function mostrarPago($id_usuario)
    {
        $direcciones = Direccion::where('user_id', $id_usuario)->get();
        $carritoItems = Carrito::where('id_usuario', $id_usuario)->get();

        $productosCarrito = [];
        $subtotal = 0;

        foreach ($carritoItems as $item) {
            $producto = Producto::find($item->id_producto);
            if ($producto) {
                $productosCarrito[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $item->precio,
                    'cantidad' => $item->cantidad,
                ];
                $subtotal += $item->precio;
            }
        }

        $iva_porcentaje = 0.16;
        $monto_iva = $subtotal * $iva_porcentaje;
        $total_con_iva = $subtotal + $monto_iva;

        return view('carritopago', compact('direcciones', 'productosCarrito', 'subtotal', 'monto_iva', 'total_con_iva'));
    }

    public function createPayPalOrder(Request $request, PayPalService $payPalService)
    {
        Log::info('Inicio de createPayPalOrder');
        $orderTotal = $request->input('total');

        if (!is_numeric($orderTotal) || $orderTotal <= 0) {
            Log::error('Error: total no es un número válido.');
            return response()->json(['error' => 'Total no válido'], 400);
        }

        $ordersCreateRequest = new OrdersCreateRequest();
        $ordersCreateRequest->prefer('return=representation');
        $ordersCreateRequest->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "MXN",
                        "value" => number_format($orderTotal, 2, '.', ''),
                    ],
                ],
            ],
        ];

        try {
            Log::info('Enviando solicitud a PayPal...');
            $response = $payPalService->client()->execute($ordersCreateRequest);
            Log::info('Respuesta de PayPal: ' . json_encode($response));

            return response()->json(['orderId' => $response->result->id]);
        } catch (HttpException $ex) {
            Log::error('Error de PayPal: ' . $ex->getMessage());
            return response()->json(['error' => $ex->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Error general: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function guardarDireccionSesion(Request $request)
    {
        $request->validate([
            'id_direccion' => 'required|exists:direcciones,id_direccion'
        ]);

        session(['direccion_id' => $request->id_direccion]);

        return response()->json(['success' => true]);
    }

    public function capturePayPalOrder($orderId, PayPalService $payPalService)
    {
        Log::info("capturePayPalOrder: Iniciando captura de pago para orden ID: {$orderId}");

        $direccionId = session('direccion_id');

        if (!$direccionId) {
            Log::error("capturePayPalOrder: Error - direccion_id no encontrado en sesión.");
            return response()->json(['error' => 'Direccion no seleccionada'], 400);
        }

        if (!Auth::check()) {
            Log::error("capturePayPalOrder: Error - Usuario no autenticado.");
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $userId = Auth::id();
        Log::info("capturePayPalOrder: Usuario ID: {$userId}, Dirección ID: {$direccionId}");

        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        try {
            $response = $payPalService->client()->execute($request);
            $result = $response->result;

            Log::info("capturePayPalOrder: Respuesta de PayPal: " . json_encode($result));

            if ($result->status !== 'COMPLETED') {
                Log::error("capturePayPalOrder: Captura fallida. Estado: {$result->status}");
                return response()->json(['error' => 'Captura de PayPal fallida', 'status' => $result->status], 400);
            }

            DB::beginTransaction();
            try {
                $carritoItems = Carrito::where('id_usuario', $userId)->get();
                $subtotal = $carritoItems->sum('precio');
                $iva_porcentaje = 0.16;
                $monto_iva = $subtotal * $iva_porcentaje;
                $total = $subtotal + $monto_iva;

                // Recopilar información de los productos del carrito
                $productos = [];
                foreach ($carritoItems as $item) {
                    $producto = Producto::find($item->id_producto);
                    if ($producto) {
                        $productos[] = [
                            'id' => $producto->id,
                            'nombre' => $producto->nombre,
                            'precio' => $item->precio,
                            'cantidad' => $item->cantidad,
                            'color' => $item->id_color,
                        ];
                    }
                }

                $pago = new Pago();
                $pago->user_id = $userId;
                $pago->direccion_id = $direccionId;
                $pago->metodo_pago = 'PayPal';
                $pago->monto_total = $total;
                $pago->estado = $result->status;
                $pago->transaccion_id = $result->id;
                $pago->detalles = json_encode($result);
                $pago->productos = json_encode($productos); // Guardar los productos aquí
                $pago->estado_interno = 'PENDIENTE';
                $pago->save();

                Carrito::where('id_usuario', $userId)->delete();

                DB::commit();

                Log::info("capturePayPalOrder: Pago procesado exitosamente para usuario ID: {$userId}");
                return response()->json(['status' => $result->status]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("capturePayPalOrder: Error en DB: " . $e->getMessage());
                return response()->json(['error' => 'Error al procesar el pago'], 500);
            }
        } catch (HttpException $ex) {
            Log::error("capturePayPalOrder: Error de PayPal: " . $ex->getMessage());
            return response()->json(['error' => $ex->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error("capturePayPalOrder: Error general: " . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function procesarPago(Request $request)
    {
        $request->validate([
            'direccion_id' => 'required|exists:direcciones,id_direccion',
            'metodo_pago' => 'required',
        ]);

        return response()->json(['success' => 'Pago procesado con éxito.']);
    }
}