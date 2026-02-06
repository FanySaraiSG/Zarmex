<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <title>{{ config('app.name', 'Zarmex') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

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
                        <h2>Editar Producto</h2>
                        <div class="form-group d-flex justify-content-between mb-3">
                            <a class="btn btn-secondary btn-sm" href="{{ route('productos.index') }}">Regresar</a>
                        </div>
                
                        <form action="{{ route('productos.update', $producto->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                
                            <!-- Campo oculto para almacenar el ID original -->
                            <input type="hidden" name="id_original" value="{{ $producto->id }}">
                
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" id="id" name="id" value="{{ $producto->id }}">
                            </div>
                
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
                            </div>
                
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" rows="3">{{ $producto->descripcion }}</textarea>
                            </div>
                
                            <div class="form-group">
                                <label for="precio">Precio:</label>
                                <input type="number" id="precio" name="precio" step="0.01" value="{{ $producto->precio }}" required>
                            </div>
                
                            <div class="form-group">
                                <label for="stock">Stock:</label>
                                <input type="number" id="stock" name="stock" value="{{ $producto->stock }}" required>
                            </div>
                
                            <div class="form-group">
                                <label for="categoria_id">Categoría:</label>
                                <select id="categoria_id" name="categoria_id" required>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}" 
                                            {{ $producto->categoria_id == $categoria->id_categoria ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Mostrar Imagen Actual -->
                            <div class="form-group">
                                <label>Imagen Actual:</label>
                                @if($producto->imagen_url)
                                    <p>{{ basename($producto->imagen_url) }}</p>
                                    <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" width="100">
                                @else
                                    <p>No hay imagen disponible</p>
                                @endif
                            </div>
                
                            <!-- Campo para subir nueva imagen -->
                            <div class="form-group">
                                <label for="imagen_url">Subir nueva imagen:</label>
                                <input type="file" id="imagen_url" name="imagen_url" accept="image/*" onchange="mostrarNombre()">
                                <small id="nombreImagenDisplay" class="form-text text-muted">Nombre de la nueva imagen: <span></span></small>
                            </div>
                            
                
                            <div class="form-group">
                                <label for="fecha_creacion">Fecha de Creación:</label>
                                <input type="datetime-local" id="fecha_creacion" name="fecha_creacion"
                                    value="{{ $producto->fecha_creacion ? \Carbon\Carbon::parse($producto->fecha_creacion)->format('Y-m-d\TH:i') : '' }}">
                            </div>
                            <!-- Campos para las medidas -->
                        <div class="form-group">
                            <label for="largo">Largo (cm):</label>
                            <input type="number" id="largo" name="largo" value="{{ $producto->medida->largo ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="ancho">Ancho (cm):</label>
                            <input type="number" id="ancho" name="ancho" value="{{ $producto->medida->ancho ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="altura">Altura (cm):</label>
                            <input type="number" id="altura" name="altura" value="{{ $producto->medida->altura ?? '' }}" required>
                        </div>
                
                            <div class="form-group">
                                <button type="submit" class="submit-btn">Actualizar Producto</button>
                            </div>
                        </form>
                
                        <!-- Formulario para mostrar imágenes -->
                        <form action="{{ route('productos.imagenes.show', $producto->id) }}" method="GET" style="display: inline;">
                            <div>
                                <button type="submit" class="submit-btn">Mostrar Imágenes</button>
                            </div>
                        </form>
                    </div>
                </section>
                
                <script>
                    function mostrarNombre() {
                        const input = document.getElementById('imagen_url');
                        const display = document.getElementById('nombreImagenDisplay').querySelector('span');
                        display.textContent = input.files.length > 0 ? input.files[0].name : 'No seleccionada';
                    }
                </script>
                
        @else
            <div class="container mt-5">
                <div class="alert alert-danger text-center">
                    <h4>Access Denied</h4>
                    <p>You do not have permission to view this page.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        @endif
    @endauth