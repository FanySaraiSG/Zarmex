<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="antialiased">
@include('.header')
    <main>
        <section class="cardform">
            <div class="form-container">
                <h2>MANTENIMIENTO</h2>
                <form action="/submit_mantenimiento" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        @auth
                            <input type="text" id="nombre" name="nombre" value="{{ auth()->user()->name }}" required>
                        @else
                            <input type="text" id="nombre" name="nombre"
                                placeholder="Inicia sesión para llenar automáticamente" required>
                        @endauth
                    </div>

                    <div class="form-group">
                        <label for="ocupacion">Ocupación:</label>
                        <input type="text" id="ocupacion" name="ocupacion" required>
                    </div>


                    <div class="form-group">
                        <label for="tipo_maquina">Tipo de máquina:</label>
                        <select id="tipo_maquina" name="tipo_maquina" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach(App\Models\Categoria::all() as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="codigo_equipo">Código del equipo:</label>
                        <select id="codigo_equipo" name="codigo_equipo" required>
                            <option value="" disabled selected>Seleccione un producto</option>
                            @foreach(App\Models\Producto::all() as $producto)
                                <option value="{{ $producto->id }}" data-categoria="{{ $producto->categoria_id }}">
                                    {{ $producto->id }} - {{ $producto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const categoriaSelect = document.getElementById('tipo_maquina');
                            const productoSelect = document.getElementById('codigo_equipo');
                            const productosOriginales = Array.from(productoSelect.options); // Guardar las opciones originales

                            categoriaSelect.addEventListener('change', function () {
                                const categoriaId = this.value;

                                // Restaurar las opciones originales
                                productoSelect.innerHTML = '';
                                productosOriginales.forEach(option => {
                                    productoSelect.appendChild(option.cloneNode(true));
                                });

                                // Limpiar el select de productos
                                productoSelect.innerHTML = '<option value="" disabled selected>Seleccione un producto</option>';

                                // Filtrar y agregar productos según la categoría seleccionada
                                productosOriginales.forEach(option => {
                                    if (option.dataset.categoria === categoriaId) {
                                        productoSelect.appendChild(option.cloneNode(true));
                                    }
                                });
                            });
                        });
                    </script>

                    <div class="form-group">
                        <label for="descripcion">Descripción del problema:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <input type="text" id="estado" name="estado" required>
                    </div>

                    <div class="form-group">
                        <label for="codigo_postal">Código postal:</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" required>
                    </div>

                    <div class="form-group">
                        <label for="correo_electronico">Correo electrónico:</label>
                        @auth
                            <input type="email" id="correo_electronico" name="correo_electronico"
                                value="{{ auth()->user()->email }}" required>
                        @else
                            <input type="email" id="correo_electronico" name="correo_electronico"
                                placeholder="Inicia sesión para llenar automáticamente" required>
                        @endauth
                    </div>

                    <div class="form-group">
                        <label for="numero_celular">Número de celular:</label>
                        <input type="tel" id="numero_celular" name="numero_celular" required>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="submit-btn">Enviar</button>
                    </div>
                </form>
            </div>
        </section>



    </main>
    @include('footer')
</body>

</html>