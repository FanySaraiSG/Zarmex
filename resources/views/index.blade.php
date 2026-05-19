<!DOCTYPE html>
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
        .banner-media {
            width: 100%;
            height: 436px;
            object-fit: cover;
            display: block;
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
    </style>
</head>

<body class="antialiased">
    @include('header')

    <section>
        @php
            $bannerImages = \App\Models\Imagen::where('seccion', 'banner')->get();
        @endphp

        @if($bannerImages->isNotEmpty())
            <div id="carouselBanner"
                 class="carousel slide"
                 data-bs-ride="carousel"
                 data-bs-interval="5000">

                <div class="carousel-inner">
                    @foreach($bannerImages as $index => $image)
                        @php
                            $extension = strtolower(pathinfo($image->imagen_url, PATHINFO_EXTENSION));
                        @endphp

                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            @if(in_array($extension, ['mp4','webm','ogg']))
                                {{-- Se agregó la clase 'banner-video' para que el JS lo reconozca --}}
                                <video class="banner-video d-block w-100" autoplay muted loop playsinline style="height:436px; object-fit:cover;">
                                    <source src="{{ asset($image->imagen_url) }}" type="video/{{ $extension }}">
                                    Tu navegador no soporta video HTML5
                                </video>
                            @else
                                <img src="{{ asset($image->imagen_url) }}" class="d-block w-100" alt="Banner" style="height:650px; object-fit:cover;">
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
                <img src="{{ asset('imagenes/banner.jpeg') }}" alt="Banner Predeterminado" style="height:436px; object-fit:cover;">
            </div>
        @endif

        {{-- ===================== PRODUCTOS DESTACADOS ===================== --}}
        <section class="products">
            <style>
                .best-sellers-wrap { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
                .zx-title-playfair { font-family: "Playfair Display", serif !important; font-weight: 700; letter-spacing: .5px; }

                /* ── Cards ── */
                .best-card {
                    border: 1px solid #ddd;
                    border-radius: 16px;
                    overflow: hidden;
                    background: #fff;
                    box-shadow: 0 4px 12px rgba(0,0,0,.10);
                    transition: transform .25s ease, box-shadow .25s ease;
                    cursor: pointer;
                    height: 100%;
                }
                .best-card:hover { transform: translateY(-8px); box-shadow: 0 16px 32px rgba(40,102,110,.18); }
                .best-card img { width: 100%; height: 220px; object-fit: contain; background: #FFF; padding: 8px; }
                .best-card h3 { font-size: 1.1em; margin: 12px 0 8px; color: #28666e; font-weight: 700; text-align: center; }
                .best-card p { font-size: 0.88em; color: #555; margin: 0 0 12px; line-height: 1.4; text-align: justify; padding: 0 8px; }
                .best-btn {
                    display: block; text-align: center; background: #28666e; color: #fedc97;
                    padding: 10px 16px; border-radius: 8px; font-weight: 700; border: none;
                    width: calc(100% - 32px); margin: 0 16px 16px; cursor: pointer;
                    transition: background .25s ease, transform .2s ease;
                }
                .best-btn:hover { background: #1a4a50; transform: translateY(-1px); color: #fff; }

                /* Carrusel flechas */
                .best-carousel .carousel-control-prev-icon,
                .best-carousel .carousel-control-next-icon { filter: invert(1); }
                .best-carousel .carousel-control-prev,
                .best-carousel .carousel-control-next { width: 6%; }

                /* ===== Botones secciones (encima del carrusel) ===== */
                .best-section-actions{
                    display:flex;
                    justify-content:center;
                    gap:12px;
                    margin: 0 0 18px;
                    position: relative;
                    z-index: 3;
                }
                .best-section-action-btn{
                    background: rgba(40,102,110,0.92);
                    color: #fedc97;
                    border: 1px solid rgba(184,161,32,0.35);
                    padding: 10px 18px;
                    border-radius: 999px;
                    font-weight: 800;
                    cursor:pointer;
                    transition: transform .2s ease, background .2s ease, color .2s ease;
                }
                .best-section-action-btn:hover{
                    transform: translateY(-2px);
                    background: #28666e;
                    color: #fff;
                }
                .best-section-action-btn.active{
                    background: #1a4a50;
                    color: #fedc97;
                    box-shadow: 0 8px 20px rgba(20,85,85,0.25);
                }

                /* Filtro visual por sección */
                .best-card{ transition: opacity .2s ease, transform .2s ease; }
                .best-sec-todos{ opacity: 1; }
                .best-sec-novedades,
                .best-sec-populares{ opacity: 1; }

                .best-hide-section{ opacity: 0; pointer-events: none; transform: scale(0.98); }


                /* OVERLAY */
                .prod-overlay {
                    position: fixed; inset: 0; background: rgba(0,0,0,0.6);
                    z-index: 99999; display: none; align-items: center;
                    justify-content: center; padding: 16px;
                }
                .prod-overlay.open { display: flex; }

                /* MODAL */
                .prod-modal {
                    background: #fff; border-radius: 16px; width: 100%; max-width: 740px;
                    max-height: 90vh; overflow-y: auto; border: 1px solid #ddd;
                    animation: prodPopIn .25s cubic-bezier(.23,1,.32,1);
                }
                @keyframes prodPopIn { from { opacity:0; transform:scale(.94); } to { opacity:1; transform:scale(1); } }

                .prod-modal-header {
                    display: flex; align-items: center; justify-content: space-between;
                    padding: 16px 20px 14px; border-bottom: 1px solid #eee;
                }
                .prod-modal-header h3 { font-size: 1.1em; font-weight: 700; color: #28666e; margin: 0; }

                .prod-modal-body { display: grid; grid-template-columns: 1fr 1fr; }

                /* Carrusel del modal */
                .prod-carousel-wrap { padding: 18px 18px 16px 20px; border-right: 1px solid #eee; }
                .prod-carousel-stage {
                    position: relative; width: 100%; height: 300px; background: #f7f7f7;
                    border-radius: 12px; overflow: hidden; margin-bottom: 10px;
                }
                .prod-carousel-track { display: flex; height: 100%; transition: transform .35s cubic-bezier(.23,1,.32,1); }
                .prod-carousel-slide { min-width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
                .prod-carousel-slide img { width: 100%; height: 100%; object-fit: contain; padding: 12px; }
                .prod-carousel-slide video { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; }
                .prod-slide-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; color: #aaa; font-size: 12px; }
                .prod-slide-empty span:first-child { font-size: 36px; }

                .prod-carr-btn {
                    position: absolute; top: 50%; transform: translateY(-50%);
                    background: rgba(40,102,110,0.85); border: none; border-radius: 50%;
                    width: 28px; height: 28px; color: #fedc97; font-size: 16px; cursor: pointer;
                    display: flex; align-items: center; justify-content: center; z-index: 2;
                    transition: background .2s;
                }
                .prod-carr-btn:hover { background: #28666e; }
                .prod-carr-btn.prev { left: 8px; }
                .prod-carr-btn.next { right: 8px; }

                .prod-dots { display: flex; justify-content: center; gap: 5px; margin-bottom: 10px; }
                .prod-dot { width: 6px; height: 6px; border-radius: 50%; background: #ccc; cursor: pointer; transition: background .2s, transform .15s; }
                .prod-dot.active { background: #28666e; transform: scale(1.3); }

                /* Info derecha */
                .prod-modal-right { padding: 18px 20px 18px 18px; }
                .prod-info-label { font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 6px; margin-top: 14px; }
                .prod-info-label:first-child { margin-top: 0; }
                .prod-desc-full { font-size: 13px; color: #333; line-height: 1.6; }
                .prod-colors-wrap { display: flex; flex-wrap: wrap; gap: 7px; }
                .prod-color-swatch {
                    width: 26px; height: 26px; border-radius: 50%; border: 2px solid transparent;
                    cursor: pointer; transition: transform .15s, border-color .15s; position: relative;
                }
                .prod-color-swatch:hover { transform: scale(1.15); }
                .prod-color-swatch.selected { border-color: #28666e; }
                .prod-color-swatch.selected::after { content: ''; position: absolute; inset: -4px; border-radius: 50%; border: 1.5px solid #28666e; }
                .prod-sel-color { font-size: 12px; color: #888; margin-top: 7px; }

                /* Footer del modal */
                .prod-modal-footer {
                    padding: 12px 20px 16px;
                    border-top: 1px solid #eee;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .prod-btn-whatsapp {
                    background: #25D366;
                    color: #fff;
                    border: none;
                    border-radius: 10px;
                    padding: 12px 32px;
                    font-size: 15px;
                    font-weight: 700;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: background .2s, transform .15s;
                }

                .prod-btn-whatsapp:hover { background: #1ebe5d; transform: translateY(-1px); }

                /* Botón cerrar (círculo con tache) */
                .prod-modal-close {
                    position: absolute;
                    top: 14px;
                    right: 14px;
                    width: 34px;
                    height: 34px;
                    border-radius: 50%;
                    border: 2px solid rgba(184,161,32,0.55);
                    background: rgba(0,0,0,0.04);
                    color: #28666e;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    z-index: 3;
                    transition: transform 15s ease, background 2s ease, color 2s ease;
                }

                .prod-modal-close:hover {
                    transform: scale(1.05);
                    background: rgba(184,161,32,0.15);
                    color: #1a4a50;
                }


                @media (max-width: 768px) {
                    .prod-modal-body { grid-template-columns: 1fr; }
                    .prod-carousel-wrap { border-right: none; border-bottom: 1px solid #eee; }
                }
            </style>

            <h2 class="text-center zx-title-playfair" style="color:#28666e; font-size:2em; margin: 20px 0;">PRODUCTOS DESTACADOS</h2>

                <div class="best-sellers-wrap">
                <div class="best-section-actions" aria-label="Secciones de productos destacados">
                    <button type="button" class="best-section-action-btn" onclick="showBestSection('todos')">Todos</button>
                    <button type="button" class="best-section-action-btn" onclick="showBestSection('novedades')">Novedades</button>
                    <button type="button" class="best-section-action-btn" onclick="showBestSection('populares')">Populares</button>
                </div>

                @php
                    $novedades = ($topProducts ?? collect())->where('section','novedades')->values();
                    $populares = ($topProducts ?? collect())->where('section','populares')->values();
                @endphp

                @if(($topProducts ?? collect())->count() === 0)

                    <div style="text-align:center; color:#666; padding: 24px;">No hay productos destacados disponibles.</div>
                @else
                <div id="topProductsTodosCarousel" class="carousel slide best-carousel" data-bs-ride="carousel" data-bs-interval="4500">
                        <div class="carousel-inner">
                            @foreach($topProducts->chunk(3) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row g-4 justify-content-center">
                                        @foreach($chunk as $topProduct)
                                            @php
                                                $section = $topProduct->section ?? 'todos';
                                                $bestSectionClass = match($section) {
                                                    'novedades' => 'best-sec-novedades',
                                                    'populares' => 'best-sec-populares',
                                                    default => 'best-sec-todos'
                                                };
                                            @endphp

                                            @if($topProduct->product)
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="best-card {{ $bestSectionClass }}" data-best-section="{{ $section }}">
                                                        <img src="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                             alt="{{ $topProduct->product->nombre ?? 'Producto' }}">

                                                        <h3>{{ Str::afterLast($topProduct->product->nombre, ' ') }}</h3>

                                                        <button class="best-btn"
                                                            data-nombre="{{ $topProduct->product->nombre ?? 'Producto' }}"
                                                            data-desc="{{ $topProduct->product->descripcion ?? '' }}"
                                                            data-img="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                            data-colores="{{ json_encode(optional($topProduct->product->colores)->pluck('nombre', 'hex') ?? []) }}"
                                                            onclick="abrirProdModalDesdeBtn(this)">
                                                            Ver más
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#topProductsTodosCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#topProductsTodosCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>

                    @php
                        $novedades = $topProducts->where('section','novedades')->values();
                        $populares = $topProducts->where('section','populares')->values();
                    @endphp

                    <div id="topProductsNovedadesCarousel" class="carousel slide best-carousel d-none" data-bs-ride="carousel" data-bs-interval="4500">
                        <div class="carousel-inner">
                            @foreach($novedades->chunk(3) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row g-4 justify-content-center">
                                        @foreach($chunk as $topProduct)
                                            @if($topProduct->product)
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="best-card best-sec-novedades" data-best-section="novedades">
                                                        <img src="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                             alt="{{ $topProduct->product->nombre ?? 'Producto' }}">
                                                        <h3>{{ Str::afterLast($topProduct->product->nombre, ' ') }}</h3>
                                                        <button class="best-btn"
                                                            data-nombre="{{ $topProduct->product->nombre ?? 'Producto' }}"
                                                            data-desc="{{ $topProduct->product->descripcion ?? '' }}"
                                                            data-img="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                            data-colores="{{ json_encode(optional($topProduct->product->colores)->pluck('nombre', 'hex') ?? []) }}"
                                                            onclick="abrirProdModalDesdeBtn(this)">
                                                            Ver más
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#topProductsNovedadesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#topProductsNovedadesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>

                    <div id="topProductsPopularesCarousel" class="carousel slide best-carousel d-none" data-bs-ride="carousel" data-bs-interval="4500">
                        <div class="carousel-inner">
                            @foreach($populares->chunk(3) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row g-4 justify-content-center">
                                        @foreach($chunk as $topProduct)
                                            @if($topProduct->product)
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="best-card best-sec-populares" data-best-section="populares">
                                                        <img src="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                             alt="{{ $topProduct->product->nombre ?? 'Producto' }}">
                                                        <h3>{{ Str::afterLast($topProduct->product->nombre, ' ') }}</h3>
                                                        <button class="best-btn"
                                                            data-nombre="{{ $topProduct->product->nombre ?? 'Producto' }}"
                                                            data-desc="{{ $topProduct->product->descripcion ?? '' }}"
                                                            data-img="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                            data-colores="{{ json_encode(optional($topProduct->product->colores)->pluck('nombre', 'hex') ?? []) }}"
                                                            onclick="abrirProdModalDesdeBtn(this)">
                                                            Ver más
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#topProductsPopularesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#topProductsPopularesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                @endif
            </div>


            {{-- ── MODAL (simple: info antigua + WhatsApp) ── --}}
            <div class="prod-overlay" id="prodOverlay" onclick="if(event.target===this) cerrarProdModal()">
                <div class="prod-modal">
                    {{-- Botón cerrar arriba derecha (círculo con tache) --}}
                    <button
                        type="button"
                        class="prod-modal-close"
                        onclick="cerrarProdModal()"
                        aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="prod-modal-header">
                        <h3 id="pm-nombre"></h3>
                    </div>

                    <div class="prod-modal-body">
                        {{-- Carrusel del Modal --}}
                        <div class="prod-carousel-wrap">
                            <div class="prod-carousel-stage">
                                <div class="prod-carousel-track" id="pm-track"></div>
                                <button class="prod-carr-btn prev" onclick="pmMover(-1)">‹</button>
                                <button class="prod-carr-btn next" onclick="pmMover(1)">›</button>
                            </div>
                            <div class="prod-dots" id="pm-dots"></div>
                        </div>

                        {{-- Info (SIN precios / SIN carrito). Se deja solo descripción y colores si ya existían. --}}
                        <div class="prod-modal-right">
                            <p class="prod-info-label">Descripción</p>
                            <p class="prod-desc-full" id="pm-desc"></p>

                            <p class="prod-info-label">Colores disponibles</p>
                            <div class="prod-colors-wrap" id="pm-colors"></div>
                            <p class="prod-sel-color" id="pm-color-name">Selecciona un color</p>
                        </div>
                    </div>

                    {{-- WhatsApp centrado --}}
                    <div class="prod-modal-footer">
                        <button class="prod-btn-whatsapp" onclick="abrirWhatsapp()">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </button>
                    </div>
                </div>
            </div>


            <script>
                let pmSlides = [], pmCur = 0, pmNombreActual = '';

                function abrirProdModalDesdeBtn(btn) {
                    const nombre  = btn.getAttribute('data-nombre');
                    const desc    = btn.getAttribute('data-desc');
                    const img     = btn.getAttribute('data-img');
                    const colores = JSON.parse(btn.getAttribute('data-colores') || '{}');
                    abrirProdModal(nombre, desc, img, colores);
                }

                function abrirProdModal(nombre, desc, imgPrincipal, colores) {
                    // Limpieza del nombre para mostrar solo el ID (Última palabra)
                    const partes = nombre.split(' ');
                    const soloCodigo = partes[partes.length - 1];
                    
                    pmNombreActual = soloCodigo; // Guardamos el ID para WhatsApp

                    document.getElementById('pm-nombre').textContent = soloCodigo;
                    document.getElementById('pm-desc').textContent = desc;

                    // Colores
                    const cw = document.getElementById('pm-colors');
                    cw.innerHTML = '';
                    document.getElementById('pm-color-name').textContent = 'Selecciona un color';
                    if (colores && typeof colores === 'object') {
                        Object.entries(colores).forEach(([hex, nombre_color]) => {
                            const sw = document.createElement('div');
                            sw.className = 'prod-color-swatch';
                            sw.style.background = hex;
                            sw.title = nombre_color;
                            sw.onclick = () => {
                                document.querySelectorAll('.prod-color-swatch').forEach(s => s.classList.remove('selected'));
                                sw.classList.add('selected');
                                document.getElementById('pm-color-name').textContent = nombre_color;
                            };
                            cw.appendChild(sw);
                        });
                    }

                    // Slides
                    pmSlides = [{ type: 'img', src: imgPrincipal, label: 'Imagen 1' }];
                    pmCur = 0;
                    pmRenderTrack();
                    pmRenderDots();

                    document.getElementById('prodOverlay').classList.add('open');
                }

                function cerrarProdModal() {
                    document.getElementById('prodOverlay').classList.remove('open');
                }

                function abrirWhatsapp() {
                    const mensaje = encodeURIComponent(
                        `Hola, estoy interesado en el producto: ${pmNombreActual}. ¿Me podrían dar más información?`
                    );
                    window.open(`https://wa.me/+525581366555?text=${mensaje}`, '_blank');
                }

                function pmRenderTrack() {
                    const track = document.getElementById('pm-track');
                    track.innerHTML = '';
                    pmSlides.forEach(s => {
                        const slide = document.createElement('div');
                        slide.className = 'prod-carousel-slide';
                        if (s.src) {
                            slide.innerHTML = s.type === 'vid'
                                ? `<video src="${s.src}" controls style="width:100%;height:100%;object-fit:cover;border-radius:12px"></video>`
                                : `<img src="${s.src}">`;
                        } else {
                            slide.innerHTML = `<div class="prod-slide-empty"><span>${s.type === 'vid' ? '🎬' : '🖼'}</span><span>${s.label}</span></div>`;
                        }
                        track.appendChild(slide);
                    });
                    track.style.transform = `translateX(-${pmCur * 100}%)`;
                }

                function pmRenderDots() {
                    const dots = document.getElementById('pm-dots');
                    dots.innerHTML = '';
                    pmSlides.forEach((_, i) => {
                        const d = document.createElement('div');
                        d.className = 'prod-dot' + (i === pmCur ? ' active' : '');
                        d.onclick = () => pmGoTo(i);
                        dots.appendChild(d);
                    });
                }

                function pmGoTo(i) {
                    pmCur = i;
                    document.getElementById('pm-track').style.transform = `translateX(-${pmCur * 100}%)`;
                    document.querySelectorAll('.prod-dot').forEach((d, idx) => d.classList.toggle('active', idx === pmCur));
                }

                function pmMover(dir) {
                    pmCur = (pmCur + dir + pmSlides.length) % pmSlides.length;
                    pmGoTo(pmCur);
                }

                // =====================
                // Secciones botones (encima de carrusel)
                // =====================
                function showBestSection(section) {
                    const btns = document.querySelectorAll('.best-section-action-btn');
                    btns.forEach(b => {
                        const isActive = (b.getAttribute('onclick') || '').includes(`showBestSection('${section}')`);
                        b.classList.toggle('active', isActive);
                    });

                    const ids = {
                        todos: 'topProductsTodosCarousel',
                        novedades: 'topProductsNovedadesCarousel',
                        populares: 'topProductsPopularesCarousel'
                    };

                    Object.entries(ids).forEach(([key, id]) => {
                        const el = document.getElementById(id);
                        if (!el) return;
                        el.classList.toggle('d-none', key !== section);

                        // Si hay carruseles ya inicializados por Bootstrap, forzamos a recalcular tamaño.
                        try {
                            if (!el.classList.contains('d-none')) {
                                const inst = bootstrap.Carousel.getOrCreateInstance(el, { interval: 4500, ride: true });
                                inst.to(0);
                            }
                        } catch (e) {}
                    });
                }

                // Inicializa en "todos"
                document.addEventListener('DOMContentLoaded', () => {
                    try { showBestSection('todos'); } catch(e) {}
                });
            </script>
        </section>
        {{-- ===================== FIN PRODUCTOS DESTACADOS ===================== --}}

        <section class="testimonials py-5" id="resenasDestacadasSection">
            <div class="container">
                <h2 class="text-center mb-4 zx-title-playfair">Reseñas Destacadas</h2>

                {{-- Botón para mostrar/ocultar la sección de agregar reseña (validación/pendiente en backend) --}}
                <div class="text-center mb-4">
                                <button type="button" class="btn btn-light" id="btnMostrarAgregarResena">
                        Agregar reseña
                    </button>
                    <button type="button" class="btn btn-outline-light" id="btnRevisarResenas" style="margin-left: 10px; border-color: rgba(40,102,110,.35); color:#28666e;">
                        Revisar reseñas
                    </button>
                </div>

                <div id="agregarResenaWrap" class="mb-5" style="display:none;">
                    <div class="review-section" style="max-width: 760px; margin: 0 auto;">
                        <h3>DEJA TU COMENTARIO DEL PRODUCTO</h3>

                        <form id="formAgregarResena" action="{{ url('/productos') }}/" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Producto</label>
                                <select name="producto_id" class="form-select" id="resenaProductoSelect" required>
                                    @foreach(($topProducts ?? collect())->pluck('product')->filter() as $prod)
                                        <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Guest --}}
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
                                        @for($i=1;$i<=5;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control" rows="3" minlength="5" maxlength="1000" required placeholder="Escribe tu reseña..."></textarea>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Enviar reseña</button>
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
                    .resenas-grid { display: none; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1100px; margin: 0 auto; }
                    .resenas-grid.active { display: grid; }
                    .resena-prod-card { background: #fff; border: 1px solid #ddd; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.10); transition: transform .25s ease; }
                    .resena-prod-card img { width: 100%; height: 200px; object-fit: contain; background: #f7f7f7; padding: 16px; }
                </style>

                @php
                    // Ordenadas por mayor cantidad de interacciones (likes)
                    // Nota: se espera que exista una relación/campo de likes para cada review.
                    // Si tu modelo aún no tiene esto, ajustar en backend.
                    $reseñasOrdenadas = ($reseñas ?? collect())->sortByDesc(function($r) {
                        // Ajusta el nombre del campo si tu BD usa otro.
                        return $r->likes_count ?? $r->likes ?? 0;
                    });

                    $resenasPorCategoria = $reseñasOrdenadas->groupBy(fn($r) => optional($r->product)->categoria ?? 'General');
                    $categorias = $resenasPorCategoria->keys();
                @endphp


                <div class="resenas-nav">
                    @foreach($categorias as $i => $cat)
                        <button class="resenas-nav-btn {{ $i === 0 ? 'active' : '' }}" onclick="switchResenas('{{ Str::slug($cat) }}', this)">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                @foreach($resenasPorCategoria as $cat => $resenas)
                    <div class="resenas-grid {{ $loop->first ? 'active' : '' }}" id="resenas-{{ Str::slug($cat) }}">
                        @foreach($resenas->take(3) as $review)
                            @php
                                $cal = (int) ($review->calificacion ?? 0);
                            @endphp
                            <div class="resena-prod-card">
                                <img src="{{ $review->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}" alt="Producto">
                                <div class="card-body">
                                    <h4>{{ $review->product->nombre ?? 'Producto' }}</h4>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $cal ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p>{{ $review->descripcion }}</p>
                                    <p class="reviewer">— {{ $review->guest_nombre ?? 'Usuario desconocido' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <script>
                // Mostrar/ocultar formulario de agregar reseña
                document.addEventListener('DOMContentLoaded', () => {
                    const btn = document.getElementById('btnMostrarAgregarResena');
                    const revisarBtn = document.getElementById('btnRevisarResenas');
                    const wrap = document.getElementById('agregarResenaWrap');
                    const form = document.getElementById('formAgregarResena');
                    const select = document.getElementById('resenaProductoSelect');

                    if (btn && wrap) {
                        btn.addEventListener('click', () => {
                            wrap.style.display = (wrap.style.display === 'none' || !wrap.style.display) ? 'block' : 'none';
                        });
                    }

                    if (revisarBtn) {
                        revisarBtn.addEventListener('click', () => {
                            const section = document.getElementById('resenasDestacadasSection');
                            if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        });
                    }


                    // Ajustar action según producto seleccionado
                    if (form && select) {
                        const setAction = () => {
                            const id = select.value;
                            form.action = `{{ url('/productos') }}/${id}/reviews`;
                        };
                        select.addEventListener('change', setAction);
                        setAction();
                    }
                });

                function switchResenas(slug, btn) { 
                    document.querySelectorAll('.resenas-grid').forEach(g => g.classList.remove('active'));
                    document.querySelectorAll('.resenas-nav-btn').forEach(b => b.classList.remove('active'));
                    document.getElementById('resenas-' + slug).classList.add('active');
                    btn.classList.add('active');
                }
            </script>
        </section>
    </section>

    @include('footer')

    {{-- BOTÓN WHATSAPP FLOTANTE --}}
    <a href="https://wa.me/+525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
       target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

    {{-- Script de Control de Banner (Video/Imagen) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const banner = document.getElementById('carouselBanner');
            if (!banner) return;

            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(banner, {
                interval: 5000,
                ride: true
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
        });
    </script>
</body>
</html>