<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zarmex') }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root { 
            --zx-dark: #234d50;       /* Verde oscuro corporativo */
            --zx-whatsapp: #59b568;   /* Verde WhatsApp */
            --zx-mint: #c4e6d8;       /* Verde menta de las tarjetas */
            --zx-modal-bg: #e2f3ec;   /* NUEVO: Verde claro pastel para el contenedor del modal */
        }

        /* Estructura de Cuadrícula y Tarjetas */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 40px; width: 90%; max-width: 1500px; margin: 120px auto 0 auto; padding: 20px 0;          
        }
        .card2 {
            background: #fff; border-radius: 20px; border: 1px solid #eee; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;
            display: flex; flex-direction: column; height: 100%; width: 100%; overflow: hidden; 
        }
        .card2:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.25); }
        .card2 img { width: 100%; height: 250px; object-fit: contain; padding: 20px; background: var(--zx-mint); box-sizing: border-box; }

        /* Modales Generales */
        .modal { z-index: 99999 !important; }
        .modal-backdrop { z-index: 99990 !important; }
        
        /* MODIFICADO: El contenedor que antes era blanco ahora es verde claro pastel */
        .modal-content { 
            background: var(--zx-modal-bg) !important;
            border-radius: 25px !important; 
            border: 1px solid rgba(35, 77, 80, 0.15); 
            max-height: 85vh; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; 
            width: 100%; 
        }
        
        .modal-body { overflow-y: auto; overflow-x: hidden; padding: 25px !important; }
        .modal-body .row { margin: 0; align-items: center; }
        
        .info-label { font-size: 0.7rem; font-weight: 800; color: var(--zx-dark); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 1px; display: block; opacity: 0.9; }
        
        .carousel-control-prev-icon, .carousel-control-next-icon { 
            filter: invert(24%) sepia(21%) saturate(1145%) hue-rotate(134deg) brightness(91%) contrast(88%); 
        }

        /* Componentes del Modal: Botones y Círculos */
        .color-circle {
            width: 24px; height: 24px; border-radius: 50%; border: 2px solid #fff;   
            box-shadow: 0 0 0 1px #ddd; display: inline-block; margin-right: 5px; cursor: pointer; transition: all 0.2s;
        }
        .color-circle:hover { transform: scale(1.2); }
        .color-circle.selected { transform: scale(1.15); box-shadow: 0 0 0 2px var(--zx-dark); }

        /* Los botones de documentos ahora usan un fondo blanco semitransparente que resalta sobre el fondo verde */
        .btn-document-inline {
            display: inline-flex; align-items: center; padding: 12px; background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(35, 77, 80, 0.15); border-radius: 8px; text-decoration: none; color: var(--zx-dark); font-size: 0.75rem; transition: 0.2s;
        }
        .btn-document-inline:hover { background: #ffffff; transform: translateY(-2px); color: var(--zx-dark); }
        
        .btn-zx-whatsapp { background-color: var(--zx-whatsapp) !important; color: white !important; border-radius: 12px; padding: 12px 25px; font-weight: 700; border: none; }
        .border-top { border-top: 1px solid rgba(35, 77, 80, 0.2) !important; }

        .btn-close { transition: all 0.2s ease-in-out; opacity: 0.7; }
        .btn-close:hover { transform: scale(1.15); opacity: 1; filter: drop-shadow(0 0 8px rgba(35, 77, 80, 0.6)); }

        /* Contenedores de Zoom */
        .img-zoom-container { position: relative; display: inline-block; width: 100%; }
        .btn-zoom-overlay {
            position: absolute; bottom: 10px; right: 10px; background: rgba(35, 77, 80, 0.85); 
            color: white; border: none; width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
            transition: all 0.2s ease-in-out; box-shadow: 0 4px 8px rgba(0,0,0,0.2); cursor: pointer; z-index: 10;
        }
        .btn-zoom-overlay:hover { background: var(--zx-dark); transform: scale(1.1); color: white; }

        /* Visor de Zoom Interno (Modal Global) */
        .zoom-modal .modal-content { background: rgba(0, 0, 0, 0.9) !important; max-height: 90vh; border-radius: 15px !important; border: none !important; }
        .zoom-img-wrapper { position: relative; overflow: hidden; cursor: zoom-in; display: flex; align-items: center; justify-content: center; max-height: 70vh; border-radius: 10px; background: #fff; }
        .zoom-img-wrapper img { transition: transform 0.1s ease-out; max-height: 70vh; object-fit: contain; width: 100%; pointer-events: none; }
        .zoom-img-wrapper:hover img { transform: scale(2); cursor: zoom-out; }
    </style>
</head>

<body class="antialiased">
    @include('.header')

    <main>
        <div class="products-grid">
            @foreach($productos as $producto)
                <div class="card2">
                    <img src="{{ asset($producto->imagen_url ?? 'images/productos/default.png') }}" alt="{{ $producto->nombre }}">
                    <div class="card-content" style="padding: 20px; text-align: center;">
                        <h3 style="color: var(--zx-dark); font-weight: 800; font-size: 1.3rem;">{{ $producto->id }}</h3>
                        <button type="button" class="vermas-btn" style="background: var(--zx-dark); color: white; border: none; padding: 10px; border-radius: 10px; width: 100%;" data-bs-toggle="modal" data-bs-target="#modalProd{{ $producto->id }}">Ver Detalles</button>
                    </div>
                </div>

                <div class="modal fade" id="modalProd{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 900px;">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold m-0" style="color: var(--zx-dark);">{{ $producto->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <div id="carouselProd{{ $producto->id }}" class="carousel slide rounded-4 p-2 mb-3" style="background-color: rgba(255, 255, 255, 0.6); border: 1px solid rgba(35, 77, 80, 0.1);" data-bs-ride="false">
                                            <div class="carousel-inner text-center">
                                                <div class="carousel-item active">
                                                    <div class="img-zoom-container">
                                                        <img src="{{ asset($producto->imagen_url) }}" class="img-fluid d-block mx-auto" style="max-height: 250px; object-fit: contain;">
                                                        <button type="button" class="btn-zoom-overlay" onclick="openZoomModal('{{ asset($producto->imagen_url) }}', '{{ $producto->nombre }}')"><i class="fas fa-search-plus"></i></button>
                                                    </div>
                                                </div>
                                                @foreach(['img2_url', 'img3_url', 'img4_url', 'img5_url', 'img6_url'] as $imgCampo)
                                                    @if(!empty($producto->$imgCampo))
                                                    <div class="carousel-item">
                                                        <div class="img-zoom-container">
                                                            <img src="{{ asset($producto->$imgCampo) }}" class="img-fluid d-block mx-auto" style="max-height: 250px; object-fit: contain;">
                                                            <button type="button" class="btn-zoom-overlay" onclick="openZoomModal('{{ asset($producto->$imgCampo) }}', '{{ $producto->nombre }}')"><i class="fas fa-search-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                                @if(!empty($producto->video_url))
                                                <div class="carousel-item">
                                                    <div class="ratio ratio-16x9 d-block mx-auto" style="max-height: 250px;">
                                                        <video controls style="max-height: 250px; width: 100%; border-radius: 10px;"><source src="{{ asset($producto->video_url) }}" type="video/mp4"></video>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
                                        </div>
                                    </div>

                                    <div class="col-md-7 d-flex flex-column justify-content-between">
                                        <div>
                                            <span class="info-label">Descripción del Equipo</span>
                                            <p style="font-size: 0.9rem; color: #333; text-align: justify; line-height: 1.5;">{{ $producto->descripcion }}</p>

                                            <span class="info-label">Colores Disponibles</span>
                                            <div class="mb-4 color-selector-group">
                                                <span class="color-circle" style="background-color: #000000;" title="Negro"></span>
                                                <span class="color-circle" style="background-color: #234d50;" title="Verde Zarmex"></span>
                                                <span class="color-circle" style="background-color: #ffffff;" title="Blanco"></span>
                                                <span class="color-circle" style="background-color: #3d6ee8;" title="Azul"></span>
                                                <span class="color-circle" style="background-color: #e63946;" title="Rojo"></span>
                                                <span class="color-circle" style="background-color: #f4a261;" title="Naranja"></span>
                                                <span class="color-circle" style="background-color: #2a9d8f;" title="Turquesa"></span>
                                                <span class="color-circle" style="background-color: #6a4c93;" title="Morado"></span>
                                                <span class="color-circle" style="background-color: #c7c7c7;" title="Gris"></span>
                                                <span class="color-circle" style="background-color: #d4af37;" title="Dorado"></span>
                                            </div>

                                            <span class="info-label">Documentos Disponibles</span>
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                @if($producto->doc1_url)<a href="{{ asset($producto->doc1_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-danger me-1"></i> Manual</a>@endif
                                                @if($producto->doc2_url)<a href="{{ asset($producto->doc2_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-primary me-1"></i> Ficha</a>@endif
                                                @if($producto->doc3_url)<a href="{{ asset($producto->doc3_url) }}" target="_blank" class="btn-document-inline"><i class="far fa-file-pdf text-primary me-1"></i> Garantía</a>@endif
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-4 pt-3 border-top">
                                            <a href="https://wa.me/525581366555?text=Hola,%20me%20interesa%20obtener%20más%20información%20del%20producto:%20{{ $producto->nombre }}" target="_blank" class="btn btn-zx-whatsapp w-100 text-center"><i class="fab fa-whatsapp me-2"></i> WhatsApp</a>
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

    <div class="modal fade zoom-modal" id="globalZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span id="zoomModalTitle" class="text-white fw-bold" style="font-size: 0.95rem;"></span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="zoom-img-wrapper" id="zoomWrapper"><img id="zoomModalImg" src=""></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let bootstrapZoomModal;

        document.addEventListener("DOMContentLoaded", function() {
            bootstrapZoomModal = new bootstrap.Modal(document.getElementById('globalZoomModal'));
            const wrapper = document.getElementById('zoomWrapper');
            const img = document.getElementById('zoomModalImg');

            wrapper.addEventListener('mousemove', function(e) {
                const rect = wrapper.getBoundingClientRect();
                img.style.transformOrigin = `${e.clientX - rect.left}px ${e.clientY - rect.top}px`;
            });
            wrapper.addEventListener('mouseleave', () => img.style.transformOrigin = 'center center');

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('color-circle')) {
                    const group = e.target.closest('.color-selector-group');
                    group.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
                    e.target.classList.add('selected');
                }
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