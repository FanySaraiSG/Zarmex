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

<!-- Font Awesome (AGREGA ESTA LÍNEA) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <!-- CSS Global -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <!-- Vite (Tailwind / JS) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

    {{-- HEADER --}}
   @if(!request()->is('employees/*'))
    {{-- HEADER NORMAL --}}
    @include('header')
@else
    {{-- SOLO BOTÓN CERRAR SESIÓN EN ADMIN --}}
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
      {{-- Para <x-app-layout> --}}
      {{ $slot ?? '' }}

      {{-- Para @extends + @section('content') --}}
      @yield('content')
    </main>

    {{-- FOOTER --}}
    @if(!request()->is('employees/*'))
       @include('footer')
    @endif

  </div>
@if(!request()->is('employees/*'))
    <a href="https://wa.me/525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
       target="_blank"
       style="position:fixed;bottom:25px;right:25px;z-index:999999;background:#25D366;color:#fff;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;font-weight:700;"
       title="Contáctanos por WhatsApp">
        WA
    </a>
@endif
  <!-- Bootstrap JS (bundle con Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
