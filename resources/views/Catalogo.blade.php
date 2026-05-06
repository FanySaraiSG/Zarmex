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
            --zx-dark: #234d50;
            --zx-whatsapp: #59b568;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 60px;
            width: 90%; 
            max-width: 1400px;
            margin: 0px auto;
            padding: 20px 0;
        }

        .card2 {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #eee;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .card2:hover { 
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }

        .card2 img {
            width: 100%;
            height: 270px;
            object-fit: contain;
            padding: 20px;
            background: #def7ed;
        }

        .modal-content {
            border-radius: 25px !important;
            border: none;
            max-height: 85vh; /* Ajustado para mejor scroll en dispositivos */
            display: flex;
            flex-direction: column;
        }

        .modal-body {
            overflow-y: auto;
        }
        
        .info-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: #312d2d;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 1px;
            display: block;
        }

        .color-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #ddd;
            display: inline-block;
            margin-right: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .color-circle:hover { transform: scale(1.2); }

        /* Estilo para documentos uno delante de otro */
        .btn-document-inline {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background: #f8f9fa;
            border: 1px solid #eee;
            border-radius: 8px;
            text-decoration: none;
            color: #444;
            font-size: 0.75rem;
            transition: 0.2s;
        }

        .btn-document-inline:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .btn-zx-whatsapp {
            background-color: var(--zx-whatsapp) !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 700;
            border: none;
        }

        .carousel-control-prev-icon, .carousel-control-next-icon {
            filter: invert(1);
        }
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
                        <h3 style="color: var(--zx-dark); font-weight: 800; font-size: 1.3rem;">{{ $producto->nombre }}</h3>
                        <button type="button" class="vermas-btn" style="background: var(--zx-dark); color: white; border: none; padding: 10px; border-radius: 10px; width: 100%;" data-bs-toggle="modal" data-bs-target="#modalProd{{ $producto->id }}">
                            Ver Detalles
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="modalProd{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold m-0">{{ $producto->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div id="carouselProd{{ $producto->id }}" class="carousel slide bg-light rounded-4 p-2 mb-3" data-bs-ride="false">
                                            <div class="carousel-inner text-center">
                                                <div class="carousel-item active">
                                                    <img src="{{ asset($producto->imagen_url) }}" class="img-fluid d-block mx-auto" style="max-height: 250px; object-fit: contain;">
                                                </div>

                                                @php
                                                    $imagenesExtras = ['img2_url', 'img3_url', 'img4_url', 'img5_url', 'img6_url'];
                                                @endphp
                                                @foreach($imagenesExtras as $imgCampo)
                                                    @if(!empty($producto->$imgCampo))
                                                    <div class="carousel-item">
                                                        <img src="{{ asset($producto->$imgCampo) }}" class="img-fluid d-block mx-auto" style="max-height: 250px; object-fit: contain;">
                                                    </div>
                                                    @endif
                                                @endforeach

                                                @if(!empty($producto->video_url))
                                                <div class="carousel-item">
                                                    <div class="ratio ratio-16x9 d-block mx-auto" style="max-height: 250px;">
                                                        <video controls style="max-height: 250px; width: 100%; border-radius: 10px;">
                                                            <source src="{{ asset($producto->video_url) }}" type="video/mp4">
                                                        </video>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Anterior</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProd{{ $producto->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Siguiente</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-7 d-flex flex-column justify-content-between">
                                        <div>
                                            <span class="info-label">Descripción del Equipo</span>
                                            <p style="font-size: 0.9rem; color: #555; text-align: justify;">
                                                {{ $producto->descripcion }}
                                            </p>

                                            <span class="info-label">Colores Disponibles</span>
                                            <div class="mb-4">
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
                                                @if($producto->doc1_url)
                                                    <a href="{{ asset($producto->doc1_url) }}" target="_blank" class="btn-document-inline">
                                                        <i class="far fa-file-pdf text-danger me-1"></i> Manual
                                                    </a>
                                                @endif
                                                @if($producto->doc2_url)
                                                    <a href="{{ asset($producto->doc2_url) }}" target="_blank" class="btn-document-inline">
                                                        <i class="far fa-file-pdf text-primary me-1"></i> Ficha
                                                    </a>
                                                @endif
                                                @if($producto->doc3_url)
                                                    <a href="{{ asset($producto->doc3_url) }}" target="_blank" class="btn-document-inline">
                                                        <i class="far fa-file-pdf text-primary me-1"></i> Garantía
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                            <a href="https://wa.me/525581366555?text=Hola,%20me%20interesa%20obtener%20más%20información%20del%20producto:%20{{ $producto->nombre }}" 
                                               target="_blank" 
                                               class="btn btn-zx-whatsapp">
                                                <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                            </a>
                                            <button type="button" class="btn btn-zx-close" data-bs-dismiss="modal" style="background: #eee; border: none; padding: 10px 20px; border-radius: 10px;">Cerrar</button>
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
    
    @include('footer')
</body>
</html>