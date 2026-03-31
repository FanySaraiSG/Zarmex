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
            <title>Comentarios</title>
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
                <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Comentarios</h1>
                <div class="d-flex justify-content-between mb-3">
                    @php
                        $employee = auth('employee')->user();
                        $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'soporte.dashboard';
                      @endphp

                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="{{ route($dashboard) }}">
                            Regresar
                        </a>
                    </div>
                    <a href="{{ route('comentarios.index', ['orden' => $orden === 'asc' ? 'desc' : 'asc']) }}"
                        class="btn btn-primary btn-sm">
                        Ordenar por Calificación ({{ $orden === 'asc' ? 'Menor a Mayor' : 'Mayor a Menor' }})
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Producto</th>
                                <th>Calificación</th>
                                <th>Comentario</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comentarios as $comentario)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $comentario->usuario?->name ?? ($comentario->guest_name ?? 'Anónimo') }}</td>
                                    <td>{{ optional($comentario->producto)->nombre ?? $comentario->producto_id }}</td>
                                    <td>{{ str_repeat('★', $comentario->calificacion) . str_repeat('☆', 5 - $comentario->calificacion) }}
                                    </td>
                                    <td>{{ $comentario->comentario }}</td>
                                    <td>{{ $comentario->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <form action="{{ route('comentarios.destroy', $comentario->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar este comentario?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $comentarios->links() }}
                </div>
            </div>
        </body>

        </html>
        @if(session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif
    @endauth
</x-app-layout>