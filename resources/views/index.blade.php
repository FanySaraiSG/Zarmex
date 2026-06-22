<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/whatsapp-drag.js') }}"></script>

    <style>
        /* ===================== BANNER FLUIDO - AJUSTE DE AIRE ===================== */
       body > section,
        #carouselBanner, 
        #carouselBanner .carousel-inner, 
        #carouselBanner .carousel-item {
            height: 600px !important; /* ← ¡AQUÍ! Cambia este valor para modificar la altura real del carrusel */
            min-height: 700px !important;
        }

        /* 2. Forzamos a que la imagen cubra TODO el contenedor sin dejar espacios vacíos */
        .banner-media {
            width: 100% !important;
            height: 100% !important;
            /* 'fill' obliga a la imagen a adaptarse al molde exacto del carrusel sin cortar los textos */
            object-fit: fill !important; 
            display: block;
        }

        /* Ajuste opcional para pantallas de celulares */
        @media (max-width: 768px) {
            body > section, #carouselBanner, #carouselBanner .carousel-inner, #carouselBanner .carousel-item {
                height: 380px !important;
                min-height: 380px !important;
            }
        }
        /* ✅ Badge "Ver más" en banners con link */
        .banner-link-hint {
            position: absolute;
            bottom: 18px;
            right: 22px;
            background: rgba(0, 0, 0, 0.55);
            color: #fedc97;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(4px);
            pointer-events: none;
            transition: background 0.2s ease;
            z-index: 20;
        }
        .carousel-item a:hover .banner-link-hint {
            background: rgba(40, 102, 110, 0.88);
        }
        /* El <a> ocupa todo el slide y queda clicable */
        .carousel-item { position: relative; }
        .carousel-item > a {
            display: block;
            position: relative;
            z-index: 15;
            cursor: pointer;
        }
        /* Botones prev/next por encima del enlace */
        #carouselBanner .carousel-control-prev,
        #carouselBanner .carousel-control-next {
            z-index: 30;
        }

        .whatsapp-float {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            font-size: 2em;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 999999;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            color: white;
        }

        /* ===================== CARRUSEL PASARELA ALINEADO AL CENTRO ===================== */
        .products {
            padding: 40px 0 !important;
        }

        .best-sellers-wrap { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 0 40px;  
            position: relative;
        }

        .zx-title-playfair { 
            font-family: "Playfair Display", serif !important; 
            font-weight: 700; 
            letter-spacing: .5px; 
        }

        /* Contenedor del escenario del carrusel */
        .custom-carousel-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding: 40px 0;
        }

        /* La pista que se mueve usando flexbox centrado */
        .custom-carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: transform;
        }

        /* Cada celda individual (ocupa un tercio exacto en pantallas grandes) */
        .custom-carousel-item {
            flex: 0 0 100%;
            padding: 0 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.5s ease-in-out;
        }

        @media (min-width: 768px) {
            .custom-carousel-item {
                flex: 0 0 33.333333%;
            }
        }

        /* ── Estilo Base de las Tarjetas de los lados (Atrás) ── */
        .best-card {
            background: #fff;
            border-radius: 30px;
            border: 1px solid #eee;
            box-shadow: 0 10px 20px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 90%;
            overflow: hidden;
            
            /* Transiciones ultra fluidas */
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.5s ease, opacity 0.5s ease, filter 0.5s ease;
            
            /* Efecto Por Defecto: Más pequeñas, opacas y con un desenfoque sutil */
            transform: scale(0.85);
            opacity: 0.5;
            filter: blur(1px);
        }

        /* ── ¡EFECTO EN EL CENTRO! La tarjeta del medio toma el frente ── */
        .custom-carousel-item.center .best-card {
            transform: scale(1.08); 
            opacity: 1;             
            filter: none;           
            box-shadow: 0 20px 45px rgba(40, 102, 110, 0.28); 
            position: relative;
            z-index: 5; 
        }

        /* Hover interactivo controlado exclusivo para la tarjeta del centro */
        @media (min-width: 768px) {
            .custom-carousel-item.center .best-card:hover {
                transform: scale(1.12) translateY(-8px);
                box-shadow: 0 25px 55px rgba(40, 102, 110, 0.38);
            }
        }

        .best-card img { 
            width: 100%; 
            height: 270px; 
            object-fit: cover; 
            background: #FFF; 
            padding: 20px; 
            border-radius: 30px;
        }

        .best-card h3 { 
            font-size: 1.1em; 
            margin: -12px 0 8px; 
            color: #28666e; 
            font-weight: 700; 
            text-align: center; 
        }

        .best-btn {
            display: block; 
            text-align: center; 
            background: #28666e; 
            color: #fedc97;
            padding: 5px 8px; 
            border-radius: 8px; 
            font-weight: 700; 
            border: none;
            width: calc(100% - 32px); 
            margin: 0 16px 16px; 
            cursor: pointer;
            transition: background .25s ease, transform .2s ease;
        }

        .best-btn:hover { 
            background: #5dbbc7; 
            transform: translateY(-1px); 
            color: #fff; 
        }

        /* Flechas de Control Laterales */
        .custom-carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #ddd;
            border-radius: 30%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: background-color 0.25s ease, transform 0.2s ease, box-shadow 0.2s ease;
            z-index: 10;
            user-select: none;
        }

        .custom-carousel-control:hover {
            background-color: #28666e;
            box-shadow: 0 6px 16px rgba(40, 102, 110, 0.3);
            transform: translateY(-50%) scale(1.05);
            color: #fff;
        }

        .custom-carousel-control i {
            color: #333;
            font-size: 16px;
            transition: color 0.25s ease;
        }

        .custom-carousel-control:hover i {
            color: #fff;
        }

        .custom-carousel-control.prev { left: -5px; }
        .custom-carousel-control.next { right: -5px; }

        /* ===== Botones de secciones ===== */
        .best-section-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 0 0 25px;
            position: relative;
            z-index: 3;
        }

        .best-section-action-btn {
            background: rgba(40,102,110,0.92);
            color: #fedc97;
            border: 1px solid rgba(184,161,32,0.35);
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: 800;
            cursor: pointer;
            transition: transform .2s ease, background .2s ease, color .2s ease;
        }

        .best-section-action-btn:hover {
            transform: translateY(-2px);
            background: #28666e;
            color: #fff;
        }

        .best-section-action-btn.active {
            background: #1a4a50;
            color: #fedc97;
            box-shadow: 0 8px 20px rgba(20,85,85,0.25);
        }

        /* ===================== MODAL VER MÁS ESTILO VERMAS ===================== */
.prod-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.58);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.prod-overlay.open {
    display: flex;
}

