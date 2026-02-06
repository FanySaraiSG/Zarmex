<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zarmex</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .cart-container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .cart-products {
            width: 60%;
        }

        .cart-summary {
            width: 35%;
            border: 1px solid #ddd;
            padding: 20px;
        }
    </style>
</head>

<body class="antialiased">
    @include('header')

    <main class="cart-container">
        <section class="cart-products">
            <h2 style="color: black;">Seleccionar Dirección</h2>
            <div class="address-selection mb-3">
                <select class="form-select" id="direccionSelect">
                    <option value="">Selecciona una dirección</option>
                    @foreach ($direcciones as $direccion)
                        <option value="{{ $direccion->id_direccion }}">
                            {{ $direccion->tipo }} - {{ $direccion->calle }}, {{ $direccion->ciudad }},
                            {{ $direccion->pais }}
                        </option>
                    @endforeach
                </select>
                <a class="btn btn-primary mt-2" href="{{ route('direcciones.create') }}">Agregar Nueva Dirección</a>
            </div>

            <h2 style="color:black;">Método de Pago</h2>
            <div class="payment-methods paypal-buttons" style="color:black;">
                <div id="paypal-button-container"></div>
            </div>
        </section>

        <aside class="cart-summary" style="color: black;">
            <h3>Resumen de Compra</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio c/u</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productosCarrito as $producto)
                        <tr>
                            <td>{{ $producto['nombre'] }} (ID: {{ $producto['id'] }})</td>
                            <td>{{ $producto['cantidad'] }}</td>
                            <td>${{ number_format($producto['precio'] / $producto['cantidad'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="subtotal">Subtotal: ${{ number_format($subtotal, 2) }} MXN</p>
            <p class="iva">IVA (16%): ${{ number_format($monto_iva, 2) }} MXN</p>
            <p class="total">Total: ${{ number_format($total_con_iva, 2) }} MXN</p>
        </aside>
    </main>

    @include('footer')

    <script>
        $(document).ready(function () {
            $(document).on('change', '#direccionSelect', function () {
                var direccionId = $(this).val();
                console.log("Dirección seleccionada (en change): ", direccionId);

                if (!direccionId) {
                    console.error('No se seleccionó ninguna dirección.');
                    return;
                }

                $.ajax({
                    url: '/guardar-direccion-sesion',
                    type: 'POST',
                    data: {
                        id_direccion: direccionId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log("Dirección guardada en la sesión:", response.success);
                    },
                    error: function (error) {
                        console.error('Error al guardar direccion_id en la sesión.', error);
                    }
                });
            });

            paypal.Buttons({
                createOrder: function (data, actions) {
                    return fetch('/paypal/create-order', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            total: {{ $total_con_iva }}
                        })
                    }).then(response => response.json())
                        .then(orderData => orderData.orderId);
                },
                onApprove: function (data, actions) {
                    let direccionId = $('#direccionSelect').val();
                    if (!direccionId) {
                        alert('Por favor, selecciona una dirección antes de continuar.');
                        return;
                    }

                    return fetch('/paypal/capture-order/' + data.orderID, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_direccion: direccionId
                        })
                    }).then(response => response.json())
                        .then(orderData => {
                            if (orderData.status === 'COMPLETED') {
                                let alertHTML = `
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Pago completado exitosamente!</strong> Revisa tus pedidos, cualquier duda puedes enviar un mensaje a soporte, buen día. Zarmex está para servirte.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `;
                                $('#paypal-button-container').append(alertHTML);
                                setTimeout(() => {
                                    location.reload();
                                }, 15000);
                            } else {
                                alert('Error al completar el pago con PayPal.');
                            }
                        })
                        .catch(error => {
                            console.error('Error al capturar la orden:', error);
                        });
                }
            }).render('#paypal-button-container');
        });
    </script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=MXN"></script>
</body>

</html>