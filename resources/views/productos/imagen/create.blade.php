<x-app-layout>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <title>{{ config('app.name', 'Zarmex') }}</title>   
    
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    @auth('employee')
    @if(Auth::user()->rol === 'admin')
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
    </head>
    <body>
    <section class="container mt-5">
        <div class="form-container">
                <div class="form-container">
                    <h2>Añadir Imagen a <br>{{ $producto->nombre }}</h2>
                    <div class="form-group d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="{{ route('productos.imagenes.show', $producto->id) }}">Regresar</a>
                    </div>
                    <form action="{{ route('productos.imagenes.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
    
                        <!-- ID del Producto (Oculto) -->
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
    
                        <div class="form-group">
                            <label for="imagen">Seleccionar Imagen:</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" required onchange="mostrarNombre(this)">
                            <small id="nombreImagenDisplay" class="form-text text-muted">Nombre de la imagen: <span></span></small>
                        </div>
    
                        <script>
                        function mostrarNombre(input) {
                            const nombreImagen = input.files[0] ? input.files[0].name : '';
                            document.getElementById('nombreImagenDisplay').getElementsByTagName('span')[0].innerText = nombreImagen;
                        }
                        </script>
    
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Subir Imagen</button>
                        </div>
                    </form>
                @endif
            @endauth
        </div>
    </section>
      @else
      <div class="container mt-5">
        <div class="alert alert-danger text-center">
          <h4>Access Denied</h4>
          <p>You do not have permission to view this page.</p>
          <a href="{{ route('dashboard') }}" class="btn btn-secondary">Go Back</a>
        </div>
      </div>
      </x-app-layout>
      