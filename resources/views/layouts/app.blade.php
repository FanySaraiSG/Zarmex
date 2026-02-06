<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Zarmex') }}</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- CSS Global (si está en public/css) -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <!-- Vite (Tailwind / JS) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <!-- CSS Header (si lo dejaste en public/css/header.css) -->
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <div style="position:relative; z-index:9999; color:white; font-size:40px;">
  SI CARGA EL DASHBOARD
  </div>

</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

    {{-- HEADER --}}
    @include('header')

    {{-- CONTENIDO --}}
    <main>
      @yield('content')
    </main>
     <a href="https://wa.me/525550518121"
       class="whatsapp-float"
       target="_blank"
       aria-label="Chat en WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    {{-- FOOTER --}}
    @include('.footer')

  </div>
  <!-- Bootstrap JS (una sola vez) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @include('components.whatsapp')

</body>
</html>
