<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <!-- CSS ORIGINAL -->
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

    <!-- CSS SOLO FORMULARIOS -->
    <link rel="stylesheet" href="{{ asset('css/formularios-pro.css') }}">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
</head>

<!-- CLAVE -->
<body class="antialiased form-pro">

@include('header')

{{-- ══════════════════════════════════════════
     Compactar las imágenes eliminando huecos
     aunque la BD tenga posiciones salteadas
══════════════════════════════════════════ --}}
@php
    // Recopilar solo las imágenes que realmente existen, sin huecos
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
    /* ── Navegación entre secciones ── */
    .section-nav-bar {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 2px solid #e9ecef;
    }
    .section-nav-active,
    .section-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        letter-spacing: 0.03em;
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    }
    .section-nav-active {
        background: #2c3e50;
        color: #fff;
        cursor: default;
        pointer-events: none;
    }
    .section-nav-link {
        background: #f0f2f5;
        color: #495057;
        border: 1.5px solid #dee2e6;
    }
    .section-nav-link:hover {
        background: #2c3e50;
        color: #fff;
        border-color: #2c3e50;
        box-shadow: 0 2px 8px rgba(44,62,80,.18);
        text-decoration: none;
    }

    /* Hace que las columnas laterales se comporten como Flex containers */
    .side-images-left, .side-images-right {
        display: flex !important;
        flex-direction: column;
        gap: 15px; /* Separación suave entre imágenes */
    }

    /* Obliga a cada recuadro a tomar una fracción equitativa del alto */
    .side-images-left .img-box, .side-images-right .img-box {
        flex: 1; /* Si hay 1 ocupa el 100%, si hay 2 el 50%, si hay 3 el 33% */
        width: 100%;
        min-height: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Ajusta la imagen para cubrir el espacio sin deformarse */
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

        {{-- ══════════════════════════════════════════
             COLUMNA IZQUIERDA
        ══════════════════════════════════════════ --}}
        @if($tieneIzq)
        <div class="side-images-left imgs-{{ $layoutIzq }}">
            @foreach($imagenesIzq as $ruta)
                <div class="img-box">
                    <img src="{{ asset($ruta) }}" alt="Imagen izquierda">
                </div>
            @endforeach
        </div>
        @endif

    <section class="cardform">
        <div class="form-container">


            {{-- ── Navegación entre secciones ── --}}
            <div class="section-nav-bar">
                <a href="{{ route('mantenimiento') }}" class="section-nav-link">
                    <i class="fa-solid fa-wrench"></i> Mantenimiento
                </a>
                <span class="section-nav-active">
                    <i class="fa-solid fa-screwdriver-wrench"></i> Reparación
                </span>
            </div>

            <h2>REPARACIÓN</h2>

            <form action="/submit_mantenimiento" method="POST">
                @csrf

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

                <!-- SCRIPT -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const categoriaSelect = document.getElementById('tipo_maquina');
                        const productoSelect = document.getElementById('codigo_equipo');
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
                    });
                </script>

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

        </div>
    </section>

        {{-- ══════════════════════════════════════════
             COLUMNA DERECHA
        ══════════════════════════════════════════ --}}
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