.zx-prod-modal{
    width:min(1280px,92vw);
    max-height:88vh;
    background: #dff4f0;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(0,0,0,.35);
    animation: prodPopIn .22s ease;
}

@keyframes prodPopIn {
    from { opacity: 0; transform: scale(.94); }
    to { opacity: 1; transform: scale(1); }
}

.zx-prod-header {
    background: #143f43;
    color: #fff;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.zx-prod-header h3 {
    margin: 0;
    font-size: 1.15rem;
    font-weight: 900;
    color: #fff;
}

.zx-prod-close {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 1.6rem;
    cursor: pointer;
}

.zx-prod-body {
    display: grid;
    grid-template-columns: 90px 1.15fr .9fr;
    gap: 26px;
    padding: 24px 28px 20px;
}

.zx-prod-thumbs {
    display: flex;
    flex-direction: column;
    gap: 14px;
    max-height: 470px;
    overflow-y: auto;
    padding-right: 4px;
}

.zx-thumb-btn {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    border: 2px solid transparent;
    overflow: hidden;
    background: #cde9e3;
    cursor: pointer;
    padding: 3px;
    flex: 0 0 auto;
    position: relative;
}

.zx-thumb-btn.active {
    border-color: #143f43;
    box-shadow: 0 0 0 3px rgba(20,63,67,.18);
}

.zx-thumb-btn img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    display: block;
}

.zx-thumb-btn .video-dot {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.32);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

