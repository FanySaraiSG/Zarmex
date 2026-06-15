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
    
    <title>Multimedia de Banner</title>
    <style>
      body { background-color: #f4f6f9; }
      nav { background-color: inherit !important; }
      
      /* 🎨 COLORES PERSONALIZADOS Y ESTILO DE BOTONES SUPERIORES */
      .btn-custom-back { color: #5a626a; border: 2px solid #ced4da; font-weight: 600; transition: all 0.2s ease; }
      .btn-custom-back:hover { background-color: #e9ecef; color: #343a40; border-color: #adb5bd; }

      .btn-custom-image { background-color: #28666e; color: #fedc97; border: none; font-weight: 700; transition: all 0.2s ease; }
      .btn-custom-image:hover { background-color: #1a4a50; color: #ffffff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(40,102,110,0.25); }

      .btn-custom-video { background-color: #fedc97; color: #28666e; border: 2px solid #28666e; font-weight: 700; transition: all 0.2s ease; }
      .btn-custom-video:hover { background-color: #28666e; color: #fedc97; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(254,220,151,0.35); }

      /* Estilos Modernos de Tarjetas */
      .media-card {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
      }
      
      .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
      }

      /* Contenedor de la multimedia */
      .media-wrapper {
        position: relative;
        width: 100%;
        height: 200px;
        background-color: #eaeaea;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        cursor: pointer; /* Indica que se puede hacer clic */
      }

      /* Capa oscura decorativa al pasar el mouse por encima del recurso */
      .media-wrapper::after {
        content: '\f06e \a\a Previsualizar';
        font-family: "Font Awesome 5 Free", "Font Awesome 6 Free";
        font-weight: 900;
        white-space: pre-wrap;
        text-align: center;
        position: absolute;
        inset: 0;
        background: rgba(40, 102, 110, 0.75);
        color: #fedc97;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
        font-size: 1.1rem;
      }
      .media-wrapper:hover::after { opacity: 1; }

      .media-element { width: 100%; height: 100%; object-fit: cover; }

      /* Badges flotantes */
      .section-badge { position: absolute; top: 12px; left: 12px; z-index: 5; font-weight: 600; padding: 6px 12px; border-radius: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); }
      .type-badge { position: absolute; top: 12px; right: 12px; z-index: 5; font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px); background: rgba(0, 0, 0, 0.6); color: #fff; }

      .card-body-custom { padding: 16px; display: flex; flex-direction: column; flex-grow: 1; }
      .path-text { font-size: 0.82rem; color: #6c757d; word-break: break-all; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 14px; height: 38px; }
      
      /* Estilos del Modal de Previsualización */
      .modal-content-custom { border: none; border-radius: 20px; overflow: hidden; background-color: #fff; }
      .preview-modal-media { width: 100%; max-height: 500px; object-fit: contain; background: #1a1a1a; display: block; }

      /* Badge de URL de redirección */
      .link-url-badge {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.78rem;
        background-color: #e8f4f5;
        color: #28666e;
        border: 1px solid #b2d8dc;
        border-radius: 8px;
        padding: 5px 10px;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 12px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        transition: background-color 0.2s;
      }
      .link-url-badge:hover { background-color: #28666e; color: #fedc97; }
      .link-url-badge span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
      .no-link-badge {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.78rem;
        background-color: #f8f9fa;
        color: #adb5bd;
        border: 1px dashed #dee2e6;
        border-radius: 8px;
        padding: 5px 10px;
        margin-bottom: 12px;
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      
      <div class="text-center mb-5">
        <h1 class="fw-bold text-dark"><i class="fa-solid fa-photo-film me-2" style="color: #28666e;"></i>Galería Multimedia</h1>
        <p class="text-muted">Administra tus banners. Haz clic sobre cualquier recurso para ver cómo luce en pantalla completa.</p>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm">
        <a class="btn btn-custom-back px-4 py-2 rounded-3" href="{{ route('admin.dashboard') }}">
          <i class="fa-solid fa-arrow-left me-2"></i>Regresar
        </a>
        <div class="d-flex gap-2">
          <a class="btn btn-custom-image px-4 py-2 rounded-3" href="{{ route('imagenes.create') }}">
            <i class="fa-solid fa-image me-2"></i>+ Subir Imagen Banner
          </a>
          <a class="btn btn-custom-video px-4 py-2 rounded-3" href="{{ route('videos.create') }}">
            <i class="fa-solid fa-video me-2"></i>+ Subir Video Banner
          </a>
        </div>
      </div>

      @if($imagenes->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 shadow-sm mb-5">
          <i class="fa-regular fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
          <p class="text-muted fw-medium mb-0">No hay recursos multimedia subidos actualmente.</p>
        </div>
      @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
          @foreach ($imagenes as $imagen)
            @php
              $extension = strtolower(pathinfo($imagen->imagen_url, PATHINFO_EXTENSION));
              $esVideo = in_array($extension, ['mp4', 'webm', 'mov', 'avi', 'ogg']);
              
              $badgeColor = match($imagen->seccion) {
                'banner', 'banner_principal' => 'bg-primary text-white',
                'nosotros_banner', 'nosotros' => 'bg-info text-dark',
                'logo' => 'bg-warning text-dark',
                default => 'bg-dark text-white'
              };
            @endphp
            
            <div class="col">
              <div class="media-card shadow-sm">
                
                <span class="badge {{ $badgeColor }} section-badge">
                  {{ ucfirst(str_replace('_', ' ', $imagen->seccion)) }}
                </span>

                <span class="type-badge">
                  <i class="{{ $esVideo ? 'fa-solid fa-film' : 'fa-solid fa-image' }} me-1"></i>
                  {{ strtoupper($extension) }}
                </span>

                <div class="media-wrapper" onclick="openPreview('{{ asset($imagen->imagen_url) }}', '{{ $esVideo ? 'video' : 'image' }}', '{{ ucfirst(str_replace('_', ' ', $imagen->seccion)) }}')">
                  @if($esVideo)
                    <video src="{{ asset($imagen->imagen_url) }}" class="media-element" muted loop autoplay playsinline></video>
                  @else
                    <img src="{{ asset($imagen->imagen_url) }}" class="media-element" alt="Recurso {{ $imagen->seccion }}">
                  @endif
                </div>

                <div class="card-body-custom">
                  <div class="small fw-semibold text-dark mb-1">Ruta del archivo:</div>
                  <p class="path-text" title="{{ $imagen->imagen_url }}" style="margin-bottom: 8px;">
                    {{ $imagen->imagen_url }}
                  </p>

                  {{-- URL de redirección --}}
                  <div class="small fw-semibold text-dark mb-1">URL de redirección:</div>
                  @if($imagen->link_url)
                    <a href="{{ $imagen->link_url }}" target="_blank" rel="noopener noreferrer" class="link-url-badge" title="{{ $imagen->link_url }}">
                      <i class="fa-solid fa-link flex-shrink-0"></i>
                      <span>{{ $imagen->link_url }}</span>
                    </a>
                  @else
                    <div class="no-link-badge">
                      <i class="fa-solid fa-link-slash"></i>
                      <span>Sin redirección asignada</span>
                    </div>
                  @endif

                  <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('imagenes.edit', $imagen->id) }}" class="btn btn-sm btn-outline-primary w-50 rounded-3 d-flex align-items-center justify-content-center">
                      <i class="fa-solid fa-pen-to-square me-1.5"></i>Editar
                    </a>
                    
                    <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="post" class="w-50">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-3 d-flex align-items-center justify-content-center" onclick="return confirm('¿Seguro que deseas eliminar de forma permanente este recurso?')">
                        <i class="fa-solid fa-trash-can me-1.5"></i>Eliminar
                      </button>
                    </form>
                  </div>
                </div>

              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom shadow-lg">
          <div class="modal-header bg-light border-0 py-3 px-4">
            <h5 class="modal-title fw-bold text-dark" id="previewModalLabel">Vista Previa del Banner</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body p-0 bg-dark" id="previewModalBody">
            </div>
          <div class="modal-footer border-0 py-3 px-4 bg-light d-flex justify-content-between">
            <span class="badge bg-secondary px-3 py-2 rounded-pill" id="previewModalSection">Sección</span>
            <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    <script>
      function openPreview(url, type, sectionName) {
        const modalBody = document.getElementById('previewModalBody');
        const sectionBadge = document.getElementById('previewModalSection');
        
        // Seteamos el texto de la sección correspondiente
        sectionBadge.textContent = "Asignado a: " + sectionName;
        
        // Limpiamos contenido anterior para que no se queden reproduciendo sonidos en segundo plano
        modalBody.innerHTML = '';
        
        // Inyectamos la etiqueta correcta según lo seleccionado
        if(type === 'video') {
          modalBody.innerHTML = `<video src="${url}" class="preview-modal-media" controls autoplay loop playsinline></video>`;
        } else {
          modalBody.innerHTML = `<img src="${url}" class="preview-modal-media" alt="Previsualización">`;
        }
        
        // Ejecutamos y mostramos el modal flotante
        const myModal = new bootstrap.Modal(document.getElementById('previewModal'));
        myModal.show();
        
        // Detener el video automáticamente si cierran el modal
        document.getElementById('previewModal').addEventListener('hidden.bs.carousel', function () {
          modalBody.innerHTML = '';
        });
      }
    </script>
  </body>
  </html>
  @endauth
</x-app-layout>