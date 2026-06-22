<x-app-layout>
  @auth('employee')
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Subir Video para Banner</title>
    <style>
      body { background-color: #236862; }
      .form-card { border: none; border-radius: 12px; max-width: 600px; margin: 0 auto; }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      
      <div class="text-center mb-4">
        <h1 class="fw-bold text-dark">Subir Video para Banner</h1>
        <p class="text-muted">Selecciona el archivo de video y la sección correspondiente de la web</p>
      </div>

      <!-- Alertas de error si la validación falla -->
      @if ($errors->any())
        <div class="alert alert-danger max-width-600 mx-auto rounded-3">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Tarjeta del Formulario -->
      <div class="card form-card shadow-sm p-4 bg-white mb-5">
        <!-- Es vital el 'enctype="multipart/form-data"' para que PHP acepte archivos -->
        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Selección de Sección -->
          <div class="mb-3">
            <label for="seccion" class="form-label fw-semibold text-secondary">Sección del Banner</label>
            <select class="form-select" id="seccion" name="seccion" required>
              <option value="" selected disabled>Selecciona una sección...</option>
              <option value="banner_principal">Banner Principal (Inicio)</option>
              <option value="banner_nosotros">Banner Nosotros</option>
              <option value="nosotros_video">Video Inferior</option>
    
              <!-- Agrega aquí las secciones que uses en tu base de datos -->
            </select>
          </div>

          <!-- Input de Archivo -->
          <div class="mb-4">
            <label for="video" class="form-label fw-semibold text-secondary">Archivo de Video</label>
            <input class="form-control" type="file" id="video" name="video" accept="video/*" required>
            <div class="form-text">Formatos sugeridos: MP4, WebM. Tamaño máximo recomendado: 50MB.</div>
          </div>

          <!-- Botones de Acción -->
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('imagenes.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
            <button type="submit" class="btn btn-primary px-4">Subir Video</button>
          </div>
        </form>
      </div>

    </div>
  </body>
  </html>
  @endauth
</x-app-layout>