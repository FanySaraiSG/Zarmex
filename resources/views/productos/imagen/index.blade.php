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
            <title>Imágenes del Producto</title>
            <style>
                nav { background-color: inherit !important; }
                .table { background-color: white !important; }
            </style>
        </head>

        <body>
            <div class="container mt-5">
                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{ route('productos.edit', $producto->id) }}">Regresar</a>
                    <a href="{{ route('productos.imagenes.create', $producto->id) }}" class="btn btn-success btn-sm">
                        Añadir Imagen
                    </a>
                </div>

                <h2 class="mb-4" style="color: white; text-align: center;">
                    Imágenes de {{ $producto->nombre }}
                </h2>

                <!-- Tabla de Imágenes -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>ID de Imagen</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($imagenes as $imagen)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    {{--  usar la PK real --}}
                                    <td>{{ $imagen->img_id }}</td>

                                    <td>
                                        <img src="{{ asset($imagen->ruta) }}?v={{ time() }}"
                                             alt="Imagen {{ $producto->nombre }}"
                                             width="50">
                                    </td>

                                    <td>
                                        {{--  pasar img_id a las rutas --}}
                                        <a href="{{ route('productos.imagenes.edit', $imagen->img_id) }}"
                                           class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <form action="{{ route('productos.imagenes.destroy', $imagen->img_id) }}"
                                              method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar esta imagen?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($imagenes->count() === 0)
                                <tr>
                                    <td colspan="4" class="text-center">No hay imágenes extra para este producto.</td>
                                </tr>
                            @endif
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
