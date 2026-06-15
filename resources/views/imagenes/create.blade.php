<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Añadir Imagen</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background: #f6f7fb; }
    .wrap { max-width: 860px; margin: 40px auto; padding: 0 14px; }
    .cardbox {
      background: #fff;
      border-radius: 18px;
      border: 1px solid rgba(0,0,0,.08);
      box-shadow: 0 18px 45px rgba(0,0,0,.08);
      padding: 28px;
    }
    .title {
      text-align: center;
      font-weight: 900;
      letter-spacing: 2px;
      color: #234d50;
      margin-bottom: 10px;
      text-transform: uppercase;
    }
    .sub { text-align: center; color: #6b7280; margin-bottom: 22px; }
    .btn-zx { background: #234d50; border: 0; color: #fff; font-weight: 800; border-radius: 12px; padding: 12px 16px; }
    .btn-zx:hover { background: #1d3f42; color: #fff; }
    .btn-soft {
      background: rgba(35,77,80,.10);
      color: #234d50;
      border: 1px solid rgba(35,77,80,.18);
      font-weight: 800;
      border-radius: 12px;
      padding: 10px 14px;
      text-decoration: none;
      display: inline-block;
    }
    .btn-soft:hover { background: rgba(35,77,80,.14); color: #234d50; }
    .hint { font-size: 12px; color: #6b7280; margin-top: 6px; }
    .preview {
      margin-top: 10px;
      border-radius: 14px;
      border: 1px solid rgba(0,0,0,.10);
      width: 100%;
      max-height: 260px;
      object-fit: cover;
      display: none;
    }

    /* Campo de enlace */
    .link-field-wrap {
      background: #f0f9fa;
      border: 1px solid #b2d8dc;
      border-radius: 12px;
      padding: 14px 16px;
    }
    .link-field-wrap label { color: #28666e; font-weight: 700; }
    .link-field-wrap .form-control:focus { border-color: #28666e; box-shadow: 0 0 0 0.2rem rgba(40,102,110,.2); }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="cardbox">
      <h1 class="title">AÑADIR IMAGEN</h1>
      <p class="sub">Selecciona la sección y sube la imagen.</p>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('imagenes.index') }}" class="btn-soft">Regresar</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NOMBRE --}}
        <div class="mb-3">
          <label class="form-label fw-bold">Nombre:</label>
          <input
            id="nombre"
            type="text"
            name="nombre"
            class="form-control"
            placeholder="Ej: Banner principal 1"
            value="{{ old('nombre') }}"
            required
          >
          <div class="hint">Tip: se autollenará con el nombre del archivo (puedes editarlo).</div>
        </div>

        {{-- SECCIÓN --}}
        <div class="mb-3">
          <label class="form-label fw-bold">Sección de la Imagen:</label>
          <select name="seccion" class="form-select" required>
            <option value="banner"          {{ old('seccion')==='banner'          ? 'selected' : '' }}>Banner</option>
            <option value="nosotros_banner" {{ old('seccion')==='nosotros_banner' ? 'selected' : '' }}>Nosotros Banner</option>
          </select>
        </div>

        {{-- IMAGEN --}}
        <div class="mb-3">
          <label class="form-label fw-bold">Subir Imagen:</label>
          <input id="imagen" type="file" name="imagen" class="form-control" accept="image/*" required>
          <div class="hint">Formatos: JPG, PNG, WEBP, GIF.</div>
          <img id="preview" class="preview" alt="Vista previa">
        </div>

        {{-- ✅ ENLACE DE REDIRECCIÓN --}}
        <div class="mb-4 link-field-wrap">
          <label for="link_url" class="form-label">
            <i class="fa-solid fa-link me-1"></i> URL de redirección
            <span class="text-muted fw-normal">(opcional)</span>
          </label>
          <input
            type="url"
            name="link_url"
            id="link_url"
            class="form-control @error('link_url') is-invalid @enderror"
            placeholder="https://ejemplo.com/pagina"
            value="{{ old('link_url') }}"
          >
          @error('link_url')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="hint">Si se asigna una URL, esta imagen será clickeable en el carrusel del sitio.</div>
        </div>

        <button type="submit" class="btn btn-zx w-100">
          Subir Imagen
        </button>
      </form>
    </div>
  </div>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    const inputFile   = document.getElementById('imagen');
    const inputNombre = document.getElementById('nombre');
    const preview     = document.getElementById('preview');

    inputFile.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) return;

      if (!inputNombre.value.trim()) {
        inputNombre.value = file.name.replace(/\.[^/.]+$/, "");
      }

      const url = URL.createObjectURL(file);
      preview.src = url;
      preview.style.display = 'block';
    });
  </script>
</body>
</html>

@else
  <div class="container mt-5">
    <div class="alert alert-danger text-center">
      <h4>Access Denied</h4>
      <p>No tienes permisos para ver esta página.</p>
      <a href="{{ route('dashboard') }}" class="btn btn-primary">Regresar</a>
    </div>
  </div>
@endauth
</x-app-layout>