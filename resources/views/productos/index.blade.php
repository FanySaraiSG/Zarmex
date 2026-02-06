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
            <title>Productos</title>
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
                <!-- Botones superiores -->
                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.dashboard') }}">Regresar</a>
                    <a class="btn btn-success btn-sm" href="{{ route('productos.create') }}">Añadir Producto</a>
                </div>

                <h2 class="mb-4" style="color: white; text-align: center;">{{ $categoriaNombre }}</h2>

                <!-- Tabla de Productos -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Categoría</th>
                                <th>Imagen</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ ($productos->currentPage() - 1) * $productos->perPage() + $loop->iteration }}</td>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td>{{ $producto->stock }}</td>
                                    <td>
                                        @if($producto->categoria)
                                            {{ $producto->categoria->nombre }}
                                        @else
                                            Sin categoría
                                        @endif
                                    </td>
                                    <td>
                                        @if($producto->imagen_url)
                                            <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" width="50">
                                        @else
                                            No disponible
                                        @endif
                                    </td>
                                    <td>{{ $producto->fecha_creacion }}</td>
                                    <td>
                                        <a href="{{ route('productos.edit', $producto->id) }}"
                                            class="btn btn-primary btn-sm">Editar</a>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $productos->links() }}
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