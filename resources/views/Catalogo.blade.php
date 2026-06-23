<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zarmex') }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { 
            --zx-dark: #234d50;
            --zx-mint: #c4e6d8;
            
            /* --- COLORES CORPORATIVOS --- */
            --zx-header-dark: #143d40;     
            --zx-bg-soft-mint: #e0f2ed;    
            --zx-whatsapp-btn: #53b671;    
            --zx-text-muted: #3a6063;      
            --zx-border-soft: #cce3de;     
        }

        /* --- CONTENEDOR FLUIDO DE LA PÁGINA --- */
        main.container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* --- DISTRIBUCIÓN GRID PRINCIPAL --- */
        .products-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; 
            gap: 24px; 
            width: 100%;
            max-width: 100%; 
            margin: 120px auto 0 auto; 
            padding: 20px 40px; 
        }

        /* --- TARJETAS DEL CATÁLOGO --- */
        @media (min-width: 992px) { .card2 { width: calc(25% - 18px); } }
        @media (max-width: 991px) and (min-width: 576px) { .card2 { width: calc(50% - 12px); } }
        @media (max-width: 575px) { .card2 { width: 100%; } }

        .card2 {
            background: #eaf1f7; 
            border-radius: 20px; 
            border: 1px solid #eee; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.12); 
            transition: all 0.3s ease;
            display: flex; 
            flex-direction: column; 
            height: auto;
            min-height: 400px; 
            overflow: hidden; 
        }
        
        .card2-img-container {
            width: 100%;
            height: 250px; 
            overflow: hidden;
            background: var(--zx-mint);
            position: relative;
        }
        .card2-img-container img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }

        /* --- MARCO DEL MODAL PRINCIPAL --- */
        .custom-frame-modal {
            max-width: 75% !important; 
            width: 75% !important;
            margin: 0 auto 0 15% !important; 
            top: 2%; 
        }

        @media (max-width: 991px) {
            .custom-frame-modal {
                max-width: 90% !important;
                width: 90% !important;
                margin: 0 auto !important;
            }
        }

        .modal-content { 
            background: var(--zx-bg-soft-mint) !important;
            border-radius: 24px !important; 
            border: none !important;
            box-shadow: 0 25px 55px rgba(20, 61, 64, 0.35) !important;
            overflow: hidden !important; 
            max-height: 85vh; 
            display: flex;
            flex-direction: column;
        }

        /* --- ENCABEZADO --- */
        .modal-header-luxury {
            background-color: var(--zx-header-dark) !important;
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: none;
            width: 100%;
            flex-shrink: 0;
        }

        .product-title-luxury {
            color: #ffffff;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .btn-close-custom {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.2rem;
            transition: color 0.2s ease;
            cursor: pointer;
            padding: 0;
        }
        .btn-close-custom:hover { color: #ffffff; }

        /* --- CUERPO --- */
        .modal-body { 
            padding: 30px !important; 
            flex-grow: 1;
            overflow-y: auto !important; 
            overflow-x: hidden;
        }

        /* --- DISEÑO MULTIMEDIA --- */
        .multimedia-layout {
            display: flex;
            flex-direction: column-reverse;
            gap: 20px;
            width: 100%;
        }
        @media (min-width: 768px) { 
            .multimedia-layout { flex-direction: row; align-items: flex-start; } 
        }

        .thumbnails-sidebar {
            display: flex;
            flex-direction: row;
            gap: 10px;
            justify-content: center;
        }
        @media (min-width: 768px) {
            .thumbnails-sidebar {
                flex-direction: column;
                width: 65px;
                flex-shrink: 0;
            }
        }

        .btn-thumbnail {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            padding: 0;
            border: 2px solid var(--zx-border-soft);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            transition: all 0.2s ease;
        }
        .btn-thumbnail img { width: 100%; height: 100%; object-fit: cover; }
        .btn-thumbnail.active { border-color: var(--zx-header-dark) !important; transform: scale(1.05); }

        /* --- CAROUSEL RECUADRO MULTIMEDIA --- */
        .carousel-fixed-size {
            max-width: 100%; 
            width: 100%;
            height: 380px; 
            background: #ffffff !important;
            border-radius: 20px;
            border: 1px solid var(--zx-border-soft);
            box-shadow: 0 10px 30px rgba(20, 61, 64, 0.06);
            overflow: hidden;
            position: relative;
        }
        
        .carousel-fixed-size .carousel-item img {
            height: 100%; 
            width: 100%; 
            object-fit: fill !important; 
            padding: 0 !important; 
        }

        .carousel-control-prev-icon, .carousel-control-next-icon { 
            filter: invert(20%) sepia(15%) saturate(1400%) hue-rotate(135deg) brightness(90%) contrast(90%);
        }

        /* --- BOTÓN DE LA LUPA --- */
        .img-zoom-container { 
            position: relative; 
            width: 100%; 
            height: 100%; 
        }
        
        .btn-zoom-overlay {
            position: absolute; 
            bottom: 20px;          
            right: 20px;           
            background: rgba(20, 61, 64, 0.85); 
            color: #ffffff; 
            border: none; 
            width: 40px; 
            height: 40px; 
            border-radius: 50%;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            z-index: 99 !important; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            transition: transform 0.2s ease, background 0.2s ease;
            cursor: pointer;
        }
        .btn-zoom-overlay:hover {
            transform: scale(1.1);
            background: rgba(20, 61, 64, 1);
        }

        /* --- MODAL OPTIMIZADO PARA ZOOM INTERACTIVO DE LUPA --- */
        .zoom-modal .modal-dialog {
            max-width: 650px; 
            width: 90%;
            margin: 30px auto;
        }

        .zoom-modal .modal-content {
            background: var(--zx-bg-soft-mint) !important; 
            border-radius: 20px !important;
            border: none !important;
            overflow: hidden !important;
            max-height: 90vh; 
        }

        .zoom-modal-header {
            background-color: var(--zx-header-dark);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .zoom-modal-title {
            color: #ffffff !important;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        /* CONTENEDOR INTELIGENTE PARA LA LUPA */
        .zoom-img-wrapper {
            width: 100%;
            height: auto;
            max-height: 70vh;
            background: #ffffff;
            overflow: hidden; 
            position: relative;
            cursor: zoom-in; /* Cursor visual de lupa */
        }

        /* Imagen base adaptable */
        .zoom-img-wrapper img {
            width: 100%;
            height: auto;
            max-height: 70vh;
            object-fit: contain;
            display: block;
            transition: transform 0.1s ease-out; /* Transición suave al mover el ratón */
            transform-origin: center center;
        }

        /* --- BLOQUES DE DETALLES --- */
        .info-card-luxury {
            margin-bottom: 18px;
            padding: 4px 0 4px 12px;
            border-left: 3px solid var(--zx-header-dark);
        }

        .info-label-luxury {
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--zx-header-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            display: block;
        }

        .color-circle {
            width: 22px; 
            height: 22px; 
            border-radius: 50%; 
            border: 2px solid #fff;   
            box-shadow: 0 0 0 1px var(--zx-border-soft); 
            display: inline-block; 
            margin-right: 8px; 
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, width 0.2s ease, height 0.2s ease;
        }
        .color-circle:hover {
            transform: scale(1.18);
        }
        .color-circle.selected {
            width: 30px;
            height: 30px;
            border: 2.5px solid #fff;
            box-shadow: 0 0 0 2px var(--zx-header-dark), 0 0 10px 4px rgba(20, 61, 64, 0.4);
            transform: scale(1.25);
            position: relative;
            top: -2px;
        }

        .btn-document-inline {
            display: inline-flex; 
            align-items: center; 
            padding: 6px 12px; 
            background: #ffffff;
            border: 1px solid var(--zx-border-soft); 
            border-radius: 10px; 
            text-decoration: none; 
            color: var(--zx-header-dark); 
            font-size: 0.8rem; 
            font-weight: 700;
        }

        /* Botón de WhatsApp */
        .btn-zx-whatsapp { 
            background-color: var(--zx-whatsapp-btn) !important; 
            color: white !important; 
            border-radius: 14px; 
            padding: 12px 20px; 
            font-weight: 700; 
            border: none; 
            font-size: 1rem;
            box-shadow: 0 6px 16px rgba(83, 182, 113, 0.2);
            transition: all 0.2s ease;
        }
        .btn-zx-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(83, 182, 113, 0.3); }
    </style>
</head>
<body class="antialiased">
    @include('header')

    <main class="container-fluid">
        <div class="products-grid">
            @foreach($productos as $producto)
                
                {{-- TARJETA INDIVIDUAL DE PRODUCTO --}}
                <div class="card2">
                    <div class="card2-img-container">
                        @if($producto->imagenes && $producto->imagenes->count() > 0)
                            <img src="{{ asset($producto->imagenes->first()->ruta) }}" alt="{{ $producto->nombre ?: $producto->id }}">
                        @else
                            <img src="{{ asset('images/default.png') }}" alt="{{ $producto->nombre ?: $producto->id }}">
                        @endif
                    </div>
                    
                    <div class="card-content" style="padding: 15px; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3 style="color: var(--zx-dark); font-weight: 800; font-size: 1rem; margin-bottom: 12px;">
                             {{ $producto->id }}
                        </h3>
                        <button type="button" style="background: var(--zx-dark); color: white; border: none; padding: 10px; border-radius: 10px; width: 100%; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#modalProd{{ $producto->id }}">
                            Ver Detalles
                        </button>
                    </div>
                </div>

                {{-- MODAL DETALLES DEL PRODUCTO --}}
                <div class="modal fade" id="modalProd{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog custom-frame-modal modal-dialog-centered">
                        <div class="modal-content">
                            
                            {{-- HEADER --}}
                            <div class="modal-header-luxury">
                                <h2 class="product-title-luxury">
                                    {{ $producto->nombre ?: $producto->id }}
                                </h2>
                                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                <div class="row g-4 align-items-start">
                                    {{-- MULTIMEDIA --}}
                                    <div class="col-md-7">
                                        <div class="multimedia-layout">
                                            
                                            <div class="thumbnails-sidebar" id="thumbBar{{ $producto->id }}">
                                                @php
                                                    $totalSlides = $producto->imagenes ? $producto->imagenes->count() : 0;
                                                    $tieneVideoYT = !empty($producto->video_url) && preg_match('/^https?:\/\//', $producto->video_url);
                                                @endphp
                                                @if($producto->imagenes && $producto->imagenes->count() > 0)
                                                    @foreach($producto->imagenes as $index => $img)
                                                        <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="{{ $index }}" class="btn-thumbnail {{ $loop->first ? 'active' : '' }}">
                                                            <img src="{{ asset($img->ruta) }}">
                                                        </button>
                                                    @endforeach
                                                    @if($tieneVideoYT)
                                                        <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="{{ $totalSlides }}" class="btn-thumbnail" style="background:#000; display:flex; align-items:center; justify-content:center;">
                                                            <i class="fab fa-youtube" style="color:#ff0000; font-size:1.4rem;"></i>
                                                        </button>
                                                    @endif
                                                @else
                                                    <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="0" class="btn-thumbnail active">
                                                        <img src="{{ asset('images/default.png') }}">
                                                    </button>
                                                    @if($tieneVideoYT)
                                                        <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="1" class="btn-thumbnail" style="background:#000; display:flex; align-items:center; justify-content:center;">
                                                            <i class="fab fa-youtube" style="color:#ff0000; font-size:1.4rem;"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>

                                            <div id="carouselProd{{ $producto->id }}" class="carousel slide carousel-fixed-size" data-bs-ride="false">
                                                <div class="carousel-inner h-100 w-100">
                                                    @if($producto->imagenes && $producto->imagenes->count() > 0)
                                                        @foreach($producto->imagenes as $img)
                                                            <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                                                                <div class="img-zoom-container">
                                                                    <img src="{{ asset($img->ruta) }}" class="img-fluid d-block mx-auto">
                                                                    <button type="button" class="btn-zoom-overlay" onclick="openZoomModal('{{ asset($img->ruta) }}', '{{ $producto->nombre ?: $producto->id }}')">
                                                                        <i class="fas fa-search-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @if($tieneVideoYT)
                                                            @php
                                                                $embedYT = '';
                                                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $producto->video_url, $myt)) {
                                                                    $embedYT = 'https://www.youtube.com/embed/' . $myt[1] . '?autoplay=1&mute=1&controls=0&loop=1&playlist=' . $myt[1] . '&rel=0&modestbranding=1&showinfo=0';
                                                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $producto->video_url, $myt)) {
                                                                    $embedYT = 'https://player.vimeo.com/video/' . $myt[1];
                                                                }
                                                            @endphp
                                                            @if($embedYT)
                                                                <div class="carousel-item h-100">
                                                                    <div style="position:relative; width:100%; height:100%; overflow:hidden;">
                                                                        <div style="position:absolute;top:0;left:50px;width:calc(100% - 100px);height:100%;z-index:2;"></div>
                                                                        <iframe
                                                                            src="{{ $embedYT }}"
                                                                            style="position:absolute;top:-60px;left:-2px;width:calc(100% + 4px);height:calc(100% + 120px);border:0;"
                                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; loop"
                                                                            allowfullscreen>
                                                                        </iframe>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <div class="carousel-item h-100 active">
                                                            <div class="img-zoom-container">
                                                                <img src="{{ asset('images/default.png') }}" class="img-fluid d-block mx-auto">
                                                            </div>
                                                        </div>
                                                        @if($tieneVideoYT)
                                                            @php
                                                                $embedYT = '';
                                                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $producto->video_url, $myt)) {
                                                                    $embedYT = 'https://www.youtube.com/embed/' . $myt[1] . '?autoplay=1&mute=1&controls=0&loop=1&playlist=' . $myt[1] . '&rel=0&modestbranding=1&showinfo=0';
                                                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $producto->video_url, $myt)) {
                                                                    $embedYT = 'https://player.vimeo.com/video/' . $myt[1];
                                                                }
                                                            @endphp
                                                            @if($embedYT)
                                                                <div class="carousel-item h-100">
                                                                    <div style="position:relative; width:100%; height:100%; overflow:hidden;">
                                                                        <div style="position:absolute;top:0;left:50px;width:calc(100% - 100px);height:100%;z-index:2;"></div>
                                                                        <iframe
                                                                            src="{{ $embedYT }}"
                                                                            style="position:absolute;top:-60px;left:-2px;width:calc(100% + 4px);height:calc(100% + 120px);border:0;"
                                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; loop"
                                                                            allowfullscreen>
                                                                        </iframe>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="prev" style="z-index:10;">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="next" style="z-index:10;">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- DETALLES COLUMNA DERECHA --}}
                                    <div class="col-md-5 d-flex flex-column justify-content-between">
                                        <div class="ps-md-2">
                                            <div class="info-card-luxury">
                                                <span class="info-label-luxury">Descripción del Equipo</span>
                                                <p style="font-size: 0.9rem; color: var(--zx-text-muted); text-align: justify; margin: 0; line-height: 1.4;">
                                                    {{ $producto->descripcion ?? 'S/N' }}
                                                </p>
                                            </div>

                                            {{-- COLORES DINÁMICOS — todos los colores globales del sistema --}}
                                            @if(isset($colores) && $colores->count() > 0)
                                            <div class="info-card-luxury">
                                                <span class="info-label-luxury">Colores Disponibles</span>
                                                <div class="color-selector-group mt-1">
                                                    @foreach($colores as $color)
                                                        @php $hex = ltrim($color->id_color, '#'); @endphp
                                                        <span
                                                            class="color-circle"
                                                            style="background-color: #{{ $hex }};"
                                                            title="{{ $color->nombre }}"
                                                        ></span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            <div class="info-card-luxury">
                                                <span class="info-label-luxury">Documentación Oficial</span>
                                                <div class="d-flex flex-wrap gap-2 mt-1">
                                                    @if($producto->doc1_url)
                                                        <a href="{{ asset($producto->doc1_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-danger me-1"></i> Garantía</a>
                                                    @endif
                                                    @if($producto->doc2_url)
                                                        <a href="{{ asset($producto->doc2_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-danger me-1"></i> Manual de Usuario</a>
                                                    @endif
                                                    @if($producto->doc3_url)
                                                        <a href="{{ asset($producto->doc3_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-danger me-1"></i> Ficha Técnica</a>
                                                    @endif
                                                    @if(!$producto->doc1_url && !$producto->doc2_url && !$producto->doc3_url)
                                                        <span style="font-size: 0.85rem; color: var(--zx-text-muted); font-style: italic;">No hay documentos disponibles</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- WHATSAPP --}}
                                        <div class="pt-4 ps-md-2">
                                            <a href="https://wa.me/525581366555?text=Hola,%20me%20interesa%20obtener%20más%20información%20del%20producto:%20{{ urlencode($producto->nombre ?: $producto->id) }}" target="_blank" class="btn btn-zx-whatsapp w-100 text-center text-decoration-none d-block">
                                                <i class="fab fa-whatsapp me-2"></i> Consultar por WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    {{-- MODAL DE ZOOM GLOBAL --}}
    <div class="modal fade zoom-modal" id="globalZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="zoom-modal-header">
                    <h5 id="zoomModalTitle" class="zoom-modal-title"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- El contenedor escucha los movimientos del ratón -->
                    <div class="zoom-img-wrapper" id="interactiveZoomContainer">
                        <img id="zoomModalImg" src="" alt="Vista ampliada con lupa">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let bootstrapZoomModal;
        document.addEventListener("DOMContentLoaded", function () {
            bootstrapZoomModal = new bootstrap.Modal(document.getElementById('globalZoomModal'));
            
            const carousels = document.querySelectorAll('.carousel');
            carousels.forEach(carousel => {
                carousel.addEventListener('slide.bs.carousel', function (e) {
                    const prodId = carousel.id.replace('carouselProd', '');
                    const thumbBar = document.getElementById(`thumbBar${prodId}`);
                    if (thumbBar) {
                        const thumbnails = thumbBar.querySelectorAll('.btn-thumbnail');
                        thumbnails.forEach(t => t.classList.remove('active'));
                        if (thumbnails[e.to]) thumbnails[e.to].classList.add('active');
                    }
                });
            });

            // SCRIPT DE INTERACCIÓN DE LUPA INTELIGENTE (HOVER ZOOM)
            const zoomContainer = document.getElementById('interactiveZoomContainer');
            const zoomImg = document.getElementById('zoomModalImg');

            if(zoomContainer && zoomImg) {
                // Al pasar el cursor, agranda la imagen a 2.5x su tamaño nativo
                zoomContainer.addEventListener('mousemove', function(e) {
                    const rect = e.currentTarget.getBoundingClientRect();
                    const x = e.clientX - rect.left; // Posición X dentro del cuadro
                    const y = e.clientY - rect.top;  // Posición Y dentro del cuadro
                    
                    // Convertir la posición en porcentajes exactos
                    const xPercent = (x / rect.width) * 100;
                    const yPercent = (y / rect.height) * 100;

                    // Mueve el centro de origen dinámicamente y aplica el zoom
                    zoomImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                    zoomImg.style.transform = "scale(2.5)";
                });

                // Al sacar el ratón, regresa a su tamaño original encajado de forma perfecta
                zoomContainer.addEventListener('mouseleave', function() {
                    zoomImg.style.transform = "scale(1)";
                    zoomImg.style.transformOrigin = "center center";
                });
            }
        });

        // Selección de colores — toggle con efecto visual
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('color-circle')) {
                const grupo = e.target.closest('.color-selector-group');
                if (!grupo) return;
                const yaSeleccionado = e.target.classList.contains('selected');
                grupo.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
                if (!yaSeleccionado) e.target.classList.add('selected');
            }
        });

        function openZoomModal(imgUrl, prodName) {
            const zoomImg = document.getElementById('zoomModalImg');
            // Resetear estados previos antes de renderizar la nueva imagen
            zoomImg.style.transform = "scale(1)";
            zoomImg.style.transformOrigin = "center center";
            
            zoomImg.src = imgUrl;
            document.getElementById('zoomModalTitle').innerText = prodName;
            bootstrapZoomModal.show();
        }
    </script>
    @include('footer')
</body>
</html>