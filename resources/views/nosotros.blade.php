<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name', 'Zarmex') }} / Nosotros</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght=600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
  <link rel="stylesheet" href="{{ asset('css/noso.css') }}">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>

@include('header')

<main>

  <section class="zarmex-hero">
    <div class="container">
      <h1 class="zarmex-hero__title">Bienvenidos a Zarmex</h1>
      <p class="zarmex-hero__subtitle">
        En Zarmex, ofrecemos soluciones innovadoras y confiables para mejorar la salud de nuestras comunidades.
      </p>
    </div>
  </section>

  <section class="nosotros-carousel">
  <div class="container">
    <div class="nosotros-carousel-container">

      @if(isset($nosotrosBannerImages) && $nosotrosBannerImages->count() > 0)

        <div id="carouselNosotrosV2"
             class="carousel carousel-fade slide"
             data-bs-ride="carousel"
             data-bs-interval="3500"
             data-bs-pause="false">

          {{-- INDICADORES --}}
          <div class="carousel-indicators">
            @foreach($nosotrosBannerImages as $i => $img)
              <button type="button"
                      data-bs-target="#carouselNosotrosV2"
                      data-bs-slide-to="{{ $i }}"
                      class="{{ $i === 0 ? 'active' : '' }}"
                      aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                      aria-label="Slide {{ $i+1 }}">
              </button>
            @endforeach
          </div>

          <div class="carousel-inner">
            @foreach($nosotrosBannerImages as $i => $img)
              <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                @php
                  $ext = strtolower(pathinfo($img->imagen_url, PATHINFO_EXTENSION));
                  $isVideo = in_array($ext, ['mp4', 'webm', 'mov', 'avi']);
                @endphp

                @if($isVideo)
                  <video src="{{ asset($img->imagen_url) }}"
                         class="nosotros-carousel__img"
                         autoplay
                         muted
                         loop
                         playsinline
                         style="object-fit: cover; width: 100%; height: 100%;">
                  </video>
                @else
                  <img src="{{ asset($img->imagen_url) }}"
                       class="nosotros-carousel__img"
                       alt="Nosotros {{ $i+1 }}">
                @endif
              </div>
            @endforeach
          </div>

          {{-- CONTROLES --}}
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselNosotrosV2" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#carouselNosotrosV2" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>

        </div>

      @else
        <div class="alert alert-light text-center mb-0">
          Aún no hay imágenes para el carrusel de <b>Nosotros Banner</b>. Sube algunas desde el panel del admin.
        </div>
      @endif

    </div>
  </div>
