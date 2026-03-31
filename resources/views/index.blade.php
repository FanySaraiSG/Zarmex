<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <!-- Fonts -->
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
        /* Hace que el video del banner se vea como imagen (full width, sin deformarse) */
        .banner-media {
            width: 100%;
            height: 436px;      /* mismo alto que tu banner */
            object-fit: cover;  /* recorta bonito */
            display: block;
        }

        /* WHATSAPP FLOAT (AGREGADO) */
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
            z-index: 999999; /* importante para que no lo tape nada */
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

    </div>
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

                            {{-- SI ES VIDEO --}}
                            @if(in_array($extension, ['mp4','webm','ogg']))
                                <video class="d-block w-100"
                                       autoplay
                                       muted
                                       loop
                                       playsinline
                                       style="height:436px; object-fit:cover;">
                                    <source src="{{ asset($image->imagen_url) }}" type="video/{{ $extension }}">
                                    Tu navegador no soporta video HTML5
                                </video>

                            {{-- SI ES IMAGEN --}}
                            @else
                                <img src="{{ asset($image->imagen_url) }}"
                                     class="d-block w-100"
                                     alt="Banner"
                                     style="height:436px; object-fit:cover;">
                            @endif

                        </div>
                    @endforeach

                </div>

                <button class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carouselBanner"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next"
                        type="button"
                        data-bs-target="#carouselBanner"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

        @else
            <div class="content-area">
                <img src="{{ asset('imagenes/banner.jpeg') }}"
                     alt="Banner Predeterminado"
                     style="height:436px; object-fit:cover;">
            </div>
        @endif

        {{-- ===================== LOS MÁS VENDIDOS (CARRUSEL) ===================== --}}
        <section class="products">
            <style>
                /* Contenedor general */
                .best-sellers-wrap{
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 0 15px;
                }

                /* Card estilo (tu mismo look, pero mejor acomodado) */
                .best-card{
                    border: 1px solid #ddd;
                    border-radius: 12px;
                    overflow: hidden;
                    text-align: center;
                    background-color: #fff;
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.12);
                    padding: 16px;
                    height: 100%;
                }

                .best-card img{
                    width: 100%;
                    height: 220px;
                    object-fit: contain;
                    border-radius: 10px;
                    background: #f7f7f7;
                    padding: 8px;
                }

                .best-card h3{
                    font-size: 1.15em;
                    margin: 12px 0 8px;
                    color: #28666e;
                    font-weight: 700;
                }

                .best-card p{
                    font-size: 0.95em;
                    color: #555;
                    margin: 0 0 12px;
                    line-height: 1.4;
                }

                .best-btn{
                    display: inline-block;
                    text-decoration: none;
                    background-color: #28666e;
                    color: #fedc97;
                    padding: 10px 16px;
                    border-radius: 8px;
                    font-weight: 700;
                    transition: background-color .25s ease, transform .2s ease;
                }
                .best-btn:hover{
                    background-color: #7c9885;
                    transform: translateY(-1px);
                    color: #ffffff;
                }

                /* Flechas del carrusel (más visibles) */
                .best-carousel .carousel-control-prev-icon,
                .best-carousel .carousel-control-next-icon{
                    filter: invert(1);
                }

                /* Un poquito de espacio para que las flechas no tapen cards */
                .best-carousel .carousel-control-prev,
                .best-carousel .carousel-control-next{
                    width: 6%;
                }
                .zx-title-playfair{
                  font-family: "Playfair Display", serif !important;
                  font-weight: 700;
                   letter-spacing: .5px;
             }

            </style>

            <h2 class="text-center zx-title-playfair" style="color:#28666e; font-size:2em; margin: 20px 0;"> LOS MÁS VENDIDOS</h2>
            <div class="best-sellers-wrap">
                <div id="topProductsCarousel" class="carousel slide best-carousel" data-bs-ride="carousel" data-bs-interval="4500">
                    <div class="carousel-inner">

                        @foreach($topProducts->chunk(3) as $chunk)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="row g-4">
                                    @foreach($chunk as $topProduct)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="best-card">
                                                <img src="{{ $topProduct->product->imagen_url ?? asset('Imagenes/84493-4540581.jpg') }}"
                                                     alt="{{ $topProduct->product->name ?? 'Producto' }}">

                                                <h3>{{ $topProduct->product->id }}</h3>

                                                <p style="text-align: justify;">
                                                    {{ \Illuminate\Support\Str::limit($topProduct->product->descripcion ?? '', 120) }}
                                                </p>

                                                <a href="{{ route('productos.vermas', ['id' => $topProduct->product->id]) }}"
                                                   class="best-btn">
                                                    Ver más
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

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
        </section>
        {{-- ===================== FIN LOS MÁS VENDIDOS (CARRUSEL) ===================== --}}

        <section class="testimonials py-5">
            <div class="container">
                <h2 class="text-center mb-5 zx-title-playfair">Reseñas Destacadas</h2>

                <div id="reseñasCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($reseñas->chunk(4) as $chunk)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="row">
                                    @foreach($chunk as $review)
                                        <div class="col-md-3 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="stars mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $review->calificacion ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <p class="card-text">{{ $review->descripcion }}</p>
                                                    <h5 class="card-title mt-3">
                                                        {{ $review->guest_nombre ? $review->guest_nombre : 'Usuario desconocido' }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#reseñasCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#reseñasCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </section>

        </main>
        @include('footer')

        {{-- BOTÓN WHATSAPP --}}
        <a href="https://wa.me/+525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
           target="_blank"
           class="whatsapp-float"
           title="Contáctanos por WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>

    {{-- ===== JS para controlar video en carrusel ===== --}}
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
