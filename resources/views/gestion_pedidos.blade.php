<x-app-layout>
    @auth('employee')
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <title>Gestión de Pedidos</title>
            <style>
                nav {
                    background-color: inherit !important;
                }

                .table {
                    background-color: white !important;
                }
            </style>
        </head>

        <body>
            <div class="container mt-5">
                <h1 style="text-align: center; color: aliceblue;">Gestión de Pedidos</h1>
                @php
                    $employee = auth('employee')->user();
                    $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'soporte.dashboard';
                @endphp

                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{ route($dashboard) }}">
                        Regresar
                    </a>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <form method="GET" action="{{ route('pagos.gestion') }}" class="d-flex gap-2">
                        <select name="estado_interno" class="form-select form-select-sm">
                            <option value="">-- Filtrar por Estado Interno --</option>
                            <option value="PENDIENTE" {{ request('estado_interno') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                            <option value="PREPARANDO" {{ request('estado_interno') == 'PREPARANDO' ? 'selected' : '' }}>PREPARANDO</option>
                            <option value="ENVIADO" {{ request('estado_interno') == 'ENVIADO' ? 'selected' : '' }}>ENVIADO</option>
                            <option value="ENTREGADO" {{ request('estado_interno') == 'ENTREGADO' ? 'selected' : '' }}>ENTREGADO</option>
                            <option value="CANCELADO" {{ request('estado_interno') == 'CANCELADO' ? 'selected' : '' }}>CANCELADO</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                        <a href="{{ route('pagos.gestion') }}" class="btn btn-secondary btn-sm">Restablecer</a>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Monto Total</th>
                                <th>Estado Interno</th>
                                <th>Transacción ID</th>
                                <th>Dirección de Entrega</th>
                                <th>Productos</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $pago)
                                <tr>
                                    <td>${{ $pago->monto_total }}</td>
                                    <td>
                                        <form action="{{ route('pagos.actualizarEstado', $pago->id) }}" method="post">
                                            @csrf
                                            <select name="estado_interno" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="PENDIENTE" {{ $pago->estado_interno == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                                                <option value="PREPARANDO" {{ $pago->estado_interno == 'PREPARANDO' ? 'selected' : '' }}>PREPARANDO</option>
                                                <option value="ENVIADO" {{ $pago->estado_interno == 'ENVIADO' ? 'selected' : '' }}>ENVIADO</option>
                                                <option value="ENTREGADO" {{ $pago->estado_interno == 'ENTREGADO' ? 'selected' : '' }}>ENTREGADO</option>
                                                <option value="CANCELADO" {{ $pago->estado_interno == 'CANCELADO' ? 'selected' : '' }}>CANCELADO</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $pago->transaccion_id }}</td>
                                    <td>
                                        @if ($pago->direccion)
                                            Calle {{ $pago->direccion->calle }}, Ciudad {{ $pago->direccion->ciudad }},
                                            Estado {{ $pago->direccion->estado }}, C.P. {{ $pago->direccion->codigo_postal }}, No.
                                            Exterior {{ $pago->direccion->numero_exterior }},
                                            {{ $pago->direccion->pais }}
                                        @else
                                            Dirección no disponible
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pago->productos)
                                            @php
                                                $productos = json_decode($pago->productos, true);
                                            @endphp
                                            @if (is_array($productos))
                                                <ul>
                                                    @foreach ($productos as $producto)
                                                        <li>{{ $producto['nombre'] }} (ID: {{ $producto['id'] }})
                                                            (x{{ $producto['cantidad'] }})</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                {{ $pago->productos }}
                                            @endif
                                        @else
                                            No hay productos
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pagos.detalles', $pago->id) }}"
                                            class="btn btn-primary btn-sm">Detalles</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $pagos->links() }}
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const detallesBtns = document.querySelectorAll('.detalles-btn');

                    detallesBtns.forEach(btn => {
                        btn.addEventListener('click', function () {
                            const pagoId = this.getAttribute('data-pago-id');
                            fetch(`/pagos/${pagoId}/detalles`)
                                .then(response => response.json())
                                .then(data => {
                                    const detallesContenido = document.getElementById('detallesContenido');
                                    detallesContenido.innerHTML = `
                                        <h3>Información del Usuario</h3>
                                        <p>Nombre: ${data.usuario.name}</p>
                                        <p>Email: ${data.usuario.email}</p>
                                        <p>Teléfono: ${data.direccion.telefono || 'No disponible'}</p>

                                        <h3>Detalles del Pago</h3>
                                        <p>ID Transacción: ${data.pago.transaccion_id}</p>
                                        <p>Monto Total: $${data.pago.monto_total}</p>
                                        <p>Estado: ${data.pago.estado_interno}</p>
                                        <p>Detalles PayPal: ${JSON.stringify(JSON.parse(data.pago.detalles_pago), null, 2)}</p>

                                        <h3>Productos</h3>
                                        <ul>
                                            ${data.productos.map(producto => `
                                                <li>
                                                    ${producto.nombre} (x${producto.cantidad}) - ${producto.color || 'Sin color'} - $${producto.precio}
                                                </li>
                                            `).join('')}
                                        </ul>

                                        <h3>Dirección de Entrega</h3>
                                        <p>Calle: ${data.direccion.calle}</p>
                                        <p>Ciudad: ${data.direccion.ciudad}</p>
                                        <p>Estado: ${data.direccion.estado}</p>
                                        <p>C.P.: ${data.direccion.codigo_postal}</p>
                                        <p>No. Exterior: ${data.direccion.numero_exterior}</p>
                                        <p>País: ${data.direccion.pais}</p>
                                    `;
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    document.getElementById('detallesContenido').innerHTML = '<p>Error al cargar los detalles.</p>';
                                });
                        });
                    });
                });
            </script>
        </body>
        </html>
    @endauth
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>