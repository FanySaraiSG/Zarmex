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
            <title>Empleados</title>
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
                <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Empleados</h1>
                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.dashboard') }}">Regresar</a>
                    <a class="btn btn-success btn-sm" href="{{ route('employees.create') }}">Agregar Empleado</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Correo Electrónico</th>
                                <th>Número de Teléfono</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->telefono }}</td>
                                    <td>{{ $employee->rol }}</td>
                                    <td>
                                        @if (Auth::guard('employee')->user()->id_empleado !== $employee->id_empleado)
                                            <a href="{{ route('employees.edit', $employee->id_empleado) }}"
                                                class="btn btn-primary btn-sm">Editar</a>
                                            <form action="{{ route('employees.destroy', $employee->id_empleado) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro de eliminar este empleado?')">Eliminar</button>
                                            </form>
                                        @else
                                            <span>No disponible</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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