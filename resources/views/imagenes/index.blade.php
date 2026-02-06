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
      <title>Imágenes</title>
      <style>
        nav { background-color: inherit !important; }
        .table { background-color: white !important; }
        .img-preview { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
      </style>
    </head>
    <body>
      <div class="container mt-5">
        <!-- Botones superiores -->
        <h1 class="text-2xl font-bold text-center text-white">Imágenes</h1>
        <div class="d-flex justify-content-between mb-3">
          <a class="btn btn-secondary btn-sm" href="{{ route('admin.dashboard') }}">Regresar</a>
          <a class="btn btn-success btn-sm" href="{{ route('imagenes.create') }}">Subir Imagen</a>
        </div>
  
        <!-- Tabla de Imágenes -->
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
              <thead class="table-dark">
                  <tr>
                      <th>#</th>
                      <th>Sección</th>
                      <th>Vista Previa</th>
                      <th>Ruta</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($imagenes as $imagen)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ ucfirst(str_replace('_', ' ', $imagen->seccion)) }}</td>
                      <td>
                          <img src="{{ asset($imagen->imagen_url) }}" class="img-preview" alt="Imagen de {{ $imagen->seccion }}" style="width: 100px; height: auto;">
                      </td>
                      <td>{{ $imagen->imagen_url }}</td>
                      <td>
                        <a href="{{ route('imagenes.edit', $imagen->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta imagen?')">Eliminar</button>
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
  </x-app-layout>
  