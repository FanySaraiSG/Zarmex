<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subir Recurso Multimedia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; }

    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', Arial, sans-serif;
      min-height: 100vh;
    }

    /* ── TOPBAR ── */
    .topbar {
      background: #fff;
      border-bottom: 1px solid #e9ecef;
      padding: 0 32px;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .topbar-inner {
      width: 100%;
      max-width: 640px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .topbar-title {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.05rem;
      font-weight: 800;
      color: #1a1a2e;
      letter-spacing: -0.2px;
    }
    .topbar-title .t-icon {
      width: 36px; height: 36px;
      background: #e8f4f5;
      border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      color: #28666e;
      font-size: 1rem;
    }
    .btn-cancel {
      display: inline-flex; align-items: center; gap: 6px;
      background: transparent;
      border: 1.5px solid #dee2e6;
      color: #495057;
      font-weight: 600;
      font-size: 0.83rem;
      padding: 7px 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.18s;
    }
    .btn-cancel:hover { background: #f1f3f5; border-color: #adb5bd; color: #343a40; }

    /* ── CARD ── */
    .page-wrap {
      max-width: 640px;
      margin: 36px auto 60px;
      padding: 0 16px;
    }

    .form-card {
      background: #fff;
      border-radius: 18px;
      border: 1px solid rgba(0,0,0,.07);
      box-shadow: 0 8px 32px rgba(0,0,0,.07);
      overflow: hidden;
    }

    .form-card-header {
      padding: 28px 32px 22px;
      border-bottom: 1px solid #f1f3f5;
      text-align: center;
    }
    .form-card-header .fch-icon {
      width: 52px; height: 52px;
      background: linear-gradient(135deg, #e8f4f5 0%, #d0eaec 100%);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      color: #28666e;
      font-size: 1.4rem;
      margin: 0 auto 14px;
    }
    .form-card-header h2 {
      font-size: 1.25rem;
      font-weight: 800;
      color: #1a1a2e;
      margin: 0 0 4px;
    }
    .form-card-header p {
      font-size: 0.83rem;
      color: #6c757d;
      margin: 0;
    }

    .form-body { padding: 28px 32px 32px; }

    /* Alerts */
    .alert-success-z {
      background: #d1fae5; color: #065f46;
      border: 1px solid #a7f3d0;
      border-radius: 10px; padding: 12px 16px;
      font-size: 0.85rem; font-weight: 600;
      margin-bottom: 20px;
      display: flex; align-items: center; gap: 8px;
    }
    .alert-error-z {
      background: #fee2e2; color: #991b1b;
      border: 1px solid #fecaca;
      border-radius: 10px; padding: 12px 16px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }
    .alert-error-z ul { margin: 0; padding-left: 18px; }

    /* Fields */
    .field-group { margin-bottom: 20px; }
    .field-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      color: #374151;
      margin-bottom: 7px;
      letter-spacing: 0.2px;
    }
    .field-label span.req { color: #ef4444; margin-left: 2px; }

    .zfield {
      width: 100%;
      padding: 10px 14px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: 0.9rem;
      color: #1a1a2e;
      background: #fafafa;
      transition: border-color 0.18s, box-shadow 0.18s;
      outline: none;
    }
    .zfield:focus {
      border-color: #28666e;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(40,102,110,0.10);
    }
    .field-hint {
      font-size: 0.75rem;
      color: #9ca3af;
      margin-top: 5px;
    }

    /* Campo de enlace destacado */
    .link-field-wrap {
      background: #f0f9fa;
      border: 1px solid #b2d8dc;
      border-radius: 12px;
      padding: 16px 18px;
    }
    .link-field-wrap .field-label { color: #28666e; }
    .link-field-wrap .zfield:focus {
      border-color: #28666e;
      box-shadow: 0 0 0 3px rgba(40,102,110,0.15);
    }

    /* Seccion select pills custom */
    .sec-select-wrap { position: relative; }
    .sec-select-wrap::after {
      content: '\f078';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      right: 14px; top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      pointer-events: none;
      font-size: 0.75rem;
    }
    .zfield.zselect { appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer; }

    /* Upload zone */
    .upload-zone {
      border: 2px dashed #d1d5db;
      border-radius: 12px;
      background: #fafafa;
      padding: 28px 20px;
      text-align: center;
      cursor: pointer;
      transition: border-color 0.2s, background 0.2s;
      position: relative;
    }
    .upload-zone:hover, .upload-zone.dragover {
      border-color: #28666e;
      background: #f0f9fa;
    }
    .upload-zone input[type="file"] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .uz-icon { font-size: 2rem; color: #28666e; margin-bottom: 8px; }
    .uz-label { font-size: 0.88rem; font-weight: 700; color: #374151; margin-bottom: 4px; }
    .uz-sub { font-size: 0.75rem; color: #9ca3af; }

    /* Preview */
    .preview-box {
      margin-top: 14px;
      border-radius: 12px;
      overflow: hidden;
      background: #f1f3f5;
      display: none;
      position: relative;
    }
    .preview-box img {
      width: 100%; max-height: 200px; object-fit: cover; display: block;
    }
    .preview-box .prev-overlay {
      position: absolute; bottom: 0; left: 0; right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.5));
      padding: 10px 14px;
      font-size: 0.75rem; color: #fff; font-weight: 600;
    }

    /* Submit */
    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, #28666e 0%, #1d4e54 100%);
      color: #fff;
      border: none;
      padding: 13px 20px;
      font-size: 0.95rem;
      font-weight: 800;
      border-radius: 12px;
      cursor: pointer;
      margin-top: 8px;
      transition: opacity 0.18s, transform 0.15s;
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-submit:hover { opacity: 0.92; transform: translateY(-1px); }
    .btn-submit:active { transform: translateY(0); }

    /* Divider */
    .form-divider {
      border: none;
      border-top: 1px solid #f1f3f5;
      margin: 24px 0;
    }
  </style>
</head>
<body>

  {{-- TOPBAR --}}
  <div class="topbar">
    <div class="topbar-inner">
      <div class="topbar-title">
        <div class="t-icon"><i class="fa-solid fa-upload"></i></div>
        Subir Recurso Multimedia
      </div>
      <a href="{{ route('imagenes.index') }}" class="btn-cancel">
        <i class="fa-solid fa-xmark"></i> Cancelar
      </a>
    </div>
  </div>

  <div class="page-wrap">
    <div class="form-card">

      {{-- HEADER CARD --}}
      <div class="form-card-header">
        <div class="fch-icon"><i class="fa-solid fa-photo-film"></i></div>
        <h2>Subir Recurso</h2>
        <p>Selecciona la sección y sube la imagen o video que quieres publicar.</p>
      </div>

      <div class="form-body">

        {{-- Mensajes --}}
        @if(session('success'))
          <div class="alert-success-z">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert-error-z">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
          </div>
        @endif
        @if($errors->any())
          <div class="alert-error-z">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- SECCIÓN --}}
          <div class="field-group">
            <label class="field-label" for="seccion">
              Sección de destino <span class="req">*</span>
            </label>
            <div class="sec-select-wrap">
              <select name="seccion" id="seccion" class="zfield zselect" required>
                <option value="" disabled {{ old('seccion') ? '' : 'selected' }}>— Selecciona una sección —</option>
                <option value="banner"          {{ old('seccion')==='banner'          ? 'selected' : '' }}>Banner Principal (Inicio)</option>
                <option value="nosotros_banner" {{ old('seccion')==='nosotros_banner' ? 'selected' : '' }}>Carrusel Nosotros (Superior)</option>
                <option value="nosotros_video"  {{ old('seccion')==='nosotros_video'  ? 'selected' : '' }}>Video Inferior (Nosotros)</option>
                <option value="logo"            {{ old('seccion')==='logo'            ? 'selected' : '' }}>Logo de la Empresa</option>
                <option value="brand_text"      {{ old('seccion')==='brand_text'      ? 'selected' : '' }}>Texto de Marca Festivo</option>
              </select>
            </div>
          </div>

          {{-- NOMBRE --}}
          <div class="field-group">
            <label class="field-label" for="nombre">
              Nombre del recurso <span class="req">*</span>
            </label>
            <input
              id="nombre"
              type="text"
              name="nombre"
              class="zfield"
              placeholder="Ej: Banner principal verano 2025"
              value="{{ old('nombre') }}"
              required
            >
            <div class="field-hint">Se autocompletará con el nombre del archivo al seleccionarlo.</div>
          </div>

          <hr class="form-divider">

          {{-- ARCHIVO --}}
          <div class="field-group">
            <label class="field-label">Archivo <span class="req">*</span></label>
            <div class="upload-zone" id="uploadZone">
              <input type="file" id="imagen" name="imagen" accept="image/*,video/mp4,video/webm,video/mov,video/avi" required>
              <div class="uz-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
              <div class="uz-label" id="uzLabel">Arrastra aquí o haz clic para seleccionar</div>
              <div class="uz-sub" id="uzSub">Imágenes: JPG, PNG, WEBP, GIF (máx. 5 MB) · Videos: MP4, WEBM, MOV (máx. 60 MB)</div>
            </div>
            {{-- Preview imagen --}}
            <div class="preview-box" id="previewBox">
              <img id="previewImg" src="" alt="Vista previa" style="display:none;">
              <video id="previewVid" controls style="width:100%;max-height:200px;display:none;"></video>
              <div class="prev-overlay" id="previewName"></div>
            </div>
          </div>

          <hr class="form-divider">

          {{-- ✅ URL DE REDIRECCIÓN --}}
          <div class="field-group link-field-wrap">
            <label class="field-label" for="link_url">
              <i class="fa-solid fa-link me-1"></i> URL de redirección
              <span style="font-weight:400; color:#6b7280; text-transform:none; letter-spacing:0;">(opcional)</span>
            </label>
            <input
              type="url"
              name="link_url"
              id="link_url"
              class="zfield @error('link_url') is-invalid @enderror"
              placeholder="https://ejemplo.com/pagina"
              value="{{ old('link_url') }}"
            >
            @error('link_url')
              <div class="text-danger" style="font-size:0.78rem; margin-top:5px;">{{ $message }}</div>
            @enderror
            <div class="field-hint">Si se asigna una URL, esta imagen será clickeable en el carrusel del sitio.</div>
          </div>

          <button type="submit" class="btn-submit">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            Subir imagen
          </button>

        </form>
      </div>
    </div>
  </div>

  <script>
    const inputFile   = document.getElementById('imagen');
    const inputNombre = document.getElementById('nombre');
    const uploadZone  = document.getElementById('uploadZone');
    const previewBox  = document.getElementById('previewBox');
    const previewImg  = document.getElementById('previewImg');
    const previewVid  = document.getElementById('previewVid');
    const previewName = document.getElementById('previewName');
    const uzSub       = document.getElementById('uzSub');
    const seccionSel  = document.getElementById('seccion');

    // Actualizar texto del upload-zone según sección seleccionada
    seccionSel.addEventListener('change', () => {
      const isVideoSec = seccionSel.value === 'nosotros_video';
      uzSub.textContent = isVideoSec
        ? 'Videos: MP4, WEBM, MOV (máx. 60 MB) · También puedes subir imágenes.'
        : 'Imágenes: JPG, PNG, WEBP, GIF (máx. 5 MB) · Videos: MP4, WEBM, MOV (máx. 60 MB)';
    });

    inputFile.addEventListener('change', handleFile);

    ['dragover', 'dragenter'].forEach(e => uploadZone.addEventListener(e, ev => {
      ev.preventDefault();
      uploadZone.classList.add('dragover');
    }));
    ['dragleave'].forEach(e => uploadZone.addEventListener(e, ev => {
      uploadZone.classList.remove('dragover');
    }));
    uploadZone.addEventListener('drop', ev => {
      ev.preventDefault();
      uploadZone.classList.remove('dragover');
      const droppedFiles = ev.dataTransfer.files;
      if (droppedFiles && droppedFiles.length > 0) {
        inputFile.files = droppedFiles;
        handleFile({ target: inputFile });
      }
    });

    function handleFile(e) {
      const file = e.target.files && e.target.files[0];
      if (!file) return;

      const nameWithoutExt = file.name.replace(/\.[^/.]+$/, '');
      if (!inputNombre.value.trim()) {
        inputNombre.value = nameWithoutExt;
      }

      const url = URL.createObjectURL(file);
      previewBox.style.display = 'block';
      previewName.textContent  = file.name;

      if (file.type.startsWith('video/')) {
        previewImg.style.display = 'none';
        previewVid.src           = url;
        previewVid.style.display = 'block';
      } else {
        previewVid.style.display = 'none';
        previewImg.src           = url;
        previewImg.style.display = 'block';
      }
    }

    // Pre-seleccionar sección si viene en query param
    const urlParams = new URLSearchParams(window.location.search);
    const secParam  = urlParams.get('seccion');
    if (secParam) {
      const sel = document.getElementById('seccion');
      if (sel) { sel.value = secParam; sel.dispatchEvent(new Event('change')); }
    }
  </script>
</body>
</html>
@else
  <div class="container mt-5">
    <div class="alert alert-danger text-center">
      <h4>Acceso denegado</h4>
      <p>No tienes permisos para ver esta página.</p>
      <a href="{{ route('dashboard') }}" class="btn btn-primary">Regresar</a>
    </div>
  </div>
@endauth
</x-app-layout>