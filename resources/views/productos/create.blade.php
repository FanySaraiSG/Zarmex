<x-app-layout>
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
        <section class="container mt-5">
        <div class="form-container">
                <div class="form-container">
                    <h2>Añadir Producto</h2>
                    <div class="form-group d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="{{ route('productos.index') }}">Regresar</a>
                    </div>
                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">

                        @csrf
                        <!-- Selección de Categoría -->
                        <div class="form-group">
                            <label for="categoria_id">Categoría:</label>
                            <select id="categoria_id" name="categoria_id" required onchange="generarIdProducto()">
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <!-- ID de la Categoría (Automático) -->
                        <div class="form-group">
                            <label for="id_categoria">ID de Categoría Seleccionado:</label>
                            <input type="text" id="id_categoria" name="id_categoria" readonly>
                        </div>
    
                        <!-- Identificador Único -->
                        <div class="form-group">
                            <label for="identificador">Identificador Único del Producto:</label>
                            <input type="text" id="identificador" name="identificador" required oninput="generarIdProducto()" placeholder="Ej: 001">
                        </div>
    
                        <!-- ID del Producto (Automático) -->
                        <div class="form-group">
                            <label for="id">ID del Producto (Generado Automáticamente):</label>
                            <input type="text" id="id" name="id" readonly required>
                        </div>
    
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
    
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
    
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" step="0.01" id="precio" name="precio" required>
                        </div>
    
                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input type="number" id="stock" name="stock" required>
                        </div>
    
                        <div class="form-group">
                            <label for="imagen_url" >Imagen:</label>
                            <input type="file" id="imagen_url" name="imagen_url" style="color: black;">
                        </div>
    
                        <h3>Medida del Producto</h3>
                    <div class="form-group" style="display: flex; gap: 10px;">
                        <div>
                            <label for="largo">Largo (cm):</label>
                            <input type="number" name="largo" id="largo" step="0.01" required>
                        </div>
                        <div>
                            <label for="ancho">Ancho (cm):</label>
                            <input type="number" name="ancho" id="ancho" step="0.01" required>
                        </div>
                        <div>
                            <label for="altura">Altura (cm):</label>
                            <input type="number" name="altura" id="altura" step="0.01" required>
                        </div>
                    </div>
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Crear Producto</button>
                        </div>
                    </form>
            @endif
        @endauth
    </div>
</section>

<script>
    function generarIdProducto() {
        var select = document.getElementById("categoria_id");
        var idCategoria = select.options[select.selectedIndex].value;
        document.getElementById("id_categoria").value = idCategoria;

        var identificador = document.getElementById("identificador").value;

        if (idCategoria && identificador) {
            document.getElementById("id").value = idCategoria + "-" + identificador;
        } else {
            document.getElementById("id").value = "";
        }
    }

    // Validación antes de enviar
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        form.addEventListener("submit", function (e) {
            const idField = document.getElementById("id");
            if (!idField.value) {
                e.preventDefault();
                alert("Por favor genera el ID del producto antes de continuar.");
            }
        });
    });
</script>

                        
                        
      
      @else
      <div class="container mt-5">
        <div class="alert alert-danger text-center">
          <h4>Access Denied</h4>
          <p>You do not have permission to view this page.</p>
          <a href="{{ route('dashboard') }}" class="btn btn-secondary">Go Back</a>
        </div>
      </div>
      </x-app-layout>
      