.zx-prod-gallery {
    position: relative;
    background: #d1ebe4;
    border-radius: 20px;
    min-height: 320px;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.zx-prod-track {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform .35s cubic-bezier(.23,1,.32,1);
    will-change: transform;
}

.zx-prod-slide {
    min-width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #d1ebe4;
}

.zx-prod-slide img {
    width: 100%;
    height: 100%;
    max-height: 430px;
    object-fit: contain;
    object-position: center;
    padding: 4px;
}

.zx-prod-slide iframe {
    width: 100%;
    height: 360px;
    border: 0;
    display: block;
    background: #000;
}

.zx-prod-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(20,63,67,.86);
    color: #9ee7e3;
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    z-index: 5;
    font-size: 2rem;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.zx-prod-arrow:hover {
    background: #143f43;
    color: #fff;
}

.zx-prod-arrow.left { left: 18px; }
.zx-prod-arrow.right { right: 18px; }

.zx-prod-info {
    display: flex;
    flex-direction: column;
    gap: 28px;
    padding-top: 6px;
}

.zx-info-block {
    border-left: 4px solid #143f43;
    padding-left: 16px;
}

.zx-info-block h4 {
    color: #143f43;
    font-size: .88rem;
    font-weight: 900;
    letter-spacing: 1.5px;
    margin: 0 0 10px;
}

.zx-info-block p {
    color: #143f43;
    line-height: 1.65;
    margin: 0;
    font-size: .95rem;
}

.zx-prod-colors {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.zx-prod-color {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,.18);
    cursor: pointer;
    transition: transform .15s ease, outline .15s ease;
}

.zx-prod-color:hover {
    transform: scale(1.1);
}

.zx-prod-color.selected {
    outline: 4px solid #143f43;
}

.zx-color-name {
    font-style: italic;
    opacity: .75;
    margin-top: 8px !important;
}

.zx-prod-docs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.zx-prod-docs a {
    background: #143f43;
    color: #fff;
    padding: 8px 14px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 800;
    font-size: .82rem;
}

.zx-prod-docs a:hover {
    color: #fedc97;
}

.zx-prod-footer {
    border-top: 1px solid rgba(20,63,67,.12);
    padding: 10px 28px 14px;
    display: flex;
    justify-content: flex-end;
}

.zx-whatsapp-btn {
    background: #25d366;
    color: #fff;
    border: none;
    border-radius: 13px;
    padding: 11px 34px;
    font-size: 1rem;
    font-weight: 900;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.zx-whatsapp-btn:hover {
    background: #1ebe5d;
}

@media(max-width: 992px) {
    .zx-prod-body {
        grid-template-columns: 1fr;
    }

    .zx-prod-thumbs {
        flex-direction: row;
        order: 2;
        max-height: none;
        overflow-x: auto;
        overflow-y: hidden;
    }

    .zx-prod-gallery {
    height: 430px;
    min-height: 430px;
}

    .zx-prod-info {
        order: 3;
    }

    .zx-prod-footer {
        justify-content: center;
    }
}

        /* ===================== SECCIÓN RESEÑAS ===================== */
        .resenas-nav { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
        .resenas-nav-btn {
            padding: 8px 22px; border-radius: 999px; border: 2px solid #28666e;
            background: transparent; color: #28666e; font-weight: 700;
            font-size: 0.88em; cursor: pointer; transition: background .25s, color .25s, transform .2s;
        }
        .resenas-nav-btn:hover, .resenas-nav-btn.active { background: #28666e; color: #fedc97; transform: translateY(-2px); }
        
        .resenas-grid { display: none; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .resenas-grid.active { display: grid; }
        
        .resena-prod-card { background: #fff; border: 1px solid #ddd; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.10); transition: transform .25s ease; }
        .resena-prod-card img { width: 100%; height: 200px; object-fit: contain; background: #f7f7f7; padding: 16px; }

        @media (max-width: 768px) {
            .prod-modal-body { grid-template-columns: 1fr; }
            .prod-carousel-wrap { border-right: none; border-bottom: 1px solid #eee; }
            .resenas-grid.active { grid-template-columns: 1fr; }
            .best-sellers-wrap { padding: 0 40px; } 
        }
    </style>
</head>

<body class="antialiased">
    @include('header')

    <section>
        @php
            $bannerImages = \App\Models\Imagen::whereIn('seccion', ['banner', 'banner_principal'])->get();
        @endphp

        @if($bannerImages->isNotEmpty())
            <div id="carouselBanner" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach($bannerImages as $index => $image)
                        @php
                            $extension = strtolower(pathinfo($image->imagen_url, PATHINFO_EXTENSION));
                            $esVideo   = in_array($extension, ['mp4','webm','ogg','mov','avi']);
                        @endphp

                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            @if($image->link_url)
                                {{-- ✅ Recurso CLICKEABLE con redirección --}}
                                <a href="{{ $image->link_url }}" target="_blank" rel="noopener noreferrer" style="display:block; position:relative;">
                                    @if($esVideo)
                                        <video class="banner-video banner-media" autoplay muted loop playsinline>
                                            <source src="{{ asset($image->imagen_url) }}" type="video/{{ $extension === 'mov' ? 'mp4' : $extension }}">
                                        </video>
                                    @else
                                        <img src="{{ asset($image->imagen_url) }}" class="banner-media" alt="Banner">
                                    @endif
                                    <span class="banner-link-hint">
                                        <i class="fas fa-external-link-alt"></i> Ver más
                                    </span>
                                </a>
                            @else
                                {{-- Recurso normal sin redirección --}}
                                @if($esVideo)
                                    <video class="banner-video banner-media" autoplay muted loop playsinline>
                                        <source src="{{ asset($image->imagen_url) }}" type="video/{{ $extension === 'mov' ? 'mp4' : $extension }}">
                                        Tu navegador no soporta video HTML5
                                    </video>
                                @else
                                    <img src="{{ asset($image->imagen_url) }}" class="banner-media" alt="Banner">
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @else
            <div class="content-area">
                <img src="{{ asset('imagenes/banner.jpeg') }}" alt="Banner Predeterminado" class="banner-media">
            </div>
        @endif

        {{-- ===================== PRODUCTOS DESTACADOS ===================== --}}
        <section class="products">
            <h2 class="text-center zx-title-playfair" style="color:#28666e; font-size:2em; margin-top: -40px; margin-bottom: 20px;">PRODUCTOS DESTACADOS</h2>

            <div class="best-sellers-wrap">

                @php
                    // Secciones únicas reales desde la BD, en el orden en que aparecen
                    $seccionesCarrusel = ($topProducts ?? collect())
                        ->pluck('section')
                        ->filter()
                        ->unique()
                        ->reject(fn($s) => strtolower($s) === 'todos')
                        ->values();
                @endphp

                {{-- Botón "Todos" siempre visible; los demás solo si hay secciones en la BD --}}
                @if(($topProducts ?? collect())->count() > 0)
                <div class="best-section-actions" aria-label="Secciones de productos destacados">
                    <button type="button" class="best-section-action-btn active" data-filter="todos">Todos</button>
                    @foreach($seccionesCarrusel as $seccion)
                        <button type="button" class="best-section-action-btn" data-filter="{{ $seccion }}">
                            {{ ucfirst($seccion) }}
                        </button>
                    @endforeach
                </div>
                @endif

                @if(($topProducts ?? collect())->count() === 0)
                    <div style="text-align:center; color:#666; padding: 24px;">No hay productos destacados disponibles.</div>
                @else

                    {{-- PASARELA CON DESPLAZAMIENTO CENTRADO --}}
                    <div class="custom-carousel-container">
                        <div class="custom-carousel-track" id="pasarelaTrack">
                            @foreach($topProducts as $topProduct)
                                @if($topProduct->product)
                                    @php
                                        $prod = $topProduct->product;

                                        // ── Imágenes: usa la relación imagenes() → columna 'ruta' ──
                                        // Si no hay imágenes extra, cae en imagen_url (que ya tiene asset() via accessor)
                                        $imgArr = [];
                                        if ($prod->imagenes && $prod->imagenes->count() > 0) {
                                            foreach ($prod->imagenes as $img) {
                                                $imgArr[] = asset($img->ruta);
                                            }
                                        }
                                        // imagen_url ya pasa por el accessor getImagenUrlAttribute que aplica asset()
                                        if (empty($imgArr) && $prod->imagen_url) {
                                            $imgArr[] = $prod->imagen_url;
                                        }
                                        if (empty($imgArr)) {
                                            $imgArr[] = asset('Imagenes/84493-4540581.jpg');
                                        }

                                        // ── Colores: relación colores() → Color ──
                                        // Pasamos los atributos RAW para detectar el nombre correcto del campo hex
                                        $coloresMap = [];
                                        $coloresRaw = [];
                                        if ($prod->colores && $prod->colores->count() > 0) {
                                            foreach ($prod->colores as $color) {
                                                $coloresRaw[] = $color->getAttributes(); // debug
                                                $hex = '#' . ltrim($color->id_color, '#');
                                                $coloresMap[$hex] = $color->nombre;
                                            }
                                        }

                                        // ── Documentos ──
                                        $docs = [];
                                        if (!empty($prod->doc1_url)) $docs[] = ['label' => 'Garantía',          'url' => asset($prod->doc1_url)];
                                        if (!empty($prod->doc2_url)) $docs[] = ['label' => 'Manual de Usuario', 'url' => asset($prod->doc2_url)];
                                        if (!empty($prod->doc3_url)) $docs[] = ['label' => 'Ficha Técnica',     'url' => asset($prod->doc3_url)];
                                    @endphp
                                    <div class="custom-carousel-item" data-section="{{ $topProduct->section ?? '' }}">
                                        <div class="best-card">
                                            <img src="{{ $imgArr[0] }}" alt="{{ $prod->nombre ?? 'Producto' }}">
                                            <h3>{{ $prod->id }}</h3>
                                            <button class="best-btn"
                                                data-nombre="{{ $prod->nombre ?? 'Producto' }}"
                                                data-desc="{{ $prod->descripcion ?? '' }}"
                                                data-imagenes="{{ json_encode($imgArr) }}"
                                                data-colores="{{ json_encode($coloresMap) }}"
                                                data-debug-colores="{{ json_encode($coloresRaw) }}"
                                                data-video="{{ $prod->video_url ?? '' }}"
                                                data-docs="{{ json_encode($docs) }}"
                                                onclick="abrirProdModalDesdeBtn(this)">
                                                Ver más
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="custom-carousel-control prev" onclick="moverPasarela(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="custom-carousel-control next" onclick="moverPasarela(1)">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                @endif
            </div>

            {{-- ── MODAL VER MÁS ESTILO VERMAS ── --}}
<div class="prod-overlay" id="prodOverlay" onclick="if(event.target===this) cerrarProdModal()">
    <div class="zx-prod-modal">

        <div class="zx-prod-header">
            <h3 id="pm-nombre">Producto</h3>
            <button type="button" class="zx-prod-close" onclick="cerrarProdModal()" aria-label="Cerrar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="zx-prod-body">

            <div class="zx-prod-thumbs" id="pm-thumbs"></div>

            <div class="zx-prod-gallery">
                <button type="button" class="zx-prod-arrow left" onclick="pmMover(-1)">‹</button>
                <div class="zx-prod-track" id="pm-track"></div>
                <button type="button" class="zx-prod-arrow right" onclick="pmMover(1)">›</button>
            </div>

            <div class="zx-prod-info">

                <div class="zx-info-block">
                    <h4>DESCRIPCIÓN DEL EQUIPO</h4>
                    <p id="pm-desc">Sin descripción.</p>
                </div>

                <div class="zx-info-block">
                    <h4>COLORES DISPONIBLES</h4>
                    <div class="zx-prod-colors" id="pm-colors"></div>
                    <p class="zx-color-name" id="pm-color-name">Selecciona un color</p>
                </div>

                <div class="zx-info-block" id="pm-docs-wrap" style="display:none;">
                    <h4>DOCUMENTACIÓN OFICIAL</h4>
                    <div id="pm-docs-links" class="zx-prod-docs"></div>
                </div>

            </div>
        </div>

        <div class="zx-prod-footer">
            <button type="button" class="zx-whatsapp-btn" onclick="abrirWhatsapp()">
                <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
            </button>
        </div>

    </div>
</div>

            <script>
                let currentIndex = 0;
                let visibleItems = [];

                // Delegación de eventos en los botones de sección (sustituye los onclick inline)
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.best-section-action-btn').forEach(btn => {
                        btn.addEventListener('click', function () {
                            document.querySelectorAll('.best-section-action-btn')
                                    .forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            initPasarela();
                        });
                    });

                    initPasarela();
                });

                function initPasarela() {
                    const allItems  = Array.from(document.querySelectorAll('.custom-carousel-item'));
                    const activeBtn = document.querySelector('.best-section-action-btn.active');
                    // data-filter="todos" significa mostrar todo; cualquier otro valor filtra por sección exacta
                    const filtro    = activeBtn ? activeBtn.dataset.filter : 'todos';

                    visibleItems = allItems.filter(item => {
                        const mostrar = filtro === 'todos' || item.dataset.section === filtro;
                        item.style.display = mostrar ? 'flex' : 'none';
                        return mostrar;
                    });

                    currentIndex = 0;
                    actualizarPasarela();
                }

                function moverPasarela(direccion) {
                    if (visibleItems.length === 0) return;
                    currentIndex = (currentIndex + direccion + visibleItems.length) % visibleItems.length;
                    actualizarPasarela();
                }

                function actualizarPasarela() {
                    const track = document.getElementById('pasarelaTrack');
                    if (!track || visibleItems.length === 0) return;

                    const isMobile = window.innerWidth < 768;

                    visibleItems.forEach(item => item.classList.remove('center'));
                    if (visibleItems[currentIndex]) {
                        visibleItems[currentIndex].classList.add('center');
                    }

                    let targetDesplazamiento = 0;
                    if (isMobile) {
                        targetDesplazamiento = -currentIndex * 100;
                    } else {
                        targetDesplazamiento = -(currentIndex * 33.333333) + 33.333333;
                    }

                    track.style.transform = `translateX(${targetDesplazamiento}%)`;
                }

                window.addEventListener('resize', actualizarPasarela);

                // Autoplay — se pausa al pasar el cursor y al abrir el modal
                let autoPlayInterval = setInterval(() => moverPasarela(1), 4500);

                function pausarCarrusel() { clearInterval(autoPlayInterval); autoPlayInterval = null; }
                function reanudarCarrusel() {
                    if (!autoPlayInterval) autoPlayInterval = setInterval(() => moverPasarela(1), 3500);
                }

                const container = document.querySelector('.custom-carousel-container');
                if (container) {
                    container.addEventListener('mouseenter', pausarCarrusel);
                    container.addEventListener('mouseleave', reanudarCarrusel);
                }


                
/* ── MODAL DE DETALLE ESTILO VERMAS ── */
let pmSlides = [], pmCur = 0, pmNombreActual = '';

function convertirUrlEmbed(url) {
    if (!url) return '';

    let m = url.match(/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/);
    if (m) {
        return `https://www.youtube.com/embed/${m[1]}?rel=0&modestbranding=1&iv_load_policy=3`;
    }

    m = url.match(/vimeo\.com\/(\d+)/);
    if (m) {
        return `https://player.vimeo.com/video/${m[1]}?title=0&byline=0&portrait=0`;
    }

    return url;
}

function abrirProdModalDesdeBtn(btn) {
    const nombre   = btn.getAttribute('data-nombre') || 'Producto';
    const desc     = btn.getAttribute('data-desc') || '';
    const imagenes = JSON.parse(btn.getAttribute('data-imagenes') || '[]');
    const colores  = JSON.parse(btn.getAttribute('data-colores')  || '{}');
    const video    = btn.getAttribute('data-video') || '';
    const docs     = JSON.parse(btn.getAttribute('data-docs') || '[]');

    const debugColores = btn.getAttribute('data-debug-colores');
    if (debugColores) console.log('[DEBUG colores RAW]', JSON.parse(debugColores));

    pausarCarrusel();
    abrirProdModal(nombre, desc, imagenes, colores, video, docs);
}

function abrirProdModal(nombre, desc, imagenes, colores, videoUrl, docs) {
    pmNombreActual = nombre;

    const titulo = document.getElementById('pm-nombre');
    const descripcion = document.getElementById('pm-desc');
    const overlay = document.getElementById('prodOverlay');

    if (titulo) titulo.textContent = nombre;
    if (descripcion) descripcion.textContent = desc || 'Sin descripción.';

    renderColores(colores);
    renderDocumentos(docs);

    pmSlides = (imagenes && imagenes.length > 0)
        ? imagenes.map((src, i) => ({ type: 'img', src, label: `Imagen ${i + 1}` }))
        : [{ type: 'img', src: '{{ asset("Imagenes/84493-4540581.jpg") }}', label: 'Imagen 1' }];

    const embedUrl = convertirUrlEmbed(videoUrl);
    if (embedUrl) {
        pmSlides.push({ type: 'video', src: embedUrl, label: 'Video' });
    }

    pmCur = 0;
    pmRenderTrack();

    if (overlay) overlay.classList.add('open');
}

function renderColores(colores) {
    const cw = document.getElementById('pm-colors');
    const colorLabel = document.getElementById('pm-color-name');

    if (!cw || !colorLabel) return;

    cw.innerHTML = '';
    colorLabel.style.display = '';
    colorLabel.textContent = 'Selecciona un color';

    const coloresEntries = Object.entries(colores || {});

    if (coloresEntries.length > 0) {
        coloresEntries.forEach(([hex, nombreColor], index) => {
            const sw = document.createElement('button');
            sw.type = 'button';
            sw.className = 'zx-prod-color' + (index === 0 ? ' selected' : '');
            sw.style.background = hex;
            sw.title = nombreColor;
            sw.setAttribute('aria-label', nombreColor);

            if (index === 0) {
                colorLabel.textContent = nombreColor;
            }

            sw.onclick = () => {
                cw.querySelectorAll('.zx-prod-color').forEach(s => s.classList.remove('selected'));
                sw.classList.add('selected');
                colorLabel.textContent = nombreColor;
            };

            cw.appendChild(sw);
        });
    } else {
        cw.innerHTML = '<span style="font-size:0.9rem;color:#143f43;font-style:italic;opacity:.7;">No especificados</span>';
        colorLabel.style.display = 'none';
    }
}

function renderDocumentos(docs) {
    const docsWrap  = document.getElementById('pm-docs-wrap');
    const docsLinks = document.getElementById('pm-docs-links');

    if (!docsWrap || !docsLinks) return;

    docsLinks.innerHTML = '';

    if (docs && docs.length > 0) {
        docs.forEach(doc => {
            const a = document.createElement('a');
            a.href = doc.url;
            a.target = '_blank';
            a.rel = 'noopener noreferrer';
            a.innerHTML = `<i class="far fa-file-pdf"></i> ${doc.label}`;
            docsLinks.appendChild(a);
        });

        docsWrap.style.display = 'block';
    } else {
        docsWrap.style.display = 'none';
    }
}

function cerrarProdModal() {
    const overlay = document.getElementById('prodOverlay');
    if (overlay) overlay.classList.remove('open');

    document.querySelectorAll('#pm-track iframe').forEach(f => f.src = '');
    reanudarCarrusel();
}

function pmRenderTrack() {
    const track = document.getElementById('pm-track');
    const thumbs = document.getElementById('pm-thumbs');

    if (!track || !thumbs) return;

    track.innerHTML = pmSlides.map(s => {
        if (s.type === 'video') {
            return `
    <div class="zx-prod-slide">
        <img src="${s.src}" alt="${s.label}">
    </div>
`;
        }

        return `
    <div class="zx-prod-slide">
        <img
            src="${s.src}"
            alt="${s.label}"
            onload="ajustarImagen(this)">
    </div>
`;
    }).join('');

    thumbs.innerHTML = pmSlides.map((s, i) => {
        const thumbSrc = s.type === 'video' ? (pmSlides[0]?.src || '') : s.src;
        const icon = s.type === 'video'
            ? `<span class="video-dot"><i class="fas fa-play"></i></span>`
            : '';

        return `
            <button type="button"
                class="zx-thumb-btn ${i === pmCur ? 'active' : ''}"
                onclick="pmIrA(${i})"
                title="${s.label}">
                <img src="${thumbSrc}" alt="${s.label}">
                ${icon}
            </button>
        `;
    }).join('');

    track.style.transform = `translateX(-${pmCur * 100}%)`;
}

function pmRenderDots() {
    document.querySelectorAll('.zx-thumb-btn').forEach((btn, i) => {
        btn.classList.toggle('active', i === pmCur);
    });
}

function pmMover(dir) {
    if (pmSlides.length <= 1) return;

    const currentSlide = document.querySelectorAll('#pm-track .zx-prod-slide')[pmCur];
    if (currentSlide) {
        const iframe = currentSlide.querySelector('iframe');
        if (iframe) iframe.src = iframe.src;
    }

    pmCur = (pmCur + dir + pmSlides.length) % pmSlides.length;

    const track = document.getElementById('pm-track');
    if (track) track.style.transform = `translateX(-${pmCur * 100}%)`;

    pmRenderDots();
}

function pmIrA(idx) {
    pmCur = idx;

    const track = document.getElementById('pm-track');
    if (track) track.style.transform = `translateX(-${pmCur * 100}%)`;

    pmRenderDots();
}

function ajustarImagen(img){

    const proporcion = img.naturalWidth / img.naturalHeight;

    // Imagen muy vertical
    if(proporcion < 0.85){
        img.style.objectFit = "contain";
    }

    // Imagen normal
    else{
        img.style.objectFit = "cover";
    }

}



                function abrirWhatsapp() {
                    const colorSeleccionado = document.getElementById('pm-color-name').textContent;
                    const textoColor = (colorSeleccionado && colorSeleccionado !== 'Selecciona un color')
                        ? ` en color ${colorSeleccionado}` : '';
                    const mensaje = encodeURIComponent(
                        `Hola Zarmex, me interesa obtener más información del producto: ${pmNombreActual}${textoColor}`
                    );
                    window.open(`https://wa.me/525581366555?text=${mensaje}`, '_blank');
                }
            </script>
        </section>

{{-- Seccion de reseñas  --}}






       <section class="testimonials py-5" id="resenasDestacadasSection" style="display: block; width: 100%; position: relative;">
    @php
        // 1. Ordenamos todas las reseñas por la cantidad de likes de forma descendente
        $reseñasOrdenadas = ($reseñas ?? collect())->sortByDesc(function($r) {
            return $r->likes_count ?? $r->likes ?? 0;
        });

        // 2. Agrupamos las reseñas por su calificación para el menú de navegación inferior
        $resenasPorPuntuacion = $reseñasOrdenadas->groupBy(function($r) {
            $estrellas = (int)($r->calificacion ?? 0);
            return $estrellas . ($estrellas === 1 ? ' Estrella' : ' Estrellas');
        })->sortByDesc(function($value, $key) {
            return (int)$key;
        });

        $puntuacionesDisponibles = $resenasPorPuntuacion->keys();

        // ✅ imagen de fallback en caso de que el producto no tenga imagen
        $imagenFallback = asset('Imagenes/84493-4540581.jpg');
    @endphp

    <div class="container">
        <h2 class="text-center mb-2 zx-title-playfair">Reseñas Destacadas</h2>
        
        {{-- BOTONES DE ACCIÓN PRINCIPALES --}}
        <div class="text-center mb-4">
            <button type="button" class="btn btn-light" id="btnMostrarAgregarResena" style="border: 1px solid #28666e; color: #28666e;">
                Agregar reseña
            </button>
            <button type="button" class="btn btn-outline-light" id="btnRevisarResenas" style="margin-left: 10px; border-color: rgba(40,102,110,.35); color:#28666e;">
                Revisar reseñas
            </button>
        </div>

        {{-- CONTENEDOR DE REVISAR RESEÑAS --}}
        <div id="zxContenedorGeneralResenas" style="display: none; margin-top: 30px;">
            
            {{-- CARRUSEL TOP 5 --}}
            <div class="zx-carousel-review-container mb-5">
                <p class="text-center text-muted small uppercase mb-4" style="letter-spacing: 2px;">
                    <i class="fas fa-crown text-warning"></i> Las opiniones generales más valoradas por la comunidad
                </p>
                
                <div class="zx-carousel-review-wrapper">
                    <div class="zx-carousel-review-track" id="zxReviewCarousel">
                        
                        @forelse($reseñasOrdenadas->take(5) as $review)
                            @php 
                                $starsTop     = (int) ($review->calificacion ?? 0); 
                                $reviewId     = $review->id_reseña ?? $review->id;
                                $likesActuales = $review->likes_count ?? $review->likes ?? 0;

                                // ✅ optional() evita error si product es null
                                $imagenCarrusel = optional($review->product)->imagen_url ?? $imagenFallback;
                                $nombreProducto = optional($review->product)->nombre ?? 'General';
                            @endphp
                            <div class="zx-carousel-review-card" data-card-id="{{ $reviewId }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="zx-review-user font-weight-bold">
                                        {{ $review->guest_nombre ?? 'Usuario Anónimo' }}
                                    </span>
                                    <div class="zx-review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $starsTop ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-center mb-3">
                                    <img
                                        src="{{ $imagenCarrusel }}"
                                        alt="Producto"
                                        style="width:72px;height:72px;object-fit:contain;background:#f7f7f7;padding:8px;border-radius:12px;border:1px solid rgba(0,0,0,.05);">
                                    <div>
                                        <h6 class="text-muted mb-1" style="font-size: 0.85em; color: #28666e !important;">
                                            Producto: {{ $nombreProducto }}
                                        </h6>
                                    </div>
                                </div>

                                <p class="zx-review-text mb-2">"{{ $review->descripcion }}"</p>

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                    <button
                                        type="button"
                                        class="btn btn-light p-2 d-flex align-items-center gap-2 js-review-like"
                                        style="pointer-events:auto; border:1px solid rgba(40,102,110,.2); border-radius:12px;"
                                        data-review-id="{{ $review->id_reseña ?? $review->id }}"
                                        aria-label="Dar like">
                                        <i class="fas fa-heart text-danger"></i>
                                        <span class="likes-count">{{ $likesActuales }}</span>
                                        <span class="text-muted" style="font-size:12px;">Me gusta</span>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="w-100 text-center text-muted py-3">
                                Aún no hay reseñas destacadas disponibles con interacciones.
                            </div>
                        @endforelse

                    </div>
                    
                    <button class="zx-carousel-control prev" id="zxCarouselPrev" type="button">&#10094;</button>
                    <button class="zx-carousel-control next" id="zxCarouselNext" type="button">&#10095;</button>
                </div>
            </div>

            <hr style="border-color: rgba(40,102,110,.15);" class="my-5">

            <p class="text-center text-muted small uppercase mb-3" style="letter-spacing: 2px;">
                Filtrar opiniones por calificación
            </p>

            {{-- NAVEGACIÓN DE CALIFICACIONES --}}
            <div class="resenas-nav">
                @foreach($puntuacionesDisponibles as $i => $puntos)
                    <button class="resenas-nav-btn {{ $i === 0 ? 'active' : '' }}" onclick="switchResenas('{{ Str::slug($puntos) }}', this)">
                        {{ $puntos }}
                    </button>
                @endforeach
            </div>

            {{-- GRIDS POR PUNTUACIÓN (REDISEÑO EXACTO CON ORIENTACIÓN HORIZONTAL) --}}
            @foreach($resenasPorPuntuacion as $puntos => $resenas)
                <div class="resenas-grid {{ $loop->first ? 'active' : '' }}" id="resenas-{{ Str::slug($puntos) }}">
                    @foreach($resenas->take(6) as $review)
                        @php 
                            $cal              = (int) ($review->calificacion ?? 0); 
                            $reviewGridId     = $review->id_reseña ?? $review->id;
                            $likesGridActuales = $review->likes_count ?? $review->likes ?? 0;

                            $imagenGrid      = optional($review->product)->imagen_url ?? $imagenFallback;
                            $nombreGrid      = optional($review->product)->nombre ?? 'Producto';
                        @endphp
                        <div class="resena-prod-card" data-card-id="{{ $reviewGridId }}">
                            <div class="resena-card-main-row">
                                <div class="resena-img-wrapper">
                                    <img src="{{ $imagenGrid }}" alt="Producto">
                                </div>
                                <div class="card-body p-0">
                                    <h4>{{ $nombreGrid }}</h4>
                                    <div class="stars mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $cal ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="card-text">{{ $review->descripcion }}</p>
                                </div>
                            </div>
                            <div class="resena-card-footer">
                                <p class="reviewer m-0 font-italic">— {{ $review->guest_nombre ?? 'Usuario desconocido' }}</p>
                                <small class="text-muted m-0">
                                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 js-review-like text-muted btn-like-fixed" data-review-id="{{ $reviewGridId }}">
                                        <i class="fas fa-heart text-danger"></i> 
                                        <span class="likes-count">{{ $likesGridActuales }}</span>
                                    </button>
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div> {{-- FIN CONTENEDOR REVISAR RESEÑAS --}}

        {{-- FORMULARIO AGREGAR RESEÑA --}}
        <div id="agregarResenaWrap" class="mb-5" style="display:none; margin-top: 30px;">
            <div class="review-section" style="max-width: 760px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eee;">
                <h3 class="mb-3 text-center" style="font-size: 1.25rem; color: #28666e; font-weight: bold;">DEJA TU COMENTARIO DEL PRODUCTO</h3>

                <form id="formAgregarResena" action="{{ url('/productos') }}/" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Producto</label>
                        <select name="producto_id" class="form-select" id="resenaProductoSelect" required>
                            @foreach($todosLosProductos ?? collect() as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="guest_nombre" class="form-control" placeholder="Opcional" maxlength="60">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="guest_email" class="form-control" placeholder="Opcional" maxlength="120">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label class="form-label">Calificación</label>
                            <select name="calificacion" class="form-select" required>
                                @for($i=5;$i>=1;$i--)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 5 ? '(Excelente)' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3" minlength="5" maxlength="1000" required placeholder="Escribe tu reseña..."></textarea>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: #28666e; border-color: #28666e;">Enviar reseña</button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .resenas-nav { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
            .resenas-nav-btn {
                padding: 8px 22px; border-radius: 999px; border: 2px solid #28666e;
                background: transparent; color: #28666e; font-weight: 700;
                font-size: 0.88em; cursor: pointer; transition: background .25s, color .25s, transform .2s;
            }
            .resenas-nav-btn:hover, .resenas-nav-btn.active { background: #28666e; color: #fedc97; transform: translateY(-2px); }
            
            /* GRID MÁS LIMPIO Y ULTRA RESPONSIVE */
            .resenas-grid { display: none; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1200px; margin: 0 auto; }
            .resenas-grid.active { display: grid; }
            @media (max-width: 1100px) { .resenas-grid.active { grid-template-columns: repeat(2, 1fr); } }
            @media (max-width: 680px) { .resenas-grid.active { grid-template-columns: 1fr; gap: 16px; } }
            
            /* TARJETA COMPACTA CON ALINEACIÓN HORIZONTAL INTERNA */
            .resena-prod-card { 
                background: #fff; 
                border: 1px solid #eef2f4; 
                border-radius: 14px; 
                overflow: hidden; 
                box-shadow: 0 4px 12px rgba(0,0,0,.06); 
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                min-height: 200px; /* Asegura homogeneidad de las tarjetas */
                position: relative;
                transition: transform .2s ease, box-shadow .2s ease;
            }
            .resena-prod-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,.09); }
            
            /* FILA DE CONTENIDO: IMAGEN + TEXTOS */
            .resena-card-main-row {
                display: flex;
                padding: 16px;
                gap: 16px;
                flex-grow: 1;
                align-items: flex-start;
            }
            
            /* CONTENEDOR DE IMAGEN (REDUCIDO / MÁS COMPACTO) */
            .resena-img-wrapper {
                flex: 0 0 110px; /* Ancho fijo para la imagen de manera limpia */
                height: 110px;    /* Altura menor controlada */
                background: #fdfdfd;
                border: 1px solid #f0f3f5;
                border-radius: 10px;
                padding: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
            }
            .resena-img-wrapper img { max-width: 100%; max-height: 100%; object-fit: contain; }
            
            /* CONTENEDOR DE TEXTOS DENTRO DE LA TARJETA */
            .resena-prod-card .card-body {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
            }
            .resena-prod-card .card-body h4 {
                font-size: 0.95rem;
                font-weight: 700;
                color: #1a1a1a;
                margin: 0 0 3px 0;
                line-height: 1.3;
            }
            .resena-prod-card .stars { font-size: 0.78rem; margin-bottom: 6px; }
            .resena-prod-card .card-text {
                font-size: 0.84rem;
                color: #555;
                margin: 0;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 3; /* Corta textos excesivamente largos si los hubiera */
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            
            /* FOOTER TOTALMENTE LIMPIO Y BOTÓN DE LIKE FIJO A LA DERECHA */
            .resena-card-footer {
                padding: 10px 16px;
                background: #fafbfc;
                border-top: 1px solid #f1f4f6;
                display: flex;
                justify-content: space-between;
                align-items: center;
                min-height: 40px;
                margin-top: auto; /* Fuerza el footer a quedarse abajo siempre */
            }
            .resena-card-footer .reviewer {
                font-size: 0.8rem;
                color: #6c757d;
                max-width: 70%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .btn-like-fixed {
                display: flex;
                align-items: center;
                gap: 4px;
                font-size: 0.85rem;
                font-weight: 600;
                transition: transform 0.15s ease;
            }
            .btn-like-fixed:hover { transform: scale(1.08); text-decoration: none; }
            
            /* Responsive específico para móviles pequeños */
            @media (max-width: 420px) {
                .resena-card-main-row { flex-direction: column; align-items: center; text-align: center; }
                .resena-img-wrapper { flex: 0 0 100px; width: 100px; height: 100px; }
                .resena-prod-card .card-body { align-items: center; }
            }

            /* Estilos del carrusel superior */
            .zx-carousel-review-container { max-width: 960px; margin: 0 auto; padding: 0 15px; }
            .zx-carousel-review-wrapper { position: relative; overflow: hidden; border-radius: 20px; background: #f8fafb; border: 1px solid rgba(40,102,110,.15); padding: 24px; box-shadow: inset 0 0 10px rgba(0,0,0,0.02); }
            .zx-carousel-review-track { display: flex; transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1); gap: 20px; }
            .zx-carousel-review-card { flex: 0 0 100%; background: #ffffff; border-radius: 14px; padding: 20px; box-sizing: border-box; border-left: 4px solid #28666e; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
            @media (min-width: 768px) { .zx-carousel-review-card { flex: 0 0 calc(50% - 10px); } }
            .zx-review-user { color: #333; font-weight: 700; }
            .zx-review-text { font-style: italic; color: #555; line-height: 1.5; font-size: 0.95rem; }
            
            .zx-carousel-control { position: absolute; top: 50%; transform: translateY(-50%); background: #ffffff; color: #28666e; border: 1px solid rgba(40,102,110,.3); width: 38px; height: 38px; border-radius: 50%; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.1); z-index: 10; }
            .zx-carousel-control:hover { background: #28666e; color: #fff; border-color: #28666e; }
            .zx-carousel-control.prev { left: 10px; }
            .zx-carousel-control.next { right: 10px; }
        </style>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const revisarBtn = document.getElementById('btnRevisarResenas');
            const contenedorGeneral = document.getElementById('zxContenedorGeneralResenas');
            const btnAgregar = document.getElementById('btnMostrarAgregarResena');
            const wrapAgregar = document.getElementById('agregarResenaWrap');
            const form = document.getElementById('formAgregarResena');
            const select = document.getElementById('resenaProductoSelect');

            if (revisarBtn && contenedorGeneral) {
                revisarBtn.addEventListener('click', () => {
                    if (contenedorGeneral.style.display === 'none' || contenedorGeneral.style.display === '') {
                        contenedorGeneral.style.display = 'block';
                        revisarBtn.textContent = 'Ocultar reseñas';
                        setTimeout(() => { moveCarousel(); }, 150);
                        contenedorGeneral.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        contenedorGeneral.style.display = 'none';
                        revisarBtn.textContent = 'Revisar reseñas';
                        document.getElementById('resenasDestacadasSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }

            document.addEventListener('click', async (event) => {
                const btnLike = event.target.closest('.js-review-like');
                if (!btnLike) return;

                const id = btnLike.getAttribute('data-review-id');
                if (!id) return;

                const metaToken = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = metaToken ? metaToken.getAttribute('content') : '{{ csrf_token() }}';

                try {
                    const res = await fetch(`/reviews/${id}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!res.ok) return;

                    const data = await res.json();
                    
                    if (data?.ok || data?.success) {
                        const nuevoTotalLikes = data.likes_count ?? data.likes ?? 0;
                        document.querySelectorAll(`[data-review-id="${id}"]`).forEach(btn => {
                            const span = btn.querySelector('.likes-count');
                            if (span) span.textContent = nuevoTotalLikes;
                        });
                    }
                } catch (e) {
                    console.error('Error al conectar con el endpoint de likes:', e);
                }
            });

            if (btnAgregar && wrapAgregar) {
                btnAgregar.addEventListener('click', () => {
                    wrapAgregar.style.display = (wrapAgregar.style.display === 'none' || !wrapAgregar.style.display) ? 'block' : 'none';
                    if (wrapAgregar.style.display === 'block') {
                        wrapAgregar.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            }

            if (form && select) {
                const setAction = () => {
                    const id = select.value;
                    form.action = `{{ url('/productos') }}/${id}/reviews`;
                };
                select.addEventListener('change', setAction);
                setAction();
            }

            const track = document.getElementById('zxReviewCarousel');
            const prevBtn = document.getElementById('zxCarouselPrev');
            const nextBtn = document.getElementById('zxCarouselNext');
            let currentIndex = 0;
            
            const getVisibleCards = () => window.innerWidth >= 768 ? 2 : 1;
            
            const moveCarousel = () => {
                if (!track) return;
                const cards = track.querySelectorAll('.zx-carousel-review-card');
                if (cards.length === 0) return;
                const cardWidth = cards[0].getBoundingClientRect().width;
                const gap = 20;
                const maxIndex = cards.length - getVisibleCards();
                if (currentIndex > maxIndex) currentIndex = Math.max(0, maxIndex);
                track.style.transform = `translateX(-${currentIndex * (cardWidth + gap)}px)`;
            };

            if (track && prevBtn && nextBtn) {
                nextBtn.addEventListener('click', () => {
                    const cards = track.querySelectorAll('.zx-carousel-review-card');
                    const visibleCards = getVisibleCards();
                    if (currentIndex < cards.length - visibleCards) { currentIndex++; } else { currentIndex = 0; }
                    moveCarousel();
                });

                prevBtn.addEventListener('click', () => {
                    const cards = track.querySelectorAll('.zx-carousel-review-card');
                    if (currentIndex > 0) { currentIndex--; } else { currentIndex = Math.max(0, cards.length - getVisibleCards()); }
                    moveCarousel();
                });
                window.addEventListener('resize', moveCarousel);
            }
        });

        function switchResenas(slug, btn) { 
            document.querySelectorAll('.resenas-grid').forEach(g => g.classList.remove('active'));
            document.querySelectorAll('.resenas-nav-btn').forEach(b => b.classList.remove('active'));
            const targetGrid = document.getElementById('resenas-' + slug);
            if (targetGrid) targetGrid.classList.add('active');
            btn.classList.add('active');
        }
    </script>
    <div style="clear: both;"></div>
</section>

{{-- ===================== SECCIÓN PROMOCIONES ===================== --}}
@php
    $promociones = \App\Models\Promotion::where('activo', true)->orderBy('id')->take(4)->get();
@endphp

@if($promociones->isNotEmpty())
<section class="zx-promos-section">
    <div class="zx-promos-inner">
        <h2 class="zx-promos-title zx-title-playfair">
            <i class="fas fa-percent zx-promos-icon"></i> Promociones
        </h2>
        <p class="zx-promos-sub">Descubre nuestras ofertas especiales</p>

        <div class="zx-promos-grid">
            @foreach($promociones as $promo)
            <div class="zx-promo-card">
                <div class="zx-promo-img-wrap">
                    <img
                        src="{{ $promo->imagen_url ? asset($promo->imagen_url) : asset('imagenes/promo-placeholder.png') }}"
                        alt="{{ $promo->nombre ?? 'Promoción' }}"
                        loading="lazy">
                    <div class="zx-promo-badge">PROMO</div>
                </div>
                <div class="zx-promo-body">
                    <p class="zx-promo-name">{{ $promo->nombre ?? 'Promoción especial' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
    /* ===================== SECCIÓN PROMOCIONES ===================== */
    .zx-promos-section {
        background: linear-gradient(135deg, #f3f8f8 0%, #e8f2f3 100%);
        padding: 56px 16px 60px;
        border-top: 3px solid rgba(40,102,110,0.12);
    }

    .zx-promos-inner {
        max-width: 1200px;
        margin: 0 auto;
    }

    .zx-promos-title {
        text-align: center;
        color: #28666e;
        font-size: 2em;
        margin-bottom: 6px;
    }

    .zx-promos-icon {
        color: #fedc97;
        background: #28666e;
        padding: 8px 11px;
        border-radius: 50%;
        font-size: 0.65em;
        vertical-align: middle;
        margin-right: 4px;
    }

    .zx-promos-sub {
        text-align: center;
        color: #7a9ea1;
        font-size: 0.97rem;
        margin-bottom: 36px;
        letter-spacing: .4px;
    }

    /* Grid de 4 tarjetas */
    .zx-promos-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    @media (max-width: 1024px) { .zx-promos-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px)  { .zx-promos-grid { grid-template-columns: 1fr; gap: 16px; } }

    /* Tarjeta */
    .zx-promo-card {
        background: #ffffff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(40,102,110,0.1);
        border: 1px solid rgba(40,102,110,0.1);
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex;
        flex-direction: column;
    }
    .zx-promo-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(40,102,110,0.18);
    }

    /* Imagen */
    .zx-promo-img-wrap {
        position: relative;
        height: 200px;
        background: #f4f8f9;
        overflow: hidden;
    }
    .zx-promo-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .zx-promo-card:hover .zx-promo-img-wrap img { transform: scale(1.04); }

    /* Badge */
    .zx-promo-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #fedc97;
        color: #28666e;
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 1.2px;
        padding: 4px 10px;
        border-radius: 999px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Nombre */
    .zx-promo-body {
        padding: 16px 18px 18px;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #28666e;
    }
    .zx-promo-name {
        color: #fedc97;
        font-weight: 800;
        font-size: 1rem;
        text-align: center;
        margin: 0;
        line-height: 1.4;
    }
</style>

{{-- INCLUSIÓN DEL FOOTER --}}
@include('footer')

{{-- Control de Banners de Video/Imagen --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const banner = document.getElementById('carouselBanner');
        if (!banner) return;

        const bsCarousel = bootstrap.Carousel.getOrCreateInstance(banner, {
            interval: 5000,
            ride: true,
            touch: false  // Desactivamos touch para que no consuma los clics en enlaces
        });

        function pauseAllVideos() {
            banner.querySelectorAll('video.banner-video').forEach(v => {
                try { v.pause(); v.currentTime = 0; } catch(e) {}
            });
        }

        function handleActiveSlide() {
            const active = banner.querySelector('.carousel-item.active');
            if (!active) return;

            const video = active.querySelector('video.banner-video');
            if (video) {
                bsCarousel.pause();
                video.play().catch(() => {});
                video.onended = () => bsCarousel.next();
            } else {
                bsCarousel.cycle();
            }
        }

        banner.addEventListener('slide.bs.carousel', () => pauseAllVideos());
        banner.addEventListener('slid.bs.carousel', () => handleActiveSlide());
        handleActiveSlide();

        // ✅ Abrir el enlace del banner sin que Bootstrap lo intercepte
        banner.addEventListener('click', (e) => {
            // Buscar si el clic ocurrió dentro de un <a> de banner
            const link = e.target.closest('.carousel-item > a[href]');
            if (link) {
                e.preventDefault();
                e.stopImmediatePropagation();
                window.open(link.href, '_blank', 'noopener,noreferrer');
            }
        }, true); // true = fase de captura, antes de que Bootstrap lo vea
    });
</script>
</body>
</html>