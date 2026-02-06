<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <br>
        <h1 style="color: #fedc97; text-align: center;">Pedidos</h1>
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Regresar</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#infoModal">
                    ¿Tiene dudas? Consulte aqui
                </button>
            </div>

            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="infoModalLabel">Información Adicional</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h2 class="fs-5">¿Necesita más información sobre su pedido?</h2>
                            <p>Ingrese una solicitud a soporte <a class="btn btn-secondary"
                                    href="{{ route('reportes.create') }}">aquí</a> y nuestro equipo se pondrá en
                                contacto contigo.</p>
                            <hr>
                            <h2 class="fs-5">Sobre el estado de su pedido</h2>
                            <p>Su pedido cuenta con cinco estados posibles dentro del proceso de compra y envío de los
                                productos, son los siguientes:</p>
                            <p>Estado 1: <button class="btn btn-secondary" data-bs-toggle="popover" title="PENDIENTE"
                                    data-bs-content="Estado donde el sistema ya registró el pago.">PENDIENTE</button>
                            </p>
                            <p>Estado 2: <button class="btn btn-secondary" data-bs-toggle="popover" title="PREPARANDO"
                                    data-bs-content="Nuestro equipo está preparando su pedido para el envío.">PREPARANDO</button>
                            </p>
                            <p>Estado 3: <button class="btn btn-secondary" data-bs-toggle="popover" title="ENVIADO"
                                    data-bs-content="Tu pedido está listo y en camino.">ENVIADO</button></p>
                            <p>Estado 4: <button class="btn btn-secondary" data-bs-toggle="popover" title="ENTREGADO"
                                    data-bs-content="Su pedido ha sido entregado exitosamente.">ENTREGADO</button></p>
                            <p>Estado 5: <button class="btn btn-secondary" data-bs-toggle="popover" title="CANCELADO"
                                    data-bs-content="Su pedido ha sido cancelado.">CANCELADO</button></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($pagos) && $pagos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-light">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Monto Total</th>
                                <th>Estado</th>
                                <th>Transacción ID</th>
                                <th>Dirección de Entrega</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagos as $pago)
                                            <tr>
                                                <td>{{ $pago->created_at }}</td>
                                                <td>${{ $pago->monto_total }}</td>
                                                <td>{{ $pago->estado_interno }}</td>
                                                <td>{{ $pago->transaccion_id }}</td>
                                                <td>
                                                    @if($pago->direccion)
                                                        Calle {{ $pago->direccion->calle }}, Ciudad {{ $pago->direccion->ciudad }},
                                                        Estado {{ $pago->direccion->estado }}, C.P. {{ $pago->direccion->codigo_postal }}, No.
                                                        Exterior {{ $pago->direccion->numero_exterior }},
                                                        {{ $pago->direccion->pais }}
                                                    @else
                                                        Dirección no disponible
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($pago->productos)
                                                                            @php
                                                                                $productos = json_decode($pago->productos, true);
                                                                            @endphp
                                                                            @if(is_array($productos))
                                                                                <ul>
                                                                                    @foreach($productos as $producto)
                                                                                        <li>{{ $producto['nombre'] }} (ID: {{ $producto['id'] }})
                                                                                            (x{{$producto['cantidad']}})</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @else
                                                                                {{ $pago->productos }}
                                                                            @endif
                                                    @else
                                                        No hay productos
                                                    @endif
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $pagos->links() }}
                </div>
            @else
                <p style="color: #ffffff">No tienes pedidos registrados.</p>
            @endif
        </div>
    </body>

    <style>
        h1 {
            color: antiquewhite;
        }

        p {
            color: black;
        }

        .bg-custom {
            background-color: #28666e !important;
            border-radius: 15px;
        }

        .text-light {
            color: #fedc97 !important;
        }

        .btn-light {
            background-color: #fedc97;
            color: #28666e;
            border: none;
            font-size: 1.2em;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-light:hover {
            background-color: #ffffff;
            color: #234d50;
        }

        .card i {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover i {
            transform: scale(1.1);
        }

        nav.bg-white {
            background-color: #28666e !important;
        }
    </style>

    <script>
        // Inicializar tooltips y popovers
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        })
    </script>

    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>