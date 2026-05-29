
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>   
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  @auth('employee')
    @if(Auth::user()->rol === 'admin')
      <!DOCTYPE html>
      <html lang="es">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <title>Editar Categoría</title>
        
      </head>
      <body>
        <div class="container mt-5">
          <div class="form-container">
            <h2 class="text-center">Editar Categoría</h2>
            <div class="form-group d-flex justify-content-between mb-3">
              <a  href="{{ route('categorias.index') }}">Regresar</a>
            </div>
            <form action="{{ route('categorias.update', $categoria->id_categoria) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                  value="{{ $categoria->nombre }}" required>
              </div>
              <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $categoria->descripcion }}</textarea>
              </div>
              <button type="submit" class="submit-btn mt-3">Actualizar Categoría</button>
            </form>
          </div>
        </div>
      </body>
      </html>
    @else
      <div class="container mt-5">
        <div class="alert alert-danger text-center">
          <h4>Acceso Denegado</h4>
          <p>No tienes permiso para acceder a esta página.</p>
          <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver</a>
        </div>
      </div>
    @endif
  @endauth

