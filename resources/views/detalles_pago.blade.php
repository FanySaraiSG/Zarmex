<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .color-box {
                display: inline-block;
                width: 15px;
                height: 15px;
                border: 1px solid #ccc;
                margin-right: 5px;
                vertical-align: middle;
            }
        </style>
    </head>
    <div class="container mt-5">
        <div class="bg-white p-5 rounded shadow">
            <h1 class="mb-4">Detalles del Pedido</h1>

            <section class="mb-4">
                <h2 class="border-bottom pb-2"><i class="fas fa-user me-2"></i> Información del Usuario</h2>
                <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                <p><strong>Teléfono:</strong> {{ $direccion->telefono ?? 'No disponible' }}</p>
            </section>

            <section class="mb-4">
                <h2 class="border-bottom pb-2"><i class="fas fa-credit-card me-2"></i> Detalles del Pago</h2>
                <p><strong>ID Transacción:</strong> {{ $pago->transaccion_id }}</p>
                <p><strong>Monto Total:</strong> ${{ number_format($pago->monto_total, 2) }}</p>
                <p><strong>Estado del Pedido:</strong>
                    @if ($pago->estado_interno === 'PENDIENTE')
                        <span class="badge bg-warning text-dark">{{ $pago->estado_interno }}</span>
                    @elseif ($pago->estado_interno === 'PREPARANDO')
                        <span class="badge bg-info">{{ $pago->estado_interno }}</span>
                    @elseif ($pago->estado_interno === 'ENVIADO')
                        <span class="badge bg-primary">{{ $pago->estado_interno }}</span>
                    @elseif ($pago->estado_interno === 'ENTREGADO')
                        <span class="badge bg-success">{{ $pago->estado_interno }}</span>
                    @elseif ($pago->estado_interno === 'CANCELADO')
                        <span class="badge bg-danger">{{ $pago->estado_interno }}</span>
                    @else
                        {{ $pago->estado_interno }}
                    @endif
                </p>
                <p><strong>Fecha de Transacción:</strong> {{ $pago->created_at->format('d/m/Y') }}</p>
                <p><strong>Hora de Transacción:</strong> {{ $pago->created_at->format('H:i:s') }}</p>

                @if (!empty($detalles))
                    <h5 class="mt-3"><i class="fab fa-paypal me-2"></i> Detalles de PayPal</h5>
                    <pre><code class="language-json">{{ json_encode($detalles, JSON_PRETTY_PRINT) }}</code></pre>
                @else
                    <p>No hay detalles de pago de PayPal disponibles.</p>
                @endif
            </section>

            <section class="mb-4">
                <h2 class="border-bottom pb-2"><i class="fas fa-box me-2"></i> Productos</h2>
                @if (!empty($productos))
                    <ul class="list-unstyled">
                        @foreach ($productos as $producto)
                            <li class="mb-2">
                                {{ $producto['nombre'] }} (x{{ $producto['cantidad'] }}) -
                                @if (isset($producto['color']))
                                    Color: {{ $producto['color']}}
                                    <span class="color-box" style="background-color: #{{ $producto['color']}};"></span>
                                -
                                @else
                                    Sin color -
                                @endif
                                ${{ number_format($producto['precio'], 2) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay productos en este pedido.</p>
                @endif
            </section>

            <section class="mb-4">
                <h2 class="border-bottom pb-2"><i class="fas fa-map-marker-alt me-2"></i> Dirección de Entrega</h2>
                <p><strong>Tipo de domicilio:</strong> {{ $direccion->tipo }}</p>
                <p><strong>Calle:</strong> {{ $direccion->calle }}</p>
                <p><strong>Ciudad:</strong> {{ $direccion->ciudad }}</p>
                <p><strong>Estado:</strong> {{ $direccion->estado }}</p>
                <p><strong>C.P.:</strong> {{ $direccion->codigo_postal }}</p>
                <p><strong>No. Exterior:</strong> {{ $direccion->numero_exterior }}</p>
                <p><strong>País:</strong> {{ $direccion->pais }}</p>
            </section>

            <a href="{{ route('pagos.gestion') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Regresar</a>
        </div>
    </div>
    <br>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
</x-app-layout>