<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zarmex</title>
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #ccc;
            margin-left: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body class="antialiased">
    @include('header')

    <div class="cart-container">
        <section class="cart-products">
            <h2>Carrito de Compras</h2>
            @if(isset($carrito) && $carrito->isNotEmpty())
                @foreach ($carrito as $item)
                    <div class="cart-card" id="item-{{ $item->id }}">
                        @if(isset($item->producto) && isset($item->producto->imagen_url))
                            <img src="{{ asset($item->producto->imagen_url) }}" alt="{{ $item->producto->nombre }}">
                        @else
                            <p>Imagen no disponible</p>
                        @endif
                        <div class="cart-card-content">
                            <h3>{{ $item->producto->nombre ?? 'Nombre no disponible' }}</h3>
                            <p>Color: {{ $item->color->nombre ?? 'Color no disponible' }}
                                @if($item->color)
                                    <span class="color-box" style="background-color: #{{ $item->color->id_color }};"></span>
                                @endif
                            </p>
                            <p>Precio Individual: ${{ number_format($item->producto->precio ?? 0, 2) }} MXN</p>
                            <p class="cart-price">Precio Total: ${{ number_format($item->precio, 2) }} MXN</p>
                            <div class="cart-card-actions">
                                <button class="btn btn-danger btn-sm" onclick="eliminarProducto({{ $item->id }})">Eliminar</button>
                                <button class="btn btn-secondary btn-sm" onclick="compartirProducto('{{ $item->producto->nombre }}', '{{ url('/vermas/' . $item->producto->id) }}')">Compartir</button>
                                &nbsp;
                                <p>Cantidad: &nbsp; </p><input type="number" min="1" value="{{ $item->cantidad }}" style="width: 50px;" onchange="actualizarCantidad({{ $item->id }}, this.value)">
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p style="color: black">Tu carrito está vacío.</p>
            @endif
        </section>

        <aside class="cart-summary">
            <h3>Resumen</h3>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Subtotal ({{ isset($carrito) ? $carrito->count() : 0 }} productos):</td>
                        <td class="text-end">
                            @if(isset($carrito))
                                ${{ number_format($carrito->sum(function ($item) { return $item->precio; }), 2) }} MXN
                            @else
                                $0.00 MXN
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ url('/carritopago/' . auth()->id()) }}" class="btn btn-primary w-100">Proceder al pago</a>
        </aside>
    </div>

    @include('footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function eliminarProducto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                $.ajax({
                    url: `/carrito/eliminar/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $(`#item-${id}`).remove();
                        alert(response.success);
                        window.location.reload();
                    },
                    error: function (error) {
                        alert(error.responseJSON.error);
                    }
                });
            }
        }

        function actualizarCantidad(id, cantidad) {
            $.ajax({
                url: `/carrito/actualizar/${id}`,
                type: 'PUT',
                data: {
                    cantidad: cantidad
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert(response.success);
                    window.location.reload();
                },
                error: function (error) {
                    if (error.responseJSON && error.responseJSON.errors) {
                        alert(Object.values(error.responseJSON.errors).join('\n'));
                    } else {
                        alert(error.responseJSON.error);
                    }
                }
            });
        }

        function compartirProducto(nombre, url) {
            if (navigator.share) {
                navigator.share({
                    title: 'Producto: ' + nombre,
                    url: url
                }).then(() => {
                    console.log('Producto compartido con éxito.');
                }).catch((error) => {
                    console.log('Error al compartir el producto:', error);
                });
            } else {
                alert('La función de compartir no está disponible en este navegador.');
            }
        }

        function actualizarSubtotal() {
            let subtotal = 0;
            $('.cart-price').each(function () {
                let priceText = $(this).text().replace('$', '').replace(' MXN', '');
                let price = parseFloat(priceText);
                console.log("Precio del producto:", price);
                subtotal += price;
            });
            console.log("Subtotal antes de formatear:", subtotal);
            $('.subtotal').text('$' + subtotal.toFixed(2) + ' MXN');
            console.log("Subtotal después de formatear:", $('.subtotal').text());
        }
    </script>
</body>

</html>