<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formularios-pro.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
</head>

<body class="antialiased form-pro">

@include('header')

@php
    $imagenesIzq = array_values(array_filter([
        $img_izq_1->ruta_imagen ?? null,
        $img_izq_2->ruta_imagen ?? null,
        $img_izq_3->ruta_imagen ?? null,
    ]));

    $imagenesDer = array_values(array_filter([
        $img_der_1->ruta_imagen ?? null,
        $img_der_2->ruta_imagen ?? null,
        $img_der_3->ruta_imagen ?? null,
    ]));

    $layoutIzq = max(count($imagenesIzq), 1);
    $layoutDer = max(count($imagenesDer), 1);

    $tieneIzq = count($imagenesIzq) > 0;
    $tieneDer = count($imagenesDer) > 0;
@endphp

<style>
    .side-images-left, .side-images-right {
        display: flex !important;
        flex-direction: column;
        gap: 15px;
    }

    .side-images-left .img-box, .side-images-right .img-box {
        flex: 1;
        width: 100%;
        min-height: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .side-images-left .img-box img, .side-images-right .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
</style>

<main class="viewport-fix-main">
    <div class="cardform-grid-wrapper
        {{ !$tieneIzq && !$tieneDer ? 'grid-solo-form' : '' }}
        {{ $tieneIzq  && !$tieneDer ? 'grid-izq-form'  : '' }}
        {{ !$tieneIzq && $tieneDer  ? 'grid-form-der'  : '' }}">

        {{-- COLUMNA IZQUIERDA --}}
        @if($tieneIzq)
        <div class="side-images-left imgs-{{ $layoutIzq }}">
            @foreach($imagenesIzq as $ruta)
                <div class="img-box">
                    <img src="{{ asset($ruta) }}" alt="Imagen izquierda">
                </div>
            @endforeach
        </div>
        @endif

        {{-- FORMULARIO CENTRAL --}}
        <section class="cardform">
            <div class="form-container">

                <h2>REPARACIÓN</h2>

                {{-- ✅ Un solo <form>, correctamente cerrado al final --}}
                <form action="/submit_mantenimiento" method="POST">
                    @csrf
                    <input type="hidden" name="tipo" value="reparacion">

                    <!-- NOMBRE -->
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        @auth
                            <input type="text" id="nombre" name="nombre" value="{{ auth()->user()->name }}" required>
                        @else
                            <input type="text" id="nombre" name="nombre" required>
                        @endauth
                    </div>

                    <!-- OCUPACIÓN -->
                    <div class="form-group">
                        <label for="ocupacion">Ocupación:</label>
                        <input type="text" id="ocupacion" name="ocupacion" required>
                    </div>

                    <!-- CATEGORÍA -->
                    <div class="form-group">
                        <label for="tipo_maquina">Tipo de máquina:</label>
                        <select id="tipo_maquina" name="tipo_maquina" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach(App\Models\Categoria::all() as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PRODUCTO -->
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

                    <!-- DESCRIPCIÓN -->
                    <div class="form-group">
                        <label for="descripcion">Descripción del problema:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>

                    <!-- DIRECCIÓN -->
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>

                    <!-- ESTADO -->
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <input type="text" id="estado" name="estado" required>
                    </div>

                    <!-- CP -->
                    <div class="form-group">
                        <label for="codigo_postal">Código postal:</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" required>
                    </div>

                    <!-- CORREO -->
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

                    <!-- TEL -->
                    <div class="form-group">
                        <label for="numero_celular">Número de celular:</label>
                        <input type="tel" id="numero_celular" name="numero_celular" required>
                    </div>

                    <!-- BOTÓN -->
                    <div class="form-group">
                        <button type="submit" class="submit-btn">Enviar</button>
                    </div>

                </form>
                {{-- ✅ form cerrado aquí --}}

            </div>
        </section>

        {{-- COLUMNA DERECHA --}}
        @if($tieneDer)
        <div class="side-images-right imgs-{{ $layoutDer }}">
            @foreach($imagenesDer as $ruta)
                <div class="img-box">
                    <img src="{{ asset($ruta) }}" alt="Imagen derecha">
                </div>
            @endforeach
        </div>
        @endif

    </div>
</main>

@include('footer')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Filtro de productos por categoría ── */
        const categoriaSelect     = document.getElementById('tipo_maquina');
        const productoSelect      = document.getElementById('codigo_equipo');
        const productosOriginales = Array.from(productoSelect.options);

        categoriaSelect.addEventListener('change', function () {
            const categoriaId = this.value;
            productoSelect.innerHTML = '<option value="" disabled selected>Seleccione un producto</option>';
            productosOriginales.forEach(option => {
                if (option.dataset.categoria === categoriaId) {
                    productoSelect.appendChild(option.cloneNode(true));
                }
            });
        });

        /* ── Igualar altura de columnas laterales al formulario ── */
        function syncImageHeights() {
            const form   = document.querySelector('.cardform-grid-wrapper .cardform');
            const colIzq = document.querySelector('.side-images-left');
            const colDer = document.querySelector('.side-images-right');
            if (!form) return;
            const h = form.offsetHeight + 'px';
            if (colIzq) colIzq.style.height = h;
            if (colDer) colDer.style.height = h;
        }

        syncImageHeights();
        window.addEventListener('resize', syncImageHeights);
    });
</script>

</body>
</html>