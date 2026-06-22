<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Zarmex') }}</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Remixicon (solo UNA vez) -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <!-- CSS Global -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <!-- Vite (Tailwind / JS) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    html, body { 
      background: url('{{ asset('fondo.jpg') }}') !important;
      background-size: cover !important;
      background-position: center !important;
      background-attachment: fixed !important;
    }

    .whatsapp-float {
      position: fixed;
      bottom: 25px;
      right: 25px;
      z-index: 999999;
      background: #25D366;
      color: #fff;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      font-size: 2rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .whatsapp-float:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 18px rgba(0,0,0,0.35);
      color: #fff;
    }
  </style>
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen zx-bg-wrap" style="background-color: transparent !important;">

    {{-- HEADER --}}
    @if(!request()->is('employees/*'))
      @include('header')
    @else
      @auth('employee')
        <div class="admin-top-logout">
          <form method="POST" action="{{ route('employee.logout') }}">
            @csrf
            <button type="submit" class="admin-logout-btn" title="Cerrar sesión">
              <i class="fa-solid fa-right-from-bracket"></i>
            </button>
          </form>
        </div>
      @endauth
    @endif

    {{-- CONTENIDO --}}
    <main>
      {{ $slot ?? '' }}
      @yield('content')
    </main>

    {{-- FOOTER --}}
    @if(!request()->is('employees/*'))
      @include('footer')
    @endif

  </div>

  {{-- BOTÓN WHATSAPP FLOTANTE (solo en páginas públicas) --}}
  @if(!request()->is('employees/*'))
    <a href="https://wa.me/525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
       target="_blank"
       class="whatsapp-float"
       title="Contáctanos por WhatsApp">
      <i class="fab fa-whatsapp"></i>
    </a>
  @endif

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    html, body {
      min-height: 100vh;
      background-image: linear-gradient(
          rgba(255, 255, 255, 0.15),
          rgba(255, 255, 255, 0.15)
        ),
        url('{{ asset('fondo.jpg') }}') !important;
      background-size: cover !important;
      background-position: center !important;
      background-attachment: fixed !important;
      background-color: transparent !important;
    }

    .zx-bg-wrap {
      min-height: 100vh;
      background: transparent !important;
    }
  </style>
</body>
</html>