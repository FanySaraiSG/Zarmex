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
            <title>Mantenimientos</title>
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
                <h1 style="text-align: center; color: aliceblue;">Servicios</h1>

                @php
                    $employee = auth('employee')->user();
                    $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'tecnico.dashboard';
                @endphp

                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{ route($dashboard) }}">
                        Regresar
                    </a>

                    <!-- Filtro por Status -->
                    <form action="{{ route('mantenimientos.index') }}" method="GET" class="d-flex align-items-center">
                        <label for="status" class="form-label mb-0 me-2" style="color: aliceblue">Filtrar por Estado</label>
                        <select name="status" id="status" class="form-control form-control-sm me-2">
                            <option value="">Seleccionar Estado</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Ocupación</th>
                                <th hidden>Tipo de Máquina</th>
                                <th>Código de Equipo</th>
                                <th>Descripción</th>
                                <th>Dirección</th>
                                <th>Estado</th>
                                <th>Código Postal</th>
                                <th>Correo Electrónico</th>
                                <th>Número de Celular</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mantenimientos as $mantenimiento)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mantenimiento->nombre }}</td>
                                    <td>{{ $mantenimiento->ocupacion }}</td>
                                    <td hidden>{{ $mantenimiento->tipo_maquina }}</td>
                                    <td>{{ $mantenimiento->codigo_equipo }}</td>
                                    <td>{{ $mantenimiento->descripcion }}</td>
                                    <td>{{ $mantenimiento->direccion }}</td>
                                    <td>{{ $mantenimiento->estado }}</td>
                                    <td>{{ $mantenimiento->codigo_postal }}</td>
                                    <td>{{ $mantenimiento->correo_electronico }}</td>
                                    <td>{{ $mantenimiento->numero_celular }}</td>

                                    <td>
                                        <form action="{{ route('mantenimientos.updateStatus', $mantenimiento->id) }}"
                                            method="post" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control form-control-sm"
                                                onchange="this.form.submit()">
                                                <option value="En revisión" {{ $mantenimiento->status == 'En revisión' ? 'selected' : '' }}>En revisión</option>
                                                <option value="En procedimiento" {{ $mantenimiento->status == 'En procedimiento' ? 'selected' : '' }}>En procedimiento</option>
                                                <option value="En camino" {{ $mantenimiento->status == 'En camino' ? 'selected' : '' }}>En camino</option>
                                                <option value="Finalizado" {{ $mantenimiento->status == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                            </select>
                                        </form>
                                    </td>

                                    <td>
                                        <form action="{{ route('mantenimientos.destroy', $mantenimiento->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar este mantenimiento?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $mantenimientos->appends(request()->query())->links() }}
                </div>

            </div>
        </body>

        </html>
    @endauth
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>