</section>

  <section id="nosotros_v2" class="nosotros-v2 pb-0">
    <div class="container">

      <div class="nosotros-v2__grid">

        <article class="nv2-card nv2-card--historia">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-solid fa-book-open"></i></div>
            <h2 class="nv2-card__title">Historia</h2>
          </div>
          <p class="nv2-card__text">
            Zarmex ha construido una historia de excelencia en la manufactura, innovación y mantenimiento de equipos médicos en México. Con treinta años de experiencia desde sus inicios en servicios médico-dentales y de optometría, la empresa ha expandido su catálogo para incluir áreas como podología, quiropráctica (con gran especialización), otorrinolaringología, ginecología y fisioterapia. Ofrecen servicios integrales de mantenimiento y modificaciones a nivel nacional e internacional, respaldados por su sólida trayectoria.
          </p>
        </article>

        <article class="nv2-card nv2-card--mision">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-solid fa-bullseye"></i></div>
            <h2 class="nv2-card__title">Misión</h2>
          </div>
          <p class="nv2-card__text">
            En Zarmex, nos dedicamos a la fabricación y distribución de equipos de alta calidad, nuestro compromiso es ofrecer productos innovadores, de calidad y adaptados a las necesidades de nuestros clientes, garantizando honestidad y compromiso en cada equipo que diseñamos, trabajamos día a día para brindar soluciones confiables que contribuyan al bienestar de sus pacientes.
          </p>
        </article>

        <article class="nv2-card nv2-card--vision">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-regular fa-eye"></i></div>
            <h2 class="nv2-card__title">Visión</h2>
          </div>
          <p class="nv2-card__text">
            Zarmex busca consolidarse como la empresa más grande de México en fabricación y distribución de equipos médicos, expandiendo su presencia en mercados privados y públicos convirtiéndonos en un referente de innovación, tecnología y ergonomía en el sector, aspiramos a dejar un impacto significativo en la salud, integrando nuevas tecnologías en nuestros equipos para mejorar la experiencia de los profesionales y sus pacientes.
          </p>
        </article>

        {{-- VALORES (Izquierda abajo) --}}
        <article class="nv2-card nv2-card--valores nv2-card--valores-v3">
          <h2 class="nv2-card__title nv2-card__title--center">VALORES</h2>

          <div class="nv2-values nv2-values--v3">

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-solid fa-award"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Calidad</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-solid fa-scale-balanced"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Honestidad</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-regular fa-handshake"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Compromiso</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-regular fa-lightbulb"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Innovación</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-solid fa-people-group"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Trabajo en equipo</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-solid fa-medal"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Pasión por la excelencia</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-solid fa-headset"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Servicio al Cliente</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <div class="nv2-value__txt nv2-value__txt--v3">Responsabilidad</div>
            </div>

          </div>
        </article>

      </div>
    </div>
  </section>

  <section class="nosotros-video pt-0 mt-4 pb-5 mb-4">
    <div class="container">
      <div class="row">
        <div class="col-12">

          @if(isset($nosotrosVideos) && $nosotrosVideos->count() > 0)
            
            <div id="carouselVideosAbajo" class="carousel slide" data-bs-ride="carousel" data-bs-interval="8200" data-bs-pause="false">
              
              {{-- Indicadores inferiores si hay más de un video subido --}}
              @if($nosotrosVideos->count() > 1)
                <div class="carousel-indicators" style="bottom: -40px;">
                  @foreach($nosotrosVideos as $i => $vid)
                    <button type="button" 
                            data-bs-target="#carouselVideosAbajo" 
                            data-bs-slide-to="{{ $i }}" 
                            class="bg-dark {{ $i === 0 ? 'active' : '' }}">
                    </button>
                  @endforeach
                </div>
              @endif

              <div class="carousel-inner">
                @foreach($nosotrosVideos as $i => $vid)
                  <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div class="ratio ratio-21x9 rounded-4 overflow-hidden shadow-lg" style="border: 1px solid rgba(255,255,255,0.1);">
                      <video src="{{ asset($vid->imagen_url) }}" 
                             autoplay 
                             muted 
                             loop 
                             playsinline
                             class="video-abajo"
                             style="object-fit: cover; width: 100%; height: 100%; display: block;">
                      </video>
                    </div>
                  </div>
                @endforeach
              </div>

              {{-- Botones de Navegación del carrusel de videos --}}
              @if($nosotrosVideos->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselVideosAbajo" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true" style="padding: 1.5rem;"></span>
                  <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselVideosAbajo" data-bs-slide="next">
                  <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true" style="padding: 1.5rem;"></span>
                  <span class="visually-hidden">Siguiente</span>
                </button>
              @endif

            </div>

          @else
            <div class="ratio ratio-21x9 rounded-4 overflow-hidden" style="border: 2px dashed rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(4px);">
              <div class="d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="mb-2 text-white-50" style="opacity: 0.6;">
                  <i class="fa-solid fa-video-slash" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="text-white fw-bold mb-1">Videos Extra</h5>
                <p class="text-white-50 mb-0 mx-auto" style="font-size: 0.85rem; max-width: 450px; opacity: 0.8;">
                  Puedes subir hasta 3 videos asignados a la sección <code style="color: #ffc107; background: #212529; padding: 2px 6px; border-radius: 4px;">nosotros_video</code> de manera independiente.
                </p>
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </section>

</main>

{{-- Lógica de inicialización segura del Carrusel Superior --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("carouselNosotrosV2");
  if(!el) return;

  const carousel = bootstrap.Carousel.getOrCreateInstance(el, {
    interval: 3800,
    ride: "carousel",
    pause: false,
    touch: true,
    wrap: true
  });

  carousel.cycle();

  el.addEventListener("mouseenter", () => carousel.pause());
  el.addEventListener("mouseleave", () => carousel.cycle());

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) carousel.cycle();
      else carousel.pause();
    });
  }, { threshold: 0.35 });

  io.observe(el);
});
</script>

{{-- Lógica de inicialización del Carrusel de Videos (abajo) --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("carouselVideosAbajo");
  if(!el) return;

  const carousel = bootstrap.Carousel.getOrCreateInstance(el, {
    interval: 8200,
    ride: "carousel",
    pause: false,
    touch: true,
    wrap: true
  });

  const videos = el.querySelectorAll("video.video-abajo");

  function playActiveVideo() {
    videos.forEach(v => {
      const item = v.closest(".carousel-item");
      if (item.classList.contains("active")) {
        v.currentTime = 0;
        v.play().catch(() => {});
      } else {
        v.pause();
      }
    });
  }

  // Reproducir el video activo al cambiar de slide
  el.addEventListener("slid.bs.carousel", playActiveVideo);

  // Reproducir el primer video al cargar
  playActiveVideo();

  carousel.cycle();
});
</script>

@include('footer')

</body>
</html>