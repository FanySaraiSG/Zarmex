<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name', 'Zarmex') }} / Nosotros</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

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
       Fondo único #1f3f46
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
       NOSOTROS (DISEÑO CARDS)
       Manteniendo todo lo demás
  ========================== -->
  <section id="nosotros_v2" class="nosotros-v2">
    <div class="container">

      <div class="nosotros-v2__grid">

        <!-- HISTORIA (Izquierda grande) + Carrusel -->
        <article class="nv2-card nv2-card--historia">
          <div class="nv2-historia">

            <div class="nv2-historia__media">
              <div id="carouselHistoriaV2" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{ asset('imagenes/Banner 1.jpg') }}" class="nv2-historia__img" alt="Historia 1">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('imagenes/OIP (1).jpg') }}" class="nv2-historia__img" alt="Historia 2">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('imagenes/OIP (2).jpg') }}" class="nv2-historia__img" alt="Historia 3">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('imagenes/logo.png') }}" class="nv2-historia__img" alt="Historia 4">
                  </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselHistoriaV2" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselHistoriaV2" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Siguiente</span>
                </button>
              </div>

              <div class="nv2-historia__fade"></div>
            </div>

            <div class="nv2-historia__content">
              <h2 class="nv2-card__title">Historia</h2>
              <p class="nv2-card__text">
                Desde nuestros inicios, Zarmex se ha dedicado a ofrecer soluciones confiables en la fabricación
                de productos médicos, con un compromiso constante con la innovación y la calidad.
              </p>
            </div>

          </div>
        </article>

        <!-- MISIÓN (Derecha arriba) -->
        <article class="nv2-card nv2-card--mision">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-solid fa-bullseye"></i></div>
            <h2 class="nv2-card__title">Misión</h2>
          </div>
          <p class="nv2-card__text">
            Brindar soluciones médicas innovadoras que mejoren la salud y bienestar de nuestras comunidades.
          </p>
        </article>

        <!-- VISIÓN (Derecha medio) -->
        <article class="nv2-card nv2-card--vision">
          <div class="nv2-card__head">
            <div class="nv2-icon"><i class="fa-regular fa-eye"></i></div>
            <h2 class="nv2-card__title">Visión</h2>
          </div>
          <p class="nv2-card__text">
            Ser una empresa líder reconocida por su calidad, responsabilidad social y compromiso con la salud.
          </p>
        </article>

        <!-- VALORES (Izquierda abajo) -->
        <article class="nv2-card nv2-card--valores nv2-card--valores-v3">
          <h2 class="nv2-card__title nv2-card__title--center">VALORES</h2>

          <div class="nv2-values nv2-values--v3">
            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3"><i class="fa-regular fa-handshake"></i></div>
              <div class="nv2-value__txt nv2-value__txt--v3">Compromiso</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3"><i class="fa-regular fa-lightbulb"></i></div>
              <div class="nv2-value__txt nv2-value__txt--v3">Innovación</div>
            </div>

            <div class="nv2-value nv2-value--v3">
              <div class="nv2-value__ico nv2-value__ico--v3"><i class="fa-solid fa-people-group"></i></div>
              <div class="nv2-value__txt nv2-value__txt--v3">Trabajo en equipo</div>
            </div>

            <div class="nv2-value nv2-value--v3 nv2-value--center-v3">
              <div class="nv2-value__ico nv2-value__ico--v3"><i class="fa-solid fa-shield-halved"></i></div>
              <div class="nv2-value__txt nv2-value__txt--v3">Responsabilidad</div>
            </div>
          </div>
        </article>

      </div>
    </div>
  </section>

</main>

@include('footer')

</body>
</html>
