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
            --zx-whatsapp: #59b568;
            --zx-mint: #c4e6d8;
            --zx-modal-bg: #1e7070;
        }

        /* --- CUADRÍCULA DE 4 COLUMNAS EXACTAS (Alineado Verde) --- */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 40px; /* Separación reducida para que quepan 4 perfectamente */
            width: 100%;
            max-width: 1440px; 
            margin: 120px auto 0 auto; 
            padding: 20px 20px; 
        }

        @media (min-width: 576px) {
            .products-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (min-width: 992px) {
            .products-grid { 
                grid-template-columns: repeat(4, minmax(0, 1fr)); /* 4 Columnas fijas sin desborde */
            }
        }

        /* --- TARJETA OPTIMIZADA (Área Roja Cubierta) --- */
        .card2 {
            background: #eaf1f7; 
            border-radius: 20px; 
            border: 1px solid #eee; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.12); 
            transition: all 0.3s ease;
            display: flex; 
            flex-direction: column; 
            height: 120%;
            min-height: 400px; /* Cajas ligeramente más compactas y estilizadas */
            overflow: hidden; 
        }
        .card2:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
        }
        
        /* Contenedor de la imagen para garantizar proporciones perfectas */
        .card2-img-container {
            width: 100%;
            height: 250px; /* Altura fija para mantener simetría entre todas las tarjetas */
            overflow: hidden;
            background: var(--zx-mint);
            position: relative;
        }
        
        /* Cambiado para CUBRIR completamente el recuadro rojo sin deformarse */
        .card2-img-container img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; /* Llena todo el espacio de borde a borde */
            padding: 0 !important; /* Eliminamos el espacio que causaba el recuadro interno */
            transition: transform 0.5s ease;
        }
        .card2:hover .card2-img-container img {
            transform: scale(1.04); /* Efecto sutil al pasar el mouse */
        }

        .modal { z-index: 99999 !important; }
        .modal-backdrop { z-index: 99990 !important; }
        
        /* Contenedor Modal de Alto Fijo Tipo Quiosco */
        .modal-content { 
            background: var(--zx-modal-bg) !important;
            border-radius: 25px !important; 
            border: 1px solid rgba(15, 39, 68, 0.20); 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; 
            max-height: 92vh;
            position: relative;
        }
        
        /* Patrón geométrico de fondo */
        .dots-pattern {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 120px;
            height: 120px;
            background-image: radial-gradient(rgba(201, 168, 76, 0.25) 1.5px, transparent 1.5px);
            background-size: 12px 12px;
            pointer-events: none;
            z-index: 1;
        }

        .modal-body { 
            padding: 35px 40px !important; 
            overflow: hidden;
            z-index: 2;
        }
        
        /* Línea Decorativa Superior */
        .title-separator {
            height: 3px;
            background: linear-gradient(90deg, #c9a84c 0%, rgba(201, 168, 76, 0.4) 50%, transparent 100%);
            border-radius: 2px;
            margin-top: 10px;
            margin-bottom: 25px;
            width: 100%;
        }

        /* Detalles e Indicadores Laterales */
        .info-block {
            position: relative;
            padding-left: 15px;
            margin-bottom: 22px;
        }
        .info-block::before {
            content: '';
            position: absolute;
            left: 0;
            top: 2px;
            bottom: 2px;
            width: 3px;
            background: var(--zx-mint);
            border-radius: 2px;
        }

        .info-label { 
            font-size: 0.78rem; 
            font-weight: 800; 
            color: #c9a84c; 
            text-transform: uppercase; 
            margin-bottom: 6px; 
            letter-spacing: 1.2px; 
            display: block; 
        }
        
        .carousel-control-prev-icon, .carousel-control-next-icon { 
            filter: invert(24%) sepia(21%) saturate(1145%) hue-rotate(134deg) brightness(91%) contrast(88%); 
        }

        .color-circle {
            width: 25px; 
            height: 25px; 
            border-radius: 50%; 
            border: 2px solid #fff;   
            box-shadow: 0 0 0 1px #ddd; 
            display: inline-block; 
            margin-right: 7px; 
            cursor: pointer; 
            transition: all 0.2s ease;
        }
        .color-circle:hover, .color-circle.selected { transform: scale(1.2); box-shadow: 0 0 0 2px var(--zx-dark); }

        .btn-document-inline {
            display: inline-flex; 
            align-items: center; 
            padding: 8px 14px; 
            background: #165858;
            border: 1px solid rgba(201, 168, 76, 0.40); 
            border-radius: 8px; 
            text-decoration: none; 
            color: #c9a84c; 
            font-size: 0.8rem; 
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-document-inline:hover { background: #234d50; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); color: var(--zx-dark); }
        
        .btn-zx-whatsapp { 
            background-color: var(--zx-whatsapp) !important; 
            color: white !important; 
            border-radius: 14px; 
            padding: 14px 25px; 
            font-weight: 700; 
            border: none; 
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(89, 181, 104, 0.3);
        }
        .btn-zx-whatsapp:hover { opacity: 0.95; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(89, 181, 104, 0.4); }

        .img-zoom-container { position: relative; display: inline-block; width: 100%; }
        
        .btn-zoom-overlay {
            position: absolute; 
            bottom: 12px; 
            right: 12px; 
            background: rgba(35, 77, 80, 0.85); 
            color: white; 
            border: none; 
            width: 36px; 
            height: 36px; 
            border-radius: 50%;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            transition: 0.2s; 
            z-index: 10;
        }
        .btn-zoom-overlay:hover { background: var(--zx-dark); transform: scale(1.1); }

        .zoom-modal .modal-content { background: rgba(0, 0, 0, 0.9) !important; border: none !important; max-height: none; }
        .zoom-img-wrapper { position: relative; overflow: hidden; cursor: zoom-in; background: #fff; border-radius: 10px; }
        .zoom-img-wrapper img { transition: transform 0.1s ease-out; width: 100%; max-height: 70vh; object-fit: contain; }
        .zoom-img-wrapper:hover img { transform: scale(2); cursor: zoom-out; }

        /* --- LAYOUT MULTIMEDIA IZQUIERDO --- */
        .multimedia-layout {
            display: flex;
            flex-direction: column-reverse;
            gap: 15px;
        }
        @media (min-width: 768px) {
            .multimedia-layout { flex-direction: row; }
        }

        .thumbnails-sidebar {
            display: flex;
            flex-direction: row;
            gap: 10px;
            overflow-x: auto;
            align-content: flex-start;
            scrollbar-width: none; 
        }
        .thumbnails-sidebar::-webkit-scrollbar { display: none; } 

        @media (min-width: 768px) {
            .thumbnails-sidebar {
                flex-direction: column;
                overflow-x: visible;
                overflow-y: auto;
                max-height: 360px;
                width: 62px;
                flex-shrink: 0;
            }
        }

        .btn-thumbnail {
            width: 56px;
            height: 56px;
            flex-shrink: 0;
            padding: 0;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .btn-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn-thumbnail:hover {
            border-color: rgba(35, 77, 80, 0.4);
            transform: scale(1.03);
        }
        .btn-thumbnail.active {
            border-color: var(--zx-dark) !important;
            box-shadow: 0 0 0 2px rgba(35, 77, 80, 0.2);
            transform: scale(1.05);
        }
        .btn-thumbnail-video { background: #111; position: relative; }
        .video-thumb-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.45);
        }

        .carousel-fixed-size {
            max-width: 380px;
            width: 100%;
            margin: 0 auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }
    </style>
</head>
<body class="antialiased">
    @include('header')

    <main class="container-fluid">
        <div class="products-grid">
            @foreach($productos as $producto)
                
                {{-- TARJETA INDIVIDUAL DE PRODUCTO --}}
                <div class="card2">
                    
                    {{-- Contenedor especial para cubrir el área de la imagen --}}
                    <div class="card2-img-container">
                        @if($producto->imagenes && $producto->imagenes->count() > 0)
                            <img src="{{ asset($producto->imagenes->first()->ruta) }}" alt="{{ $producto->nombre }}">
                        @else
                            <img src="{{ asset('images/default.png') }}" alt="{{ $producto->nombre }}">
                        @endif
                    </div>
                    
                    <div class="card-content" style="padding: 15px; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3 style="color: var(--zx-dark); font-weight: 800; font-size: 1rem; margin-bottom: 12px; letter-spacing: -0.3px;">
                             {{ $producto->id }}
                        </h3>
                        <button type="button" style="background: var(--zx-dark); color: white; border: none; padding: 10px; border-radius: 10px; width: 100%; font-weight: 600; font-size: 0.9rem;" data-bs-toggle="modal" data-bs-target="#modalProd{{ $producto->id }}">
                            Ver Detalles
                        </button>
                    </div>
                </div>

                {{-- MODAL DETALLADO DE PRODUCTO --}}
                <div class="modal fade product-modal-sync" id="modalProd{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            
                            <div class="dots-pattern"></div>
                            
                            <div class="modal-header border-0 pb-0 justify-content-end" style="background: #165858; z-index: 5; border-radius: 25px 25px 0 0;">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            
                            <div class="modal-body pt-0" style="background: #1e7070;">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="fw-bold m-0" style="color: #c9a84c; font-size: 1.7rem; letter-spacing: -0.5px;">
                                            {{ $producto->nombre }}
                                        </h2>
                                        <div class="title-separator"></div>
                                    </div>
                                </div>

                                <div class="row g-4 align-items-center">
                                    {{-- COLUMNA MULTIMEDIA --}}
                                    <div class="col-md-6">
                                        <div class="multimedia-layout justify-content-center align-items-center">
                                            
                                            <div class="thumbnails-sidebar" id="thumbBar{{ $producto->id }}">
                                                @if($producto->imagenes && $producto->imagenes->count() > 0)
                                                    @foreach($producto->imagenes as $index => $img)
                                                        <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="{{ $index }}" class="btn-thumbnail {{ $loop->first ? 'active' : '' }}">
                                                            <img src="{{ asset($img->ruta) }}">
                                                        </button>
                                                    @endforeach
                                                @else
                                                    <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="0" class="btn-thumbnail active">
                                                        <img src="{{ asset('images/default.png') }}">
                                                    </button>
                                                @endif

                                                @if(!empty($producto->video_url))
                                                    <button type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide-to="{{ $producto->imagenes->count() }}" class="btn-thumbnail btn-thumbnail-video">
                                                        <div class="video-thumb-overlay">
                                                            <i class="fas fa-play text-white small"></i>
                                                        </div>
                                                    </button>
                                                @endif
                                            </div>

                                            <div id="carouselProd{{ $producto->id }}" class="carousel slide rounded-4 p-1 bg-light border carousel-fixed-size" data-bs-ride="false">
                                                <div class="carousel-inner w-100">
                                                    
                                                    @if($producto->imagenes && $producto->imagenes->count() > 0)
                                                        @foreach($producto->imagenes as $img)
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                <div class="img-zoom-container" style="aspect-ratio: 1 / 1; width: 100%;">
                                                                    <img src="{{ asset($img->ruta) }}" class="img-fluid d-block mx-auto rounded-4" style="height: 100%; width: 100%; object-fit: cover;">
                                                                    <button type="button" class="btn-zoom-overlay" onclick="openZoomModal('{{ asset($img->ruta) }}', '{{ $producto->nombre }}')">
                                                                        <i class="fas fa-search-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="carousel-item active">
                                                            <div class="img-zoom-container" style="aspect-ratio: 1 / 1; width: 100%;">
                                                                <img src="{{ asset('images/default.png') }}" class="img-fluid d-block mx-auto rounded-4" style="height: 100%; width: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(!empty($producto->video_url))
                                                        <div class="carousel-item {{ ($producto->imagenes->count() == 0) ? 'active' : '' }}">
                                                            <div style="aspect-ratio: 1 / 1; width: 100%; background:#000;" class="rounded-4 overflow-hidden">
                                                                <video controls style="height: 100%; width: 100%; object-fit: cover;">
                                                                    <source src="{{ asset($producto->video_url) }}" type="video/mp4">
                                                                </video>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- COLUMNA DETALLES --}}
                                    <div class="col-md-6 d-flex flex-column justify-content-between" style="min-height: 380px;">
                                        <div>
                                            <div class="info-block">
                                                <span class="info-label">Descripción del Equipo</span>
                                                <p style="font-size: 0.92rem; color: #d4e8e0; text-align: justify; margin: 0; line-height: 1.45;">{{ $producto->descripcion }}</p>
                                            </div>

                                            <div class="info-block">
                                                <span class="info-label">Colores Disponibles</span>
                                                <div class="color-selector-group">
                                                    <span class="color-circle" style="background-color: #000;" title="Negro"></span>
                                                    <span class="color-circle" style="background-color: #234d50;" title="Verde Zarmex"></span>
                                                    <span class="color-circle" style="background-color: #fff;" title="Blanco"></span>
                                                    <span class="color-circle" style="background-color: #3d6ee8;" title="Azul"></span>
                                                </div>
                                            </div>

                                            <div class="info-block">
                                                <span class="info-label">Documentación Oficial</span>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @if($producto->doc1_url)
                                                        <a href="{{ asset($producto->doc1_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-danger me-1"></i> Garantía</a>
                                                    @endif
                                                    @if($producto->doc2_url)
                                                        <a href="{{ asset($producto->doc2_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-primary me-1"></i> Manual</a>
                                                    @endif
                                                    @if($producto->doc3_url)
                                                        <a href="{{ asset($producto->doc3_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-success me-1"></i> Ficha Técnica</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-3">
                                            <a href="https://wa.me/525581366555?text=Hola,%20me%20interesa%20obtener%20más%20información%20del%20producto:%20{{ urlencode($producto->nombre) }}" target="_blank" class="btn btn-zx-whatsapp w-100 text-center text-decoration-none d-block">
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

    {{-- MODAL DE ZOOM --}}
    <div class="modal fade zoom-modal" id="globalZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-2 shadow-lg">
                <div class="d-flex justify-content-between align-items-center mb-2 px-2">
                    <span id="zoomModalTitle" class="text-white fw-bold small"></span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="zoom-img-wrapper" id="zoomWrapper">
                        <img id="zoomModalImg" src="">
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
            const wrapper = document.getElementById('zoomWrapper');
            const img = document.getElementById('zoomModalImg');

            wrapper.addEventListener('mousemove', function (e) {
                const rect = wrapper.getBoundingClientRect();
                wrapper.querySelector('img').style.transformOrigin = `${e.clientX - rect.left}px ${e.clientY - rect.top}px`;
            });
            wrapper.addEventListener('mouseleave', () => { img.style.transformOrigin = 'center center'; });

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('color-circle')) {
                    const group = e.target.closest('.color-selector-group');
                    group.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
                    e.target.classList.add('selected');
                }
            });

            const carousels = document.querySelectorAll('.carousel');
            carousels.forEach(carousel => {
                carousel.addEventListener('slide.bs.carousel', function (e) {
                    const prodId = carousel.id.replace('carouselProd', '');
                    const thumbBar = document.getElementById(`thumbBar${prodId}`);
                    if (thumbBar) {
                        const thumbnails = thumbBar.querySelectorAll('.btn-thumbnail');
                        thumbnails.forEach(t => t.classList.remove('active'));
                        
                        const nextActiveThumb = thumbnails[e.to];
                        if (nextActiveThumb) {
                            nextActiveThumb.classList.add('active');
                            nextActiveThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
                        }
                    }
                });
            });
        });

        function openZoomModal(imgUrl, prodName) {
            document.getElementById('zoomModalImg').src = imgUrl;
            document.getElementById('zoomModalTitle').innerText = prodName;
            bootstrapZoomModal.show();
        }
    </script>
    @include('footer')
</body>
</html>