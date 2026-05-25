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
        /* ===================== ESTILOS GENERALES Y BANNER ===================== */
        .banner-media {
            width: 100%;
            height: 600px;
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

        /* ===================== OVERLAY Y MODAL DETALLES ===================== */
        .prod-overlay {
            position: fixed; 
            inset: 0; 
            background: rgba(0,0,0,0.6);
            z-index: 99999; 
            display: none; 
            align-items: center;
            justify-content: center; 
            padding: 16px;
        }
        .prod-overlay.open { display: flex; }

        .prod-modal {
            background: #fff; 
            border-radius: 16px; 
            width: 100%; 
            max-width: 740px;
            max-height: 90vh; 
            overflow-y: auto; 
            border: 1px solid #ddd;
            position: relative;
            animation: prodPopIn 0.3s ease;
        }

        .prod-modal-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid rgba(184,161,32,0.55);
            background: #fff;
            color: #28666e;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 3;
            transition: transform 0.15s ease, background 0.2s ease, color 0.2s ease;
        }

        .prod-modal-close:hover {
            transform: scale(1.05);
            background: rgba(184,161,32,0.15);
            color: #1a4a50;
        }

        @keyframes prodPopIn { 
            from { opacity:0; transform:scale(.94); } 
            to { opacity:1; transform:scale(1); } 
        }

        .prod-modal-header {
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            padding: 16px 20px 14px; 
            border-bottom: 1px solid #eee;
        }
        .prod-modal-header h3 { font-size: 1.1em; font-weight: 700; color: #28666e; margin: 0; }

        .prod-modal-body { display: grid; grid-template-columns: 1fr 1fr; }

        .prod-carousel-wrap { padding: 18px 18px 16px 20px; border-right: 1px solid #eee; }
        .prod-carousel-stage {
            position: relative; width: 100%; height: 300px; background: #f7f7f7;
            border-radius: 12px; overflow: hidden; margin-bottom: 10px;
        }
        .prod-carousel-track { display: flex; height: 100%; transition: transform .35s cubic-bezier(.23,1,.32,1); }
        .prod-carousel-slide { min-width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .prod-carousel-slide img { width: 100%; height: 100%; object-fit: contain; padding: 12px; }
        
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
                        @endphp

                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            @if(in_array($extension, ['mp4','webm','ogg','mov','avi']))
                                <video class="banner-video banner-media" autoplay muted loop playsinline>
                                    <source src="{{ asset($image->imagen_url) }}" type="video/{{ $extension === 'mov' ? 'mp4' : $extension }}">
                                    Tu navegador no soporta video HTML5
                                </video>
                            @else
                                <img src="{{ asset($image->imagen_url) }}" class="banner-media" alt="Banner">
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
                <div class="best-section-actions" aria-label="Secciones de productos destacados">
                    <button type="button" class="best-section-action-btn active" onclick="filterPasarela('todos')">Todos</button>
                    <button type="button" class="best-section-action-btn" onclick="filterPasarela('novedades')">Novedades</button>
                    <button type="button" class="best-section-action-btn" onclick="filterPasarela('populares')">Populares</button>
                </div>

                @if(($topProducts ?? collect())->count() === 0)
                    <div style="text-align:center; color:#666; padding: 24px;">No hay productos destacados disponibles.</div>
                @else
                    
                    {{-- PASARELA CON DESPLAZAMIENTO CENTRADO --}}
                    <div class="custom-carousel-container">
                        <div class="custom-carousel-track" id="pasarelaTrack">
                            @foreach($topProducts as $topProduct)
                                @if($topProduct->product)
                                    <div class="custom-carousel-item" data-section="{{ $topProduct->section ?? 'todos' }}">
                                        <div class="best-card">
                                            <img src="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}" alt="{{ $topProduct->product->nombre ?? 'Producto' }}">
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

                        <div class="custom-carousel-control prev" onclick="moverPasarela(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="custom-carousel-control next" onclick="moverPasarela(1)">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                @endif
            </div>

            {{-- ── MODAL DE DETALLE ── --}}
            <div class="prod-overlay" id="prodOverlay" onclick="if(event.target===this) cerrarProdModal()">
                <div class="prod-modal">
                    <button type="button" class="prod-modal-close" onclick="cerrarProdModal()" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="prod-modal-header">
                        <h3 id="pm-nombre"></h3>
                    </div>

                    <div class="prod-modal-body">
                        <div class="prod-carousel-wrap">
                            <div class="prod-carousel-stage">
                                <div class="prod-carousel-track" id="pm-track"></div>
                                <button class="prod-carr-btn prev" onclick="pmMover(-1)">‹</button>
                                <button class="prod-carr-btn next" onclick="pmMover(1)">›</button>
                            </div>
                            <div class="prod-dots" id="pm-dots"></div>
                        </div>

                        <div class="prod-modal-right">
                            <p class="prod-info-label">Descripción</p>
                            <p class="prod-desc-full" id="pm-desc"></p>

                            <p class="prod-info-label">Colores disponibles</p>
                            <div class="prod-colors-wrap" id="pm-colors"></div>
                            <p class="prod-sel-color" id="pm-color-name">Selecciona un color</p>
                        </div>
                    </div>

                    <div class="prod-modal-footer">
                        <button class="prod-btn-whatsapp" onclick="abrirWhatsapp()">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </button>
                    </div>
                </div>
            </div>

            <script>
                let currentIndex = 0;
                let visibleItems = [];

                function initPasarela() {
                    const allItems = Array.from(document.querySelectorAll('.custom-carousel-item'));
                    const activeBtn = document.querySelector('.best-section-action-btn.active');
                    const section = activeBtn ? activeBtn.textContent.trim().toLowerCase() : 'todos';
                    
                    visibleItems = allItems.filter(item => {
                        if (section === 'todos') {
                            item.style.display = 'flex';
                            return true;
                        } else {
                            const match = item.getAttribute('data-section') === section;
                            item.style.display = match ? 'flex' : 'none';
                            return match;
                        }
                    });

                    // Por defecto, empezamos centrando la primera tarjeta ([0])
                    currentIndex = 0;
                    actualizarPasarela();
                }

                function filterPasarela(section) {
                    document.querySelectorAll('.best-section-action-btn').forEach(btn => btn.classList.remove('active'));
                    event.target.classList.add('active');
                    initPasarela();
                }

                function moverPasarela(direccion) {
                    if (visibleItems.length === 0) return;
                    
                    // Rotación cíclica infinita de uno en uno
                    currentIndex = (currentIndex + direccion + visibleItems.length) % visibleItems.length;
                    actualizarPasarela();
                }

                function actualizarPasarela() {
                    const track = document.getElementById('pasarelaTrack');
                    if (!track || visibleItems.length === 0) return;

                    const isMobile = window.innerWidth < 768;
                    
                    // 1. Limpiar la clase center de todos los elementos
                    visibleItems.forEach(item => item.classList.remove('center'));

                    // 2. Aplicar la clase center a la tarjeta que le toca estar en medio
                    if (visibleItems[currentIndex]) {
                        visibleItems[currentIndex].classList.add('center');
                    }

                    // 3. NUEVO CÁLCULO DE ALINEACIÓN: Centrado Dinámico Exacto
                    let targetDesplazamiento = 0;

                    if (isMobile) {
                        targetDesplazamiento = -currentIndex * 100;
                    } else {
                        // El truco es restar el ancho acumulado de los elementos anteriores (-currentIndex * 33.33%)
                        // Y sumarle un desfase positivo estático de un tercio (33.33%) para empujar la tarjeta activa justo al CENTRO exacto de la vista
                        targetDesplazamiento = -(currentIndex * 33.333333) + 33.333333;
                    }

                    track.style.transform = `translateX(${targetDesplazamiento}%)`;
                }

                document.addEventListener('DOMContentLoaded', initPasarela);
                window.addEventListener('resize', actualizarPasarela);

                // movimiento automático cada 4.5 segundos
                let autoPlayInterval = setInterval(() => {
                moverPasarela(1); // Mueve a la siguiente tarjeta
                }, 4500);

                const container = document.querySelector('.custom-carousel-container');
                  if (container) {
                  container.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
                 container.addEventListener('mouseleave', () => {
                 autoPlayInterval = setInterval(() => { moverPasarela(1); }, 3500);
                });
}


                /* CÓDIGO EXISTENTE DE CONTROL DE MODAL */
                let pmSlides = [], pmCur = 0, pmNombreActual = '';

                function abrirProdModalDesdeBtn(btn) {
                    const nombre  = btn.getAttribute('data-nombre');
                    const desc    = btn.getAttribute('data-desc');
                    const img     = btn.getAttribute('data-img');
                    const colores = JSON.parse(btn.getAttribute('data-colores') || '{}');
                    abrirProdModal(nombre, desc, img, colores);
                }

                function abrirProdModal(nombre, desc, imgPrincipal, colores) {
                    const partes = nombre.split(' ');
                    const soloCodigo = partes[partes.length - 1];
                    
                    pmNombreActual = soloCodigo;
                    document.getElementById('pm-nombre').textContent = soloCodigo;
                    document.getElementById('pm-desc').textContent = desc;

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

                    pmSlides = [{ type: 'img', src: imgPrincipal, label: 'Imagen 1' }];
                    pmCur = 0;
                    pmRenderTrack();
                    pmRenderDots();

                    document.getElementById('prodOverlay').classList.add('open');
                }

                function cerrarProdModal() {
                    document.getElementById('prodOverlay').classList.remove('open');
                }

                function pmRenderTrack() {
                    const track = document.getElementById('pm-track');
                    track.innerHTML = `<div class="prod-carousel-slide"><img src="${pmSlides[0].src}"></div>`;
                }

                function pmRenderDots() {
                    const dots = document.getElementById('pm-dots');
                    dots.innerHTML = '<div class="prod-dot active"></div>';
                }

                function pmMover(dir) {}

                function abrirWhatsapp() {
                    const colorSeleccionado = document.getElementById('pm-color-name').textContent;
                    const textoColor = colorSeleccionado !== 'Selecciona un color' ? ` en color ${colorSeleccionado}` : '';
                    const mensaje = encodeURIComponent(`Hola Zarmex, me interesa obtener más información del producto destacado: ${pmNombreActual}${textoColor}`);
                    window.open(`https://wa.me/525581366555?text=${mensaje}`, '_blank');
                }
            </script>
        </section>

<<<<<<< HEAD
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
=======
        {{-- ===================== SECCIÓN RESEÑAS ===================== --}}
        <section class="testimonials py-5" id="resenasDestacadasSection">
            <div class="container">
                <h2 class="text-center mb-4 zx-title-playfair">Reseñas Destacadas</h2>

                <div class="text-center mb-4">
                    <button type="button" class="btn btn-light" id="btnMostrarAgregarResena">Agregar reseña</button>
                    <button type="button" class="btn btn-outline-light" id="btnRevisarResenas" style="margin-left: 10px; border-color: rgba(40,102,110,.35); color:#28666e;">Revisar reseñas</button>
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

                @php
                    $reseñasOrdenadas = ($reseñas ?? collect())->sortByDesc(fn($r) => $r->likes_count ?? $r->likes ?? 0);
                    $resenasPorCategoria = $reseñasOrdenadas->groupBy(fn($r) => optional($r->product)->categoria ?? 'General');
                    $categorias = $resenasPorCategoria->keys();
                @endphp

                <div class="resenas-nav">
                    @foreach($categorias as $i => $cat)
                        <button class="resenas-nav-btn {{ $i === 0 ? 'active' : '' }}" onclick="switchResenas('{{ Str::slug($cat) }}', this)">{{ $cat }}</button>
                    @endforeach
                </div>

                @foreach($resenasPorCategoria as $cat => $resenas)
                    <div class="resenas-grid {{ $loop->first ? 'active' : '' }}" id="resenas-{{ Str::slug($cat) }}">
                        @foreach($resenas->take(3) as $review)
                            <div class="resena-prod-card">
                                <img src="{{ $review->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}" alt="Producto">
                                <div class="card-body" style="padding: 15px;">
                                    <h4>{{ $review->product->nombre ?? 'Producto' }}</h4>
                                    <div class="stars" style="margin-bottom: 10px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= (int)($review->calificacion ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p>{{ $review->descripcion }}</p>
                                    <p class="reviewer" style="font-weight: bold; font-style: italic;">— {{ $review->guest_nombre ?? 'Usuario desconocido' }}</p>
>>>>>>> c9b56c91752fd6aebaef7ef8c1e0db8b75eeacdd
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

<<<<<<< HEAD
            {{-- GRIDS POR PUNTUACIÓN --}}
            @foreach($resenasPorPuntuacion as $puntos => $resenas)
                <div class="resenas-grid {{ $loop->first ? 'active' : '' }}" id="resenas-{{ Str::slug($puntos) }}">
                    @foreach($resenas->take(6) as $review)
                        @php 
                            $cal              = (int) ($review->calificacion ?? 0); 
                            $reviewGridId     = $review->id_reseña ?? $review->id;
                            $likesGridActuales = $review->likes_count ?? $review->likes ?? 0;

                            // ✅ optional() evita error si product es null
                            $imagenGrid      = optional($review->product)->imagen_url ?? $imagenFallback;
                            $nombreGrid      = optional($review->product)->nombre ?? 'Producto';
                        @endphp
                        <div class="resena-prod-card" data-card-id="{{ $reviewGridId }}">
                            <img src="{{ $imagenGrid }}" alt="Producto">
                            <div class="card-body p-3">
                                <h4>{{ $nombreGrid }}</h4>
                                <div class="stars mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $cal ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <p class="card-text">{{ $review->descripcion }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <p class="reviewer m-0 font-italic" style="font-size:0.9em;">— {{ $review->guest_nombre ?? 'Usuario desconocido' }}</p>
                                    <small class="text-muted">
                                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 js-review-like text-muted" data-review-id="{{ $reviewGridId }}">
                                            <i class="fas fa-heart text-danger"></i> 
                                            <span class="likes-count">{{ $likesGridActuales }}</span>
                                        </button>
                                    </small>
                                </div>
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
=======
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.getElementById('btnMostrarAgregarResena')?.addEventListener('click', () => {
                        const wrap = document.getElementById('agregarResenaWrap');
                        wrap.style.display = (wrap.style.display === 'none' || !wrap.style.display) ? 'block' : 'none';
                    });

                    document.getElementById('btnRevisarResenas')?.addEventListener('click', () => {
                        document.getElementById('resenasDestacadasSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });

                    const select = document.getElementById('resenaProductoSelect');
                    const form = document.getElementById('formAgregarResena');
                    if (form && select) {
                        const setAction = () => { form.action = `{{ url('/productos') }}/${select.value}/reviews`; };
                        select.addEventListener('change', setAction);
                        setAction();
                    }
                });
>>>>>>> c9b56c91752fd6aebaef7ef8c1e0db8b75eeacdd

                <form id="formAgregarResena" action="{{ url('/productos') }}/" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Producto</label>
                        <select name="producto_id" class="form-select" id="resenaProductoSelect" required>
                            @foreach(($topProducts ?? collect())->pluck('product')->filter() as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
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

<<<<<<< HEAD
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
            .resenas-grid { display: none; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1100px; margin: 0 auto; }
            .resenas-grid.active { display: grid; }
            @media (max-width: 991px) { .resenas-grid.active { grid-template-columns: repeat(2, 1fr); } }
            @media (max-width: 576px) { .resenas-grid.active { grid-template-columns: 1fr; } }
            
            .resena-prod-card { background: #fff; border: 1px solid #ddd; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.10); transition: transform .25s ease; }
            .resena-prod-card img { width: 100%; height: 200px; object-fit: contain; background: #f7f7f7; padding: 16px; }
            
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
=======
    <a href="https://wa.me/+525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const banner = document.getElementById('carouselBanner');
            if (!banner) return;
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(banner, { interval: 5000, ride: true });

            function pauseAllVideos() {
                banner.querySelectorAll('video.banner-video').forEach(v => { try { v.pause(); v.currentTime = 0; } catch(e) {} });
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
>>>>>>> c9b56c91752fd6aebaef7ef8c1e0db8b75eeacdd
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

{{-- INCLUSIÓN DEL FOOTER --}}
@include('footer')

{{-- BOTÓN WHATSAPP FLOTANTE --}}
<a href="https://wa.me/+525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
   target="_blank" class="whatsapp-float">
    <i class="fab fa-whatsapp"></i>
</a>

{{-- Control de Banners de Video/Imagen --}}
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