<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zarmex</title>

    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formularios-pro.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="form-pro">

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

        {{-- ══════════════════════════════════════════
             FORMULARIO CENTRAL
        ══════════════════════════════════════════ --}}
        <section class="cardform">
            <div class="form-container">

                <h2>MANTENIMIENTO</h2>

                <form action="/submit_mantenimiento" method="POST" class="form-responsive-grid">
                    @csrf

                    <div class="form-group full-width">
                        <label for="nombre">Nombre: </label>
                        @auth
                            <input type="text" id="nombre" name="nombre" value="{{ auth()->user()->name }}" required>
                        @else
                            <input type="text" id="nombre" name="nombre" required>
                        @endauth
                    </div>

                    <div class="form-group">
                        <label for="ocupacion">Ocupación: </label>
                        <input type="text" id="ocupacion" name="ocupacion" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_maquina">Tipo de máquina: </label>
                        <select id="tipo_maquina" name="tipo_maquina" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach(App\Models\Categoria::all() as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="codigo_equipo">Código del equipo: </label>
                        <select id="codigo_equipo" name="codigo_equipo" required>
                            <option value="" disabled selected>Seleccione un producto</option>
                            @foreach(App\Models\Producto::all() as $producto)
                                <option value="{{ $producto->id }}" data-categoria="{{ $producto->categoria_id }}">
                                    {{ $producto->id }} - {{ $producto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="codigo_postal">Código postal: </label>
                        <input type="text" id="codigo_postal" name="codigo_postal" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="descripcion">Descripción del problema: </label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección: </label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado: </label>
                        <input type="text" id="estado" name="estado" required>
                    </div>

                    <div class="form-group">
                        <label for="correo_electronico">Correo electrónico: </label>
                        @auth
                            <input type="email" id="correo_electronico" name="correo_electronico" value="{{ auth()->user()->email }}" required>
                        @else
                            <input type="email" id="correo_electronico" name="correo_electronico" placeholder="Inicia sesión" required>
                        @endauth
                    </div>

                    <div class="form-group">
                        <label for="numero_celular">Número de celular: </label>
                        <input type="tel" id="numero_celular" name="numero_celular" required>
                    </div>

                    <div class="button-container-grid">
                        <button type="submit" class="submit-btn-grid">Enviar Solicitud</button>
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