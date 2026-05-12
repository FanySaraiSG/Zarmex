<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e(config('app.name', 'Zarmex')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/formularios.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/whatsapp-drag.js')); ?>"></script>

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
    <?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
    <section>
        <?php
            $bannerImages = \App\Models\Imagen::where('seccion', 'banner')->get();
        ?>

        <?php if($bannerImages->isNotEmpty()): ?>
            <div id="carouselBanner"
                 class="carousel slide"
                 data-bs-ride="carousel"
                 data-bs-interval="5000">

                <div class="carousel-inner">
                    <?php $__currentLoopData = $bannerImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $extension = strtolower(pathinfo($image->imagen_url, PATHINFO_EXTENSION));
                        ?>

                        <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                            <?php if(in_array($extension, ['mp4','webm','ogg'])): ?>
                                <video class="d-block w-100" autoplay muted loop playsinline style="height:436px; object-fit:cover;">
                                    <source src="<?php echo e(asset($image->imagen_url)); ?>" type="video/<?php echo e($extension); ?>">
                                    Tu navegador no soporta video HTML5
                                </video>
                            <?php else: ?>
                                <img src="<?php echo e(asset($image->imagen_url)); ?>" class="d-block w-100" alt="Banner" style="height:436px; object-fit:cover;">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

        <?php else: ?>
            <div class="content-area">
                <img src="<?php echo e(asset('imagenes/banner.jpeg')); ?>" alt="Banner Predeterminado" style="height:436px; object-fit:cover;">
            </div>
        <?php endif; ?>

        
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
                .best-card img { width: 100%; height: 220px; object-fit: contain; background: #f7f7f7; padding: 8px; }
                .best-card h3 { font-size: 1.1em; margin: 12px 0 8px; color: #28666e; font-weight: 700; text-align: center; }
                .best-card p { font-size: 0.88em; color: #555; margin: 0 0 12px; line-height: 1.4; text-align: justify; padding: 0 8px; }
                .best-btn {
                    display: block; text-align: center; background: #28666e; color: #fedc97;
                    padding: 10px 16px; border-radius: 8px; font-weight: 700; border: none;
                    width: calc(100% - 32px); margin: 0 16px 16px; cursor: pointer;
                    transition: background .25s ease, transform .2s ease;
                }
                .best-btn:hover { background: #1a4a50; transform: translateY(-1px); color: #fff; }

                /* ── Carrusel flechas ── */
                .best-carousel .carousel-control-prev-icon,
                .best-carousel .carousel-control-next-icon { filter: invert(1); }
                .best-carousel .carousel-control-prev,
                .best-carousel .carousel-control-next { width: 6%; }

                /* ── OVERLAY ── */
                .prod-overlay {
                    position: fixed; inset: 0; background: rgba(0,0,0,0.6);
                    z-index: 99999; display: none; align-items: center;
                    justify-content: center; padding: 16px;
                }
                .prod-overlay.open { display: flex; }

                /* ── MODAL ── */
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
                .prod-modal-close {
                    background: #f5f5f5; border: none; border-radius: 50%; width: 30px; height: 30px;
                    cursor: pointer; font-size: 15px; color: #666; display: flex;
                    align-items: center; justify-content: center; transition: background .2s;
                }
                .prod-modal-close:hover { background: #e0e0e0; }

                .prod-modal-body { display: grid; grid-template-columns: 1fr 1fr; }

                /* ── Carrusel del modal ── */
                .prod-carousel-wrap { padding: 18px 18px 16px 20px; border-right: 1px solid #eee; }
                .prod-carousel-stage {
                    position: relative; width: 100%; height: 210px; background: #f7f7f7;
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

                .prod-thumbs-label { font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 7px; }
                .prod-thumbs-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 4px; }
                .prod-thumb {
                    width: 44px; height: 44px; border-radius: 8px; border: 1.5px solid transparent;
                    cursor: pointer; overflow: hidden; background: #f0f0f0; display: flex;
                    align-items: center; justify-content: center; font-size: 18px;
                    transition: border-color .2s, transform .15s; position: relative; flex-shrink: 0;
                }
                .prod-thumb:hover { border-color: #28666e; transform: scale(1.05); }
                .prod-thumb.active { border-color: #28666e; }
                .prod-thumb img { width: 100%; height: 100%; object-fit: contain; padding: 3px; }
                .prod-thumb video { width: 100%; height: 100%; object-fit: cover; }
                .prod-thumb .vid-tag {
                    position: absolute; bottom: 2px; right: 2px; background: #28666e;
                    color: #fedc97; font-size: 8px; padding: 1px 3px; border-radius: 3px; font-weight: 700;
                }

                /* ── Info derecha ── */
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

                /* ── Footer del modal ── */
                .prod-modal-footer {
                    padding: 12px 20px 16px;
                    border-top: 1px solid #eee;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .prod-btn-whatsapp {
                    background: #25D366;
                    color: #fff;
                    border: none;
                    border-radius: 10px;
                    padding: 10px 20px;
                    font-size: 14px;
                    font-weight: 700;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: background .2s, transform .15s;
                }
                .prod-btn-whatsapp:hover { background: #1ebe5d; transform: translateY(-1px); }
                .prod-btn-cerrar {
                    background: #f5f5f5; color: #555; border: 1px solid #ddd; border-radius: 10px;
                    padding: 10px 24px; font-size: 14px; cursor: pointer; transition: background .2s;
                }
                .prod-btn-cerrar:hover { background: #e8e8e8; }

                @media (max-width: 768px) {
                    .prod-modal-body { grid-template-columns: 1fr; }
                    .prod-carousel-wrap { border-right: none; border-bottom: 1px solid #eee; }
                }
            </style>

            <h2 class="text-center zx-title-playfair" style="color:#28666e; font-size:2em; margin: 20px 0;">PRODUCTOS DESTACADOS</h2>

            <div class="best-sellers-wrap">
                <div id="topProductsCarousel" class="carousel slide best-carousel" data-bs-ride="carousel" data-bs-interval="4500">
                    <div class="carousel-inner">
                        <?php $__currentLoopData = $topProducts->chunk(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                                <div class="row g-4">
                                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="best-card">
                                                <img src="<?php echo e($topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg')); ?>"
                                                     alt="<?php echo e($topProduct->product->nombre ?? 'Producto'); ?>">
                                                <h3><?php echo e($topProduct->product->nombre ?? 'Producto'); ?></h3>
                                                <p><?php echo e(\Illuminate\Support\Str::limit($topProduct->product->descripcion ?? '', 100)); ?></p>
                                                <button class="best-btn"
                                                    data-nombre="<?php echo e($topProduct->product->nombre ?? 'Producto'); ?>"
                                                    data-desc="<?php echo e($topProduct->product->descripcion ?? ''); ?>"
                                                    data-img="<?php echo e($topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg')); ?>"
                                                    data-colores="<?php echo e(json_encode(optional($topProduct->product->colores)->pluck('nombre', 'hex') ?? [])); ?>"
                                                    onclick="abrirProdModalDesdeBtn(this)">
                                                    Ver más
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#topProductsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#topProductsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>

            
            <div class="prod-overlay" id="prodOverlay" onclick="if(event.target===this) cerrarProdModal()">
                <div class="prod-modal">
                    <div class="prod-modal-header">
                        <h3 id="pm-nombre"></h3>
                        <button class="prod-modal-close" onclick="cerrarProdModal()">✕</button>
                    </div>
                    <div class="prod-modal-body">

                        
                        <div class="prod-carousel-wrap">
                            <div class="prod-carousel-stage">
                                <div class="prod-carousel-track" id="pm-track"></div>
                                <button class="prod-carr-btn prev" onclick="pmMover(-1)">‹</button>
                                <button class="prod-carr-btn next" onclick="pmMover(1)">›</button>
                            </div>
                            <div class="prod-dots" id="pm-dots"></div>
                            <p class="prod-thumbs-label">Miniaturas</p>
                            <div class="prod-thumbs-row" id="pm-thumbs"></div>
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
                        <button class="prod-btn-cerrar" onclick="cerrarProdModal()">Cerrar</button>
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
                    pmNombreActual = nombre;

                    document.getElementById('pm-nombre').textContent = nombre;
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

                    // Slides: solo imagen principal (las demás se gestionan desde admin)
                    pmSlides = [];
                    pmSlides.push({ type: 'img', src: imgPrincipal, label: 'Imagen 1' });

                    pmCur = 0;
                    pmRenderTrack();
                    pmRenderDots();
                    pmRenderThumbs();

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

                function pmRenderThumbs() {
                    const row = document.getElementById('pm-thumbs');
                    row.innerHTML = '';
                    pmSlides.forEach((s, i) => {
                        const t = document.createElement('div');
                        t.className = 'prod-thumb' + (i === pmCur ? ' active' : '');
                        if (s.src) {
                            t.innerHTML = s.type === 'vid'
                                ? `<video src="${s.src}" muted></video><span class="vid-tag">vid</span>`
                                : `<img src="${s.src}">`;
                        } else {
                            t.innerHTML = `<span style="font-size:10px;color:#aaa">${s.type === 'vid' ? '🎬' : '🖼'}</span>`;
                        }
                        t.onclick = () => pmGoTo(i);
                        row.appendChild(t);
                    });
                }

                function pmGoTo(i) {
                    pmCur = i;
                    document.getElementById('pm-track').style.transform = `translateX(-${pmCur * 100}%)`;
                    document.querySelectorAll('.prod-dot').forEach((d, idx) => d.classList.toggle('active', idx === pmCur));
                    document.querySelectorAll('.prod-thumb').forEach((t, idx) => t.classList.toggle('active', idx === pmCur));
                }

                function pmMover(dir) {
                    pmCur = (pmCur + dir + pmSlides.length) % pmSlides.length;
                    pmGoTo(pmCur);
                }
            </script>
        </section>
        

        <section class="testimonials py-5">
            <div class="container">
                <h2 class="text-center mb-4 zx-title-playfair">Reseñas Destacadas</h2>

                <style>
                    .resenas-nav {
                        display: flex;
                        justify-content: center;
                        flex-wrap: wrap;
                        gap: 10px;
                        margin-bottom: 32px;
                    }
                    .resenas-nav-btn {
                        padding: 8px 22px;
                        border-radius: 999px;
                        border: 2px solid #28666e;
                        background: transparent;
                        color: #28666e;
                        font-weight: 700;
                        font-size: 0.88em;
                        cursor: pointer;
                        transition: background .25s, color .25s, transform .2s;
                        letter-spacing: .4px;
                    }
                    .resenas-nav-btn:hover,
                    .resenas-nav-btn.active {
                        background: #28666e;
                        color: #fedc97;
                        transform: translateY(-2px);
                    }
                    .resenas-grid {
                        display: none;
                        grid-template-columns: repeat(3, 1fr);
                        gap: 24px;
                        max-width: 1100px;
                        margin: 0 auto;
                    }
                    .resenas-grid.active { display: grid; }
                    .resena-prod-card {
                        background: #fff;
                        border: 1px solid #ddd;
                        border-radius: 16px;
                        overflow: hidden;
                        box-shadow: 0 4px 12px rgba(0,0,0,.10);
                        transition: transform .25s ease, box-shadow .25s ease;
                        cursor: pointer;
                    }
                    .resena-prod-card:hover {
                        transform: translateY(-8px);
                        box-shadow: 0 12px 28px rgba(40,102,110,.18);
                    }
                    .resena-prod-card img {
                        width: 100%;
                        height: 200px;
                        object-fit: contain;
                        background: #f7f7f7;
                        padding: 16px;
                    }
                    .resena-prod-card .card-body { padding: 16px; }
                    .resena-prod-card h4 {
                        font-size: 1.05em;
                        font-weight: 700;
                        color: #28666e;
                        margin: 0 0 8px;
                        text-align: center;
                    }
                    .resena-prod-card .stars { text-align: center; margin-bottom: 8px; }
                    .resena-prod-card p {
                        font-size: 0.88em;
                        color: #555;
                        text-align: justify;
                        line-height: 1.45;
                        margin: 0;
                    }
                    .resena-prod-card .reviewer {
                        margin-top: 10px;
                        font-size: 0.82em;
                        font-weight: 700;
                        color: #888;
                        text-align: right;
                    }
                    @media (max-width: 768px) {
                        .resenas-grid { grid-template-columns: 1fr; }
                    }
                </style>

                <?php
                    $resenasPorCategoria = $reseñas->groupBy(function($r) {
                        return $r->product->categoria ?? 'General';
                    });
                    $categorias = $resenasPorCategoria->keys();
                ?>

                <div class="resenas-nav">
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            class="resenas-nav-btn <?php echo e($i === 0 ? 'active' : ''); ?>"
                            onclick="switchResenas('<?php echo e(Str::slug($cat)); ?>', this)">
                            <?php echo e($cat); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php $__currentLoopData = $resenasPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $resenas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $top3 = $resenas->sortByDesc(fn($r) => $r->product->ventas ?? 0)->take(3);
                    ?>

                    <div class="resenas-grid <?php echo e($loop->first ? 'active' : ''); ?>"
                         id="resenas-<?php echo e(Str::slug($cat)); ?>">

                        <?php $__currentLoopData = $top3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="resena-prod-card">
                                <img
                                    src="<?php echo e($review->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg')); ?>"
                                    alt="<?php echo e($review->product->nombre ?? 'Producto'); ?>">

                                <div class="card-body">
                                    <h4><?php echo e($review->product->nombre ?? 'Producto'); ?></h4>

                                    <div class="stars">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo e($i <= $review->calificacion ? 'text-warning' : 'text-muted'); ?>"></i>
                                        <?php endfor; ?>
                                    </div>

                                    <p><?php echo e($review->descripcion); ?></p>

                                    <p class="reviewer">
                                        — <?php echo e($review->guest_nombre ?? 'Usuario desconocido'); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <script>
                function switchResenas(slug, btn) {
                    document.querySelectorAll('.resenas-grid').forEach(g => g.classList.remove('active'));
                    document.querySelectorAll('.resenas-nav-btn').forEach(b => b.classList.remove('active'));
                    document.getElementById('resenas-' + slug).classList.add('active');
                    btn.classList.add('active');
                }
            </script>
        </section>

        </main>
        <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <a href="https://wa.me/+525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
           target="_blank"
           class="whatsapp-float"
           title="Contáctanos por WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>

    
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

</html><?php /**PATH C:\Users\Dhust\Desktop\AlaEstadia\Zarmex 2\Zarmex original\zarmex\resources\views/index.blade.php ENDPATH**/ ?>