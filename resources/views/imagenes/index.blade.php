<x-app-layout>
  @auth('employee')
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Galería Multimedia</title>
    <style>
      * { box-sizing: border-box; }
      body { background-color: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
      nav { background-color: inherit !important; }

      /* ── HEADER ── */
      .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 32px 18px;
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        position: sticky;
        top: 0;
        z-index: 50;
      }
      .page-header .logo-area { display: flex; align-items: center; gap: 12px; }
      .page-header h1 { font-size: 1.5rem; font-weight: 800; color: #1a1a2e; margin: 0; letter-spacing: -0.3px; }
      .page-header p { font-size: 0.82rem; color: #6c757d; margin: 2px 0 0; }
      .header-icon { width: 42px; height: 42px; background: #e8f4f5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #28666e; font-size: 1.2rem; }

      .btn-back { background: transparent; border: 1.5px solid #dee2e6; color: #495057; font-weight: 600; font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; text-decoration: none; transition: all 0.18s; display: inline-flex; align-items: center; gap: 6px; }
      .btn-back:hover { background: #f1f3f5; color: #343a40; border-color: #adb5bd; }
      .btn-upload-img { background: #28666e; color: #fff; border: none; font-weight: 700; font-size: 0.85rem; padding: 9px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: background 0.18s; }
      .btn-upload-img:hover { background: #1d4e54; color: #fff; }
      .btn-upload-vid { background: #fedc97; color: #28666e; border: 2px solid #28666e; font-weight: 700; font-size: 0.85rem; padding: 9px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: all 0.18s; }
      .btn-upload-vid:hover { background: #28666e; color: #fedc97; }
      .btn-upload-logo { background: #fff3cd; color: #856404; border: 2px solid #ffc107; font-weight: 700; font-size: 0.85rem; padding: 9px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: all 0.18s; }
      .btn-upload-logo:hover { background: #ffc107; color: #212529; }
      .header-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

      /* ── MAIN LAYOUT ── */
      .main-wrap { max-width: 1280px; margin: 0 auto; padding: 28px 24px 60px; }

      /* ── SECCIONES ── */
      .section-label { font-size: 0.78rem; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: #6c757d; margin-bottom: 14px; }

      /* Banner + Nosotros: 2 columnas iguales */
      .section-cards-main { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 16px; }
      @media(max-width:640px){ .section-cards-main { grid-template-columns: 1fr; } }

      /* Logo: fila completa horizontal */
      .section-card-logo-row { margin-bottom: 28px; }

      .sec-card { background: #fff; border-radius: 14px; border: 1.5px solid #e9ecef; padding: 20px 22px 16px; cursor: pointer; transition: border-color 0.18s, box-shadow 0.18s; display: flex; flex-direction: column; gap: 10px; }
      .sec-card:hover, .sec-card.active { border-color: #28666e; box-shadow: 0 4px 16px rgba(40,102,110,0.10); }

      /* Tarjeta logo horizontal */
      .sec-card-logo {
        background: #fff;
        border-radius: 14px;
        border: 1.5px solid #e9ecef;
        padding: 18px 24px;
        cursor: pointer;
        transition: border-color 0.18s, box-shadow 0.18s;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
      }
      .sec-card-logo:hover { border-color: #ffc107; box-shadow: 0 4px 16px rgba(255,193,7,0.12); }
      .sec-card-logo.active-logo { border-color: #ffc107; box-shadow: 0 4px 16px rgba(255,193,7,0.18); background: #fffdf0; }

      /* Logo preview inline dentro de la tarjeta horizontal */
      .logo-card-thumb {
        background: #f8f9fa;
        border: 1.5px dashed #e5e7eb;
        border-radius: 10px;
        width: 110px;
        height: 60px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }
      .logo-card-thumb img { max-height: 52px; max-width: 100px; object-fit: contain; }
      .logo-card-no-img { color: #c9d1d9; font-size: 1.4rem; }

      .sec-card-logo-info { flex: 1; min-width: 160px; }
      .sec-card-logo-info h3 { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 3px; }
      .sec-card-logo-info p  { font-size: 0.78rem; color: #6c757d; margin: 0; }

      .sec-card-logo-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }

      .sec-card-top { display: flex; align-items: center; justify-content: space-between; }
      .sec-card-meta { display: flex; align-items: center; gap: 12px; }
      .sec-icon { width: 44px; height: 44px; border-radius: 10px; background: #e8f4f5; display: flex; align-items: center; justify-content: center; color: #28666e; font-size: 1.25rem; flex-shrink: 0; }
      .sec-icon.amber { background: #fff8e1; color: #b8860b; }
      .sec-icon.gold  { background: #fff3cd; color: #856404; }
      .sec-card-info h3 { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 3px; }
      .sec-card-info p { font-size: 0.78rem; color: #6c757d; margin: 0; }
      .count-badge { background: #e8f4f5; color: #28666e; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
      .count-badge.gold { background: #fff3cd; color: #856404; }
      .sec-arrow { color: #adb5bd; font-size: 0.9rem; }

      .thumb-strip { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 2px; }
      .thumb-strip::-webkit-scrollbar { height: 4px; }
      .thumb-strip::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 4px; }
      .thumb-item { width: 88px; height: 60px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: #f1f3f5; position: relative; }
      .thumb-item img, .thumb-item video { width: 100%; height: 100%; object-fit: cover; }
      .thumb-play-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.35); color: #fff; font-size: 1.1rem; }

      /* ── TABLA + PREVIEW PANEL ── */
      .content-area { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
      @media(max-width:960px){ .content-area { grid-template-columns: 1fr; } }

      .table-panel { background: #fff; border-radius: 14px; border: 1.5px solid #e9ecef; overflow: hidden; }
      .table-panel-header { padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f3f5; flex-wrap: wrap; gap: 10px; }
      .table-panel-header h4 { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin: 0; }
      .table-panel-header p { font-size: 0.78rem; color: #6c757d; margin: 2px 0 0; }

      .filter-tabs { display: flex; gap: 6px; }
      .ftab { background: #f1f3f5; border: none; color: #495057; font-size: 0.8rem; font-weight: 600; padding: 6px 14px; border-radius: 20px; cursor: pointer; transition: all 0.15s; }
      .ftab.active { background: #28666e; color: #fff; }
      .ftab:hover:not(.active) { background: #e2e6ea; }

      .search-wrap { position: relative; }
      .search-wrap input { border: 1.5px solid #dee2e6; border-radius: 8px; padding: 7px 12px 7px 34px; font-size: 0.82rem; color: #495057; outline: none; width: 190px; transition: border-color 0.15s; }
      .search-wrap input:focus { border-color: #28666e; }
      .search-wrap .search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 0.8rem; pointer-events: none; }

      .media-table { width: 100%; border-collapse: collapse; }
      .media-table thead tr { background: #f8f9fa; }
      .media-table th { font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; border-bottom: 1px solid #f1f3f5; }
      .media-table td { padding: 10px 14px; border-bottom: 1px solid #f8f9fa; vertical-align: middle; }
      .media-table tr:last-child td { border-bottom: none; }
      .media-table tr { cursor: pointer; transition: background 0.12s; }
      .media-table tr:hover td { background: #f8fcfc; }
      .media-table tr.selected td { background: #e8f4f5; }

      .row-thumb { width: 48px; height: 36px; border-radius: 6px; object-fit: cover; background: #f1f3f5; display: block; flex-shrink: 0; }
      .row-thumb-wrap { position: relative; width: 48px; height: 36px; flex-shrink: 0; }
      .row-thumb-wrap .vid-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.8rem; background: rgba(0,0,0,0.35); border-radius: 6px; }
      .row-name { font-size: 0.85rem; font-weight: 600; color: #1a1a2e; }
      .row-sub { font-size: 0.75rem; color: #6c757d; margin-top: 1px; }

      .type-icon-img { color: #28666e; }
      .type-icon-vid { color: #e8500a; }

      .btn-action { width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid #dee2e6; background: #fff; color: #495057; font-size: 0.75rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; text-decoration: none; }
      .btn-action:hover { background: #f1f3f5; border-color: #adb5bd; color: #1a1a2e; }
      .btn-action.danger:hover { background: #fff0f0; border-color: #f5c6cb; color: #dc3545; }

      /* ── PREVIEW PANEL ── */
      .preview-panel { background: #fff; border-radius: 14px; border: 1.5px solid #e9ecef; overflow: hidden; position: sticky; top: 80px; }
      .preview-placeholder { height: 240px; background: #f8f9fa; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #adb5bd; gap: 8px; }
      .preview-placeholder i { font-size: 2rem; }
      .preview-placeholder span { font-size: 0.82rem; }
      .preview-media-wrap { height: 240px; background: #1a1a1a; display: none; overflow: hidden; }
      .preview-media-wrap img, .preview-media-wrap video { width: 100%; height: 100%; object-fit: contain; display: block; }
      .preview-info { padding: 16px 18px; border-top: 1px solid #f1f3f5; }
      .preview-filename { font-size: 0.9rem; font-weight: 700; color: #1a1a2e; word-break: break-all; margin-bottom: 8px; }
      .preview-meta { display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.78rem; color: #6c757d; }
      .preview-meta span { display: flex; align-items: center; gap: 5px; }
      .preview-empty-info { padding: 18px; color: #adb5bd; font-size: 0.82rem; text-align: center; }

      .sec-pill { font-size: 0.7rem; font-weight: 700; padding: 2px 9px; border-radius: 20px; white-space: nowrap; }
      .sec-pill-banner   { background: #e3f2fd; color: #1565c0; }
      .sec-pill-nosotros { background: #e0f7fa; color: #006064; }
      .sec-pill-logo     { background: #fff3cd; color: #856404; }
      .sec-pill-brand    { background: #f3e8ff; color: #7e22ce; }
      .sec-pill-default  { background: #f1f3f5; color: #495057; }

      .empty-state { padding: 48px 20px; text-align: center; color: #adb5bd; }
      .empty-state i { font-size: 2.5rem; margin-bottom: 12px; display: block; }
      .empty-state p { font-size: 0.9rem; margin: 0; }

      /* ── LOGO SECTION SPECIAL PANEL ── */
      .logo-section-panel {
        background: #fff;
        border-radius: 14px;
        border: 1.5px solid #ffc107;
        padding: 24px 28px;
        margin-bottom: 28px;
        display: none;
      }
      .logo-section-panel.visible { display: block; }
      .logo-section-panel h4 { font-size: 1rem; font-weight: 700; color: #856404; margin: 0 0 16px; display: flex; align-items: center; gap: 8px; }
      .logo-current-wrap {
        display: flex; align-items: center; gap: 24px; flex-wrap: wrap;
      }
      .logo-img-box {
        background: #f8f9fa;
        border: 1.5px dashed #dee2e6;
        border-radius: 12px;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 160px;
        min-height: 90px;
      }
      .logo-img-box img { max-height: 70px; max-width: 200px; object-fit: contain; }
      .logo-no-img { color: #adb5bd; font-size: 0.82rem; text-align: center; }
      .logo-meta { flex: 1; }
      .logo-meta .lm-name { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
      .logo-meta .lm-date { font-size: 0.78rem; color: #6c757d; margin-bottom: 14px; }
      .logo-actions { display: flex; gap: 10px; flex-wrap: wrap; }
      .btn-edit-logo {
        background: #28666e; color: #fff; border: none; font-weight: 700; font-size: 0.82rem;
        padding: 8px 16px; border-radius: 8px; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px; transition: background 0.18s;
      }
      .btn-edit-logo:hover { background: #1d4e54; color: #fff; }
      .btn-del-logo {
        background: #fff; color: #dc3545; border: 1.5px solid #f5c6cb; font-weight: 700; font-size: 0.82rem;
        padding: 8px 16px; border-radius: 8px; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px; transition: all 0.18s;
      }
      .btn-del-logo:hover { background: #fff0f0; border-color: #dc3545; }
      .btn-new-logo {
        background: #fff3cd; color: #856404; border: 2px solid #ffc107; font-weight: 700; font-size: 0.82rem;
        padding: 8px 16px; border-radius: 8px; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px; transition: all 0.18s;
      }
      .btn-new-logo:hover { background: #ffc107; color: #212529; }
    </style>
  </head>
  <body>

    {{-- HEADER --}}
    <div class="page-header">
      <div class="logo-area">
        <div class="header-icon"><i class="fa-solid fa-photo-film"></i></div>
        <div>
          <h1>Galería Multimedia</h1>
          <p>Administra tus banners, imágenes y videos de todo el sitio web.</p>
        </div>
      </div>
      <div class="header-actions">
        <a class="btn-back" href="{{ route('admin.dashboard') }}">
          <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <a class="btn-upload-img" href="{{ route('imagenes.create') }}">
          <i class="fa-solid fa-image"></i> + Subir Imagen
        </a>
        <a class="btn-upload-vid" href="{{ route('videos.create') }}">
          <i class="fa-solid fa-video"></i> + Subir Video
        </a>
      </div>
    </div>

    <div class="main-wrap">

      {{-- SECCIONES --}}
      <div class="section-label">Secciones</div>

      @php
        $imagenesBanner   = $imagenes->filter(fn($i) => in_array($i->seccion, ['banner','banner_principal','index_video_bajo']));
        $imagenesNosotros = $imagenes->filter(fn($i) => in_array($i->seccion, ['nosotros_banner','nosotros','nosotros_video']));
        $imagenesLogo     = $imagenes->filter(fn($i) => $i->seccion === 'logo');
        $logoActual       = $imagenesLogo->first();
        $brandTextActual  = $imagenes->firstWhere('seccion', 'brand_text');
      @endphp

      {{-- Fila 1: Banner + Nosotros --}}
      <div class="section-cards-main">

        {{-- Página Principal --}}
        <div class="sec-card active" id="secBanner" onclick="filterSection('banner')">
          <div class="sec-card-top">
            <div class="sec-card-meta">
              <div class="sec-icon"><i class="fa-solid fa-globe"></i></div>
              <div class="sec-card-info">
                <h3>Página Principal</h3>
                <p>Banners, imágenes y videos de la página principal.</p>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
              <span class="count-badge">{{ $imagenesBanner->count() }} elementos</span>
              <span class="sec-arrow"><i class="fa-solid fa-chevron-right"></i></span>
            </div>
          </div>
          @if($imagenesBanner->isNotEmpty())
          <div class="thumb-strip">
            @foreach($imagenesBanner->take(5) as $img)
              @php $ext = strtolower(pathinfo($img->imagen_url, PATHINFO_EXTENSION)); $isVid = in_array($ext, ['mp4','webm','mov','avi','ogg']); @endphp
              <div class="thumb-item">
                @if($isVid)
                  <video src="{{ asset($img->imagen_url) }}" muted></video>
                  <div class="thumb-play-icon"><i class="fa-solid fa-play"></i></div>
                @else
                  <img src="{{ asset($img->imagen_url) }}" alt="">
                @endif
              </div>
            @endforeach
          </div>
          @endif
        </div>

        {{-- Nosotros --}}
        <div class="sec-card" id="secNosotros" onclick="filterSection('nosotros')">
          <div class="sec-card-top">
            <div class="sec-card-meta">
              <div class="sec-icon amber"><i class="fa-solid fa-users"></i></div>
              <div class="sec-card-info">
                <h3>Nosotros</h3>
                <p>Contenido multimedia de la sección Nosotros.</p>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
              <span class="count-badge">{{ $imagenesNosotros->count() }} elementos</span>
              <span class="sec-arrow"><i class="fa-solid fa-chevron-right"></i></span>
            </div>
          </div>
          @if($imagenesNosotros->isNotEmpty())
          <div class="thumb-strip">
            @foreach($imagenesNosotros->take(5) as $img)
              @php $ext = strtolower(pathinfo($img->imagen_url, PATHINFO_EXTENSION)); $isVid = in_array($ext, ['mp4','webm','mov','avi','ogg']); @endphp
              <div class="thumb-item">
                @if($isVid)
                  <video src="{{ asset($img->imagen_url) }}" muted></video>
                  <div class="thumb-play-icon"><i class="fa-solid fa-play"></i></div>
                @else
                  <img src="{{ asset($img->imagen_url) }}" alt="">
                @endif
              </div>
            @endforeach
          </div>
          @endif
        </div>

      </div>

      {{-- Fila 2: Logo (horizontal completo) --}}
      <div class="section-card-logo-row">
        <div class="sec-card-logo" id="secLogo" onclick="filterSection('logo')">

          {{-- Thumb del logo --}}
          <div class="logo-card-thumb">
            @if($logoActual)
              <img src="{{ asset($logoActual->imagen_url) }}" alt="Logo actual">
            @else
              <i class="fa-regular fa-image logo-card-no-img"></i>
            @endif
          </div>

          {{-- Info --}}
          <div class="sec-card-logo-info">
            <h3>Logo de la Empresa</h3>
            <p>
              @if($logoActual)
                Logo activo · actualizado {{ $logoActual->updated_at ? $logoActual->updated_at->format('d/m/Y') : '—' }}
              @else
                Sin logo configurado — haz clic para subir uno.
              @endif
            </p>
          </div>

          {{-- Derecha --}}
          <div class="sec-card-logo-right">
            <span class="count-badge gold">
              {{ $imagenesLogo->count() }} elemento{{ $imagenesLogo->count() != 1 ? 's' : '' }}
            </span>
            <span class="sec-arrow"><i class="fa-solid fa-chevron-right"></i></span>
          </div>

        </div>
      </div>

      {{-- Fila 3: Texto de Marca (horizontal completo) --}}
      <div class="section-card-logo-row">
        <div class="sec-card-logo" id="secBrandText" onclick="filterSection('brand_text')"
             style="border-color:#c084fc;">
          {{-- Thumb --}}
          <div class="logo-card-thumb" style="border-color:#e9d5ff;">
            @if($brandTextActual)
              <img src="{{ asset($brandTextActual->imagen_url) }}" alt="Texto de marca actual">
            @else
              <i class="fa-solid fa-text-height logo-card-no-img" style="font-size:1.6rem;color:#c084fc;"></i>
            @endif
          </div>

          {{-- Info --}}
          <div class="sec-card-logo-info">
            <h3 style="color:#7e22ce;">Texto de Marca</h3>
            <p>
              @if($brandTextActual)
                Imagen festiva activa · reemplaza el texto "ZARMEX" en el header
              @else
                Sin imagen festiva — se muestra el texto "ZARMEX" por defecto.
              @endif
            </p>
          </div>

          {{-- Derecha --}}
          <div class="sec-card-logo-right">
            @if($brandTextActual)
              <span class="count-badge" style="background:#f3e8ff;color:#7e22ce;">Activa</span>
            @else
              <span class="count-badge" style="background:#f3f4f6;color:#6b7280;">Por defecto</span>
            @endif
            <span class="sec-arrow"><i class="fa-solid fa-chevron-right"></i></span>
          </div>
        </div>
      </div>

      {{-- PANEL FESTIVIDADES --}}
      <div class="logo-section-panel" id="brandTextPanelSection" style="border-color:#c084fc;">

        {{-- Encabezado --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
          <h4 style="color:#7e22ce;margin:0;font-size:1rem;font-weight:700;display:flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Festividades del Header
          </h4>
          <a href="{{ route('festividades.create') }}" id="btnNuevaFest"
            style="background:#7e22ce;color:#fff;text-decoration:none;font-weight:700;font-size:0.82rem;
                   padding:8px 16px;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
            <i class="fa-solid fa-plus"></i> Nueva festividad
          </a>
        </div>

        {{-- Estado actual --}}
        @if($festividadActiva)
        <div style="background:#f3e8ff;border:1.5px solid #c084fc;border-radius:10px;padding:12px 16px;
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
          <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:1.4rem;font-weight:900;color:{{ $festividadActiva->color_texto }};">
              {{ $festividadActiva->texto_header }}
            </span>
            <div>
              <div style="font-size:0.85rem;font-weight:700;color:#7e22ce;">{{ $festividadActiva->nombre }} — activa ahora</div>
              <div style="font-size:0.75rem;color:#9333ea;">
                Efecto: {{ $festividadActiva->efecto }}
                @if($festividadActiva->decoraciones && count($festividadActiva->decoraciones))
                  · Decoraciones: {{ implode(', ', $festividadActiva->decoraciones) }}
                @endif
              </div>
            </div>
          </div>
          <form action="{{ route('festividades.desactivar') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit"
              style="background:#fff;color:#dc3545;border:1.5px solid #f5c6cb;font-weight:700;font-size:0.8rem;
                     padding:7px 14px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
              <i class="fa-solid fa-times"></i> Desactivar
            </button>
          </form>
        </div>
        @else
        <div style="background:#f9fafb;border:1.5px dashed #e5e7eb;border-radius:10px;padding:12px 16px;
                    font-size:0.82rem;color:#6c757d;margin-bottom:16px;">
          <i class="fa-solid fa-info-circle me-1"></i>
          No hay festividad activa. El header muestra <strong>ZARMEX</strong> en su estilo normal.
        </div>
        @endif

        {{-- Lista de festividades --}}
        @if($festividades->isEmpty())
          <div style="text-align:center;padding:32px 20px;color:#adb5bd;">
            <i class="fa-solid fa-wand-magic-sparkles" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
            <p style="font-size:0.85rem;margin:0;">No hay festividades creadas. ¡Crea la primera!</p>
          </div>
        @else
          <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($festividades as $f)
            <div style="background:#fff;border:1.5px solid {{ $f->activa ? '#a855f7' : '#e9ecef' }};
                        border-radius:10px;padding:14px 16px;display:flex;align-items:center;
                        justify-content:space-between;flex-wrap:wrap;gap:10px;
                        {{ $f->activa ? 'background:#faf5ff;' : '' }}">
              <div style="display:flex;align-items:center;gap:12px;">
                {{-- Preview del color --}}
                <div style="width:40px;height:40px;border-radius:8px;background:#1a2a2a;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  <span style="font-size:0.7rem;font-weight:900;color:{{ $f->color_texto }};letter-spacing:1px;">
                    {{ Str::limit($f->texto_header, 6) }}
                  </span>
                </div>
                <div>
                  <div style="font-size:0.88rem;font-weight:700;color:#1a1a2e;display:flex;align-items:center;gap:8px;">
                    {{ $f->nombre }}
                    @if($f->activa)
                      <span style="background:#7e22ce;color:#fff;font-size:0.65rem;font-weight:700;
                                   padding:2px 8px;border-radius:20px;">ACTIVA</span>
                    @endif
                  </div>
                  <div style="font-size:0.75rem;color:#6c757d;margin-top:2px;">
                    {{ $f->efecto !== 'none' ? ucfirst($f->efecto) : 'Sin efecto' }}
                    @if($f->decoraciones && count($f->decoraciones))
                      · {{ implode(', ', $f->decoraciones) }}
                    @endif
                    @if($f->fecha_inicio && $f->fecha_fin)
                      · {{ $f->fecha_inicio->format('d/m') }} al {{ $f->fecha_fin->format('d/m') }}
                    @endif
                  </div>
                </div>
              </div>
              <div style="display:flex;align-items:center;gap:8px;">
                @if(!$f->activa)
                <form action="{{ route('festividades.activar', $f) }}" method="POST" style="margin:0;">
                  @csrf
                  <button type="submit"
                    style="background:#7e22ce;color:#fff;border:none;font-weight:700;font-size:0.78rem;
                           padding:6px 12px;border-radius:7px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fa-solid fa-play"></i> Activar
                  </button>
                </form>
                @endif
                <a href="{{ route('festividades.edit', $f) }}"
                  style="width:30px;height:30px;border-radius:6px;border:1.5px solid #dee2e6;background:#fff;
                         color:#495057;font-size:0.75rem;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('festividades.destroy', $f) }}" method="POST" style="margin:0;"
                      onsubmit="return confirm('¿Eliminar esta festividad?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                    style="width:30px;height:30px;border-radius:6px;border:1.5px solid #f5c6cb;background:#fff;
                           color:#dc3545;font-size:0.75rem;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </form>
              </div>
            </div>
            @endforeach
          </div>
        @endif

      </div>

      {{-- PANEL ESPECIAL LOGO --}}
      <div class="logo-section-panel" id="logoPanelSection">
        <h4><i class="fa-solid fa-star"></i> Logo de la Empresa</h4>
        <div class="logo-current-wrap">
          <div class="logo-img-box">
            @if($logoActual)
              <img src="{{ asset($logoActual->imagen_url) }}" alt="Logo actual">
            @else
              <div class="logo-no-img">
                <i class="fa-regular fa-image" style="font-size:2rem;display:block;margin-bottom:6px;"></i>
                Sin logo configurado
              </div>
            @endif
          </div>
          <div class="logo-meta">
            @if($logoActual)
              <div class="lm-name">{{ $logoActual->nombre ?? basename($logoActual->imagen_url) }}</div>
              <div class="lm-date"><i class="fa-regular fa-calendar"></i> Subido el {{ $logoActual->created_at ? $logoActual->created_at->format('d/m/Y H:i') : '—' }}</div>
              <div class="logo-actions">
                <a href="{{ route('imagenes.edit', $logoActual->id) }}" class="btn-edit-logo">
                  <i class="fa-solid fa-pen"></i> Editar / Reemplazar
                </a>
                <form action="{{ route('imagenes.destroy', $logoActual->id) }}" method="POST" style="margin:0;">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-del-logo"
                    onclick="return confirm('¿Seguro que deseas eliminar el logo actual?')">
                    <i class="fa-solid fa-trash-can"></i> Eliminar
                  </button>
                </form>
              </div>
            @else
              <div class="lm-name" style="color:#6c757d;">No hay logo configurado todavía.</div>
              <div class="lm-date" style="margin-bottom:14px;">Sube un logo para que aparezca en el encabezado del sitio.</div>
              <div class="logo-actions">
                <a href="{{ route('imagenes.create') }}?seccion=logo" class="btn-new-logo">
                  <i class="fa-solid fa-upload"></i> Subir Logo
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- TABLA + PREVIEW --}}
      @if($imagenes->isEmpty())
        <div class="table-panel">
          <div class="empty-state">
            <i class="fa-regular fa-folder-open"></i>
            <p>No hay recursos multimedia subidos actualmente.</p>
          </div>
        </div>
      @else
      <div class="content-area" id="tableSection">

        {{-- TABLA --}}
        <div class="table-panel">
          <div class="table-panel-header">
            <div>
              <h4 id="tableSectionTitle">Página Principal</h4>
              <p id="tableSectionSub">Administra los banners, imágenes y videos de la página principal.</p>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
              <div class="filter-tabs">
                <button class="ftab active" onclick="filterType('todos', this)">Todos</button>
                <button class="ftab" onclick="filterType('imagenes', this)">Imágenes</button>
                <button class="ftab" onclick="filterType('videos', this)">Videos</button>
              </div>
              <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" id="searchInput" placeholder="Buscar archivo..." oninput="searchFiles()">
              </div>
            </div>
          </div>

          <table class="media-table" id="mediaTable">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Nombre del archivo</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              @foreach ($imagenes as $imagen)
                @php
                  $extension   = strtolower(pathinfo($imagen->imagen_url, PATHINFO_EXTENSION));
                  $esVideo     = in_array($extension, ['mp4','webm','mov','avi','ogg']);
                  $nombre      = $imagen->nombre ?? basename($imagen->imagen_url);

                  if (in_array($imagen->seccion, ['banner','banner_principal','index_video_bajo'])) {
                    $seccionGrupo = 'banner';
                  } elseif ($imagen->seccion === 'logo') {
                    $seccionGrupo = 'logo';
                  } elseif ($imagen->seccion === 'brand_text') {
                    $seccionGrupo = 'brand_text';
                  } else {
                    $seccionGrupo = 'nosotros';
                  }

                  $secPillClass = match($imagen->seccion) {
                    'banner','banner_principal','index_video_bajo' => 'sec-pill-banner',
                    'nosotros_banner','nosotros','nosotros_video'  => 'sec-pill-nosotros',
                    'logo'       => 'sec-pill-logo',
                    'brand_text' => 'sec-pill-brand',
                    default      => 'sec-pill-default'
                  };

                  $secLabel = match($imagen->seccion) {
                    'banner','banner_principal' => 'Banner Inicio',
                    'index_video_bajo'  => 'Inicio (Sección Baja)',
                    'nosotros_banner'   => 'Nosotros Banner',
                    'nosotros_video'    => 'Nosotros (Sección Baja)',
                    'nosotros'          => 'Nosotros',
                    'logo'              => 'Logo',
                    'brand_text'        => 'Texto de Marca',
                    default             => ucfirst($imagen->seccion)
                  };
                @endphp
                <tr
                  class="media-row"
                  data-seccion="{{ $seccionGrupo }}"
                  data-type="{{ $esVideo ? 'videos' : 'imagenes' }}"
                  data-nombre="{{ strtolower($nombre) }}"
                  data-url="{{ asset($imagen->imagen_url) }}"
                  data-media-type="{{ $esVideo ? 'video' : 'image' }}"
                  data-ext="{{ strtoupper($extension) }}"
                  data-fecha="{{ $imagen->created_at ? $imagen->created_at->format('d/m/Y H:i') : '—' }}"
                  onclick="selectRow(this)"
                >
                  <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                      <div class="row-thumb-wrap">
                        @if($esVideo)
                          <video src="{{ asset($imagen->imagen_url) }}" class="row-thumb" muted></video>
                          <div class="vid-icon"><i class="fa-solid fa-play" style="font-size:0.65rem;"></i></div>
                        @else
                          <img src="{{ asset($imagen->imagen_url) }}" class="row-thumb" alt="">
                        @endif
                      </div>
                      <i class="fa-solid {{ $esVideo ? 'fa-video type-icon-vid' : 'fa-image type-icon-img' }}"></i>
                    </div>
                  </td>
                  <td>
                    <div class="row-name">{{ $nombre }}</div>
                    <div class="row-sub">
                      <span class="sec-pill {{ $secPillClass }}">{{ $secLabel }}</span>
                    </div>
                    
                    {{-- NUEVO: Etiqueta del link de redirección si existe --}}
                    @if(!empty($imagen->link_url))
                      <div style="margin-top: 5px;">
                        <a href="{{ $imagen->link_url }}" target="_blank" onclick="event.stopPropagation()"
                           style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.72rem; font-weight: 600; color: #28666e; background: #e8f4f5; padding: 2px 8px; border-radius: 12px; text-decoration: none; border: 1px solid #cce7ea; transition: all 0.2s;">
                          <i class="fa-solid fa-link"></i> {{ Str::limit($imagen->link_url, 35) }}
                        </a>
                      </div>
                    @endif
                  </td>
                  <td style="font-size:0.8rem;color:#6c757d;white-space:nowrap;">
                    {{ $imagen->created_at ? $imagen->created_at->format('d/m/Y') : '—' }}<br>
                    <span style="font-size:0.72rem;">{{ $imagen->created_at ? $imagen->created_at->format('H:i') : '' }}</span>
                  </td>
                  <td>
                    <div style="display:flex;gap:6px;" onclick="event.stopPropagation()">
                      <a href="{{ route('imagenes.edit', $imagen->id) }}" class="btn-action" title="Editar">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                      <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="post" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action danger" title="Eliminar"
                          onclick="return confirm('¿Seguro que deseas eliminar de forma permanente este recurso?')">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- VISTA PREVIA --}}
        <div class="preview-panel">
          <div class="preview-placeholder" id="previewPlaceholder">
            <i class="fa-regular fa-image"></i>
            <span>Selecciona un archivo para ver la vista previa</span>
          </div>
          <div class="preview-media-wrap" id="previewMediaWrap"></div>
          <div class="preview-info" id="previewInfo">
            <div class="preview-empty-info" id="previewEmptyInfo">
              Haz clic en cualquier fila para ver los detalles aquí.
            </div>
            <div id="previewDetails" style="display:none;">
              <div class="preview-filename" id="previewFilename">—</div>
              <div class="preview-meta">
                <span><i class="fa-regular fa-calendar"></i> <span id="previewFecha">—</span></span>
                <span><i class="fa-solid fa-file"></i> <span id="previewExt">—</span></span>
              </div>
            </div>
          </div>
        </div>

      </div>
      @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script>
      let currentSection = 'banner';
      let currentType    = 'todos';
      let currentSearch  = '';
      let selectedRow    = null;

      const sectionTitles = {
        banner:     { title: 'Página Principal', sub: 'Administra los banners, imágenes y videos de la página principal.' },
        nosotros:   { title: 'Nosotros',         sub: 'Administra el contenido multimedia de la sección Nosotros.' },
        logo:       { title: 'Logo de la Empresa', sub: 'Administra el logotipo que se muestra en el encabezado del sitio.' },
        brand_text: { title: 'Texto de Marca',   sub: 'Imagen festiva que reemplaza el texto ZARMEX en el header.' }
      };

      function filterSection(sec) {
        currentSection = sec;

        // Cards activas
        document.getElementById('secBanner').classList.remove('active');
        document.getElementById('secNosotros').classList.remove('active');
        document.getElementById('secLogo').classList.remove('active-logo');
        if (document.getElementById('secBrandText'))
          document.getElementById('secBrandText').style.borderColor = '#c084fc';

        if (sec === 'logo') {
          document.getElementById('secLogo').classList.add('active-logo');
        } else if (sec === 'brand_text') {
          if (document.getElementById('secBrandText'))
            document.getElementById('secBrandText').style.borderColor = '#7e22ce';
        } else if (sec === 'banner') {
          document.getElementById('secBanner').classList.add('active');
        } else {
          document.getElementById('secNosotros').classList.add('active');
        }

        // Paneles especiales
        const logoPanel      = document.getElementById('logoPanelSection');
        const brandTextPanel = document.getElementById('brandTextPanelSection');
        const tableBlock     = document.getElementById('tableSection');

        logoPanel.classList.remove('visible');
        if (brandTextPanel) brandTextPanel.classList.remove('visible');
        if (tableBlock) tableBlock.style.display = '';

        if (sec === 'logo') {
          logoPanel.classList.add('visible');
          if (tableBlock) tableBlock.style.display = 'none';
        } else if (sec === 'brand_text') {
          if (brandTextPanel) brandTextPanel.classList.add('visible');
          if (tableBlock) tableBlock.style.display = 'none';
        }

        const info = sectionTitles[sec] || sectionTitles['banner'];
        if (document.getElementById('tableSectionTitle'))
          document.getElementById('tableSectionTitle').textContent = info.title;
        if (document.getElementById('tableSectionSub'))
          document.getElementById('tableSectionSub').textContent   = info.sub;

        applyFilters();
        clearPreview();
      }

      function filterType(type, btn) {
        currentType = type;
        document.querySelectorAll('.ftab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
      }

      function searchFiles() {
        currentSearch = document.getElementById('searchInput').value.toLowerCase();
        applyFilters();
      }

      function applyFilters() {
        document.querySelectorAll('.media-row').forEach(row => {
          const matchSec    = row.dataset.seccion === currentSection;
          const matchType   = currentType === 'todos' || row.dataset.type === currentType;
          const matchSearch = row.dataset.nombre.includes(currentSearch);
          row.style.display = (matchSec && matchType && matchSearch) ? '' : 'none';
        });
      }

      function selectRow(row) {
        if (selectedRow) selectedRow.classList.remove('selected');
        selectedRow = row;
        row.classList.add('selected');

        const url    = row.dataset.url;
        const type   = row.dataset.mediaType;
        const nombre = row.dataset.nombre;
        const ext    = row.dataset.ext;
        const fecha  = row.dataset.fecha;

        document.getElementById('previewPlaceholder').style.display = 'none';
        const wrap = document.getElementById('previewMediaWrap');
        wrap.style.display = 'block';
        wrap.innerHTML = type === 'video'
          ? `<video src="${url}" controls autoplay muted loop playsinline style="width:100%;height:100%;object-fit:contain;display:block;"></video>`
          : `<img src="${url}" alt="" style="width:100%;height:100%;object-fit:contain;display:block;">`;

        document.getElementById('previewEmptyInfo').style.display = 'none';
        document.getElementById('previewDetails').style.display   = 'block';
        document.getElementById('previewFilename').textContent = nombre;
        document.getElementById('previewFecha').textContent   = fecha;
        document.getElementById('previewExt').textContent     = ext;
      }

      function clearPreview() {
        if (selectedRow) { selectedRow.classList.remove('selected'); selectedRow = null; }
        document.getElementById('previewPlaceholder').style.display  = 'flex';
        document.getElementById('previewMediaWrap').style.display    = 'none';
        document.getElementById('previewMediaWrap').innerHTML        = '';
        if (document.getElementById('previewEmptyInfo'))
          document.getElementById('previewEmptyInfo').style.display  = 'block';
        if (document.getElementById('previewDetails'))
          document.getElementById('previewDetails').style.display    = 'none';
      }

      applyFilters();

    </script>
  </body>
  </html>
  @endauth
</x-app-layout>