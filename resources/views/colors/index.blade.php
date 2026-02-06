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

            .color-box {
                width: 50px;
                /* Ancho del cuadro de color */
                height: 50px;
                /* Altura del cuadro de color */
                border-radius: 5px;
                /* Bordes redondeados */
                border: 1px solid #ddd;
                /* Borde gris claro */
                display: inline-block;
                /* Asegura que se muestre en línea con otros cuadros */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                /* Sombra para dar profundidad */
            }
        </style>
    </head>

    <body>
        @section('content')
        <div class="container mt-5">
        <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Colores</h1>
            <div class="d-flex justify-content-between mb-3">
                <a class="btn btn-secondary btn-sm" href="{{ route('admin.dashboard') }}">Regresar</a>
                <a class="btn btn-success btn-sm" href="{{ route('colors.create') }}">Añadir Color</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID Color</th>
                            <th>Nombre</th>
                            <th>Vista Previa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $color)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $color->id_color }}</td>
                                <td>{{ $color->nombre }}</td>
                                <td>
                                    <div class="color-box" style="background-color: #{{ $color->id_color }};"></div>
                                </td>

                                <td>
                                    <a href="{{ route('colors.edit', $color->id_color) }}"
                                        class="btn btn-primary btn-sm">Editar</a>
                                    <form action="{{ route('colors.destroy', ltrim($color->id_color, '#')) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar este color?')">Eliminar</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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