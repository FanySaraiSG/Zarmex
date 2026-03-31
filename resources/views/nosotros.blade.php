<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name', 'Zarmex') }} / Nosotros</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <!-- Playfair Display (TÍTULOS + BIENVENIDOS) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Bootstrap CSS (primero) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tus CSS (después de Bootstrap, y el específico al final) -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
  <link rel="stylesheet" href="{{ asset('css/noso.css') }}">

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>

@include('header')

<main>

  <!-- =========================
       HEADER (Bienvenidos a Zarmex)
  ========================== -->
  <section class="zarmex-hero">
    <div class="container">
      <h1 class="zarmex-hero__title">Bienvenidos a Zarmex</h1>
      <p class="zarmex-hero__subtitle">
        En Zarmex, ofrecemos soluciones innovadoras y confiables para mejorar la salud de nuestras comunidades.
      </p>
    </div>
  </section>
  <!-- =========================
       CARRUSEL ABAJO DE BIENVENIDOS (DINÁMICO DESDE BD)
  ========================== -->
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
                <img src="{{ asset($img->imagen_url) }}"
                     class="nosotros-carousel__img"
                     alt="Nosotros {{ $i+1 }}">
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
  <!-- =========================NOSOTROS (CARDS)========================== -->
  <section id="nosotros_v2" class="nosotros-v2">
    <div class="container">

      <div class="nosotros-v2__grid">

        <!-- HISTORIA (Izquierda grande) SIN CARRUSEL -->
        <article class="nv2-card nv2-card--historia nv2-card--historia-simple">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-solid fa-book-open"></i></div>
            <h2 class="nv2-card__title">Historia</h2>
          </div>
          <p class="nv2-card__text">
            Zarmex ha construido una historia de excelencia en la manufactura, innovación y mantenimiento de equipos médicos en México. Con treinta años de experiencia desde sus inicios en servicios médico-dentales y de optometría, la empresa ha expandido su catálogo para incluir áreas como podología, quiropráctica (con gran especialización), otorrinolaringología, ginecología y fisioterapia. Ofrecen servicios integrales de mantenimiento y modificaciones a nivel nacional e internacional, respaldados por su sólida trayectoria.
          </p>
        </article>

        <!-- MISIÓN (Derecha arriba) -->
        <article class="nv2-card nv2-card--mision">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-solid fa-bullseye"></i></div>
            <h2 class="nv2-card__title">Misión</h2>
          </div>
          <p class="nv2-card__text">
            En Zarmex, nos dedicamos a la fabricación y distribución de equipos de alta calidad, nuestro compromiso es ofrecer productos innovadores, de calidad y adaptados a las necesidades de nuestros clientes, garantizando honestidad y compromiso en cada equipo que diseñamos, trabajamos día a día para brindar soluciones confiables que contribuyan al bienestar de sus pacientes.
          </p>
        </article>

        <!-- VISIÓN (Derecha medio) -->
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

</main>
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

  // Autoplay
  carousel.cycle();

  // Pausa al hover (mouse encima)
  el.addEventListener("mouseenter", () => carousel.pause());
  el.addEventListener("mouseleave", () => carousel.cycle());

  // Pausa si el carrusel no está visible (mejor rendimiento)
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) carousel.cycle();
      else carousel.pause();
    });
  }, { threshold: 0.35 });

  io.observe(el);
});
</script>
@include('footer')

</body>
</html>