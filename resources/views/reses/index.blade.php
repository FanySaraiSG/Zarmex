<x-app-layout>
    @auth('employee')
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
                crossorigin="anonymous">
            <title>Reseñas</title>
            <style>
                nav {
                    background-color: inherit !important;
                }

                .table {
                    background-color: white !important;
                }

                .info-button {
                    border-radius: 50%;
                    width: 30px;
                    height: 30px;
                    display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    cursor: pointer;
                }
            </style>
        </head>

        <body>
            <div class="container mt-5">
                <h1 style="text-align: center; color: aliceblue;">Reseñas</h1>
                @php
                    $employee = auth('employee')->user();
                    $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'soporte.dashboard';
                @endphp

                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{ route($dashboard) }}">
                        Regresar
                    </a>
                    <div class="d-flex">
                        <form action="{{ route('reseñas.index') }}" method="GET" class="me-2">
                            <select name="estatus" class="form-select">
                                <option value="">Todos los estados</option>
                                <option value="activo" {{ request('estatus') === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ request('estatus') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
                        </form>
                        <button type="button" class="info-button" data-bs-toggle="modal" data-bs-target="#infoModal">
                            ?
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoModalLabel">Información</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Se recomienda tener un máximo de ocho reseñas activas.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th hidden>#</th>
                                <th>Email</th>
                                <th>Descripción</th>
                                <th>Calificación</th>
                                <th>Estatus</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reseñas as $reseña)
                                <tr>
                                    <td hidden>{{ $loop->iteration }}</td>
                                    <td>{{ $reseña->email }}</td>
                                    <td>{{ $reseña->descripcion }}</td>
                                    <td>{{ $reseña->calificacion }}</td>
                                    <td>{{ ucfirst($reseña->estatus) }}</td>
                                    <td>{{ $reseña->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('reseñas.update', $reseña->id_reseña) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="estatus"
                                                value="{{ $reseña->estatus === 'inactivo' ? 'activo' : 'inactivo' }}">
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                {{ $reseña->estatus === 'inactivo' ? 'Activar' : 'Desactivar' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('reseñas.destroy', $reseña->id_reseña) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar esta reseña?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $reseñas->links() }}
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
    @endauth
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>