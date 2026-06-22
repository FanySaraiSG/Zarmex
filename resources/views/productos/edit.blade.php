<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Producto - Panel Zarmex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        :root {
            --primary-green: #1a7431;
            --medium-green: #2d6a4f;
            --light-green: #d8f3dc;
            --accent-green: #74c69d;
            --bg-gray: #9ddabb;
        }

        body { 
            background-color: var(--bg-gray); 
            font-family: 'Segoe UI', sans-serif; 
        }
        
        .edit-card {
            width: 100%; 
            max-width: 1000px; 
            background: #fff;
            border-radius: 20px; 
            border-top: 10px solid var(--primary-green);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            padding: 40px;
            margin: 40px auto;
        }

        .nav-pills-custom { 
            background-color: var(--light-green); 
            border-radius: 15px; 
            padding: 6px; 
        }
        .nav-pills-custom .nav-link { 
            color: var(--medium-green); 
            font-weight: 600; 
            border-radius: 12px; 
            border: none; 
        }
        .nav-pills-custom .nav-link.active {
            background-color: var(--primary-green) !important; 
            color: white !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .upload-area {
            border: 2px dashed var(--accent-green); 
            background: #fafafa;
            border-radius: 15px; 
            padding: 40px; 
            text-align: center;
            cursor: pointer; 
            transition: 0.3s; 
            margin-bottom: 25px;
        }
        .upload-area:hover { 
            background: var(--light-green); 
            border-color: var(--primary-green); 
        }

        .gallery-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); 
            gap: 20px; 
        }
        .img-slot {
            aspect-ratio: 1; 
            border: 1px solid #e0e0e0;
            border-radius: 12px; 
            position: relative; 
            overflow: hidden;
            background: #fff; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            cursor: grab; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            width: 100%;
        }
        .img-slot:active { cursor: grabbing; }
        .sortable-ghost  { opacity: 0.35; border: 2px dashed var(--primary-green) !important; }
        .sortable-chosen { box-shadow: 0 8px 20px rgba(0,0,0,.18); transform: scale(1.03); }
        
        #sortable-gallery .img-slot::after {
            content: '⠿';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.6);
            pointer-events: none;
        }
        .img-slot img { width: 100%; height: 100%; object-fit: cover; }
        
        .remove-btn {
            position: absolute; 
            top: 8px; 
            right: 8px;
            background: rgba(220, 53, 69, 0.9); 
            color: white;
            border: none; 
            border-radius: 50%; 
            width: 28px; 
            height: 28px;
            font-size: 14px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            cursor: pointer; 
            z-index: 10;
            transition: background 0.2s;
        }
        .remove-btn:hover { background: rgba(200, 35, 50, 1); }

        /* BADGE DINÁMICO DE IMAGEN PRINCIPAL */
        #sortable-gallery .img-slot:first-child::before {
            content: "Principal";
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--primary-green);
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 6px;
            z-index: 5;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .doc-box { 
            border: 1px solid #e0e0e0; 
            border-radius: 12px; 
            padding: 20px; 
            margin-bottom: 20px; 
            transition: 0.3s; 
        }
        .doc-box:hover { 
            border-color: var(--primary-green); 
            background: rgba(216, 243, 220, 0.3); 
        }

        #video-preview-container video { width: 35%; border-radius: 50px; background: #000; margin-top: 10px; }
        .btn-save { background-color: var(--primary-green); color: white; border: none; padding: 15px 40px; border-radius: 12px; font-weight: bold; }
        .btn-back { background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-back:hover { background-color: #5a6268; color: white; }
        .btn-next-tab { background-color: var(--medium-green); color: white; border-radius: 10px; font-weight: 600; }
        .btn-next-tab:hover { background-color: var(--primary-green); color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="edit-card">

        @if(session('success_edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success_edit') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0" style="color: var(--primary-green);">Panel de Edición</h2>
            <a href="{{ route('productos.index') }}" class="btn-back"><i class="bi bi-arrow-left me-2"></i> Regresar</a>
        </div>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf
            @method('PUT')

            <input type="hidden" name="orden_imagenes"     id="orden_imagenes">
            <input type="hidden" name="imagenes_eliminadas" id="imagenes_eliminadas" value="[]">

            <ul class="nav nav-pills nav-justified nav-pills-custom mb-4" id="productTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="tab-info-btn"  data-bs-toggle="tab" data-bs-target="#tab-info"  type="button" role="tab">1. Información Del Producto</button></li>
                <li class="nav-item"><button class="nav-link"        id="tab-media-btn" data-bs-toggle="tab" data-bs-target="#tab-media" type="button" role="tab">2. Multimedia (Imágenes y Video)</button></li>
                <li class="nav-item"><button class="nav-link"        id="tab-docs-btn"  data-bs-toggle="tab" data-bs-target="#tab-docs"  type="button" role="tab">3. Documentos</button></li>
            </ul>

            <div class="tab-content">

                {{-- ══════════════ TAB 1: INFORMACIÓN ══════════════ --}}
                <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                    <div class="row align-items-start">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id_categoria }}" {{ $producto->categoria_id == $cat->id_categoria ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">ID del Producto</label>
                            <input type="text" name="id" id="id" class="form-control bg-light" value="{{ old('id', $producto->id) }}" readonly>
                            <small class="text-danger fw-bold">El código identificador no es modificable.</small>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold text-muted small">DESCRIPCIÓN</label>
                            <textarea name="descripcion" class="form-control" rows="6" placeholder="Escriba aquí la descripción...">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>
                    </div>

                    {{-- COLORES DISPONIBLES --}}
<div class="col-md-12 mb-4">
    <label class="form-label fw-bold text-muted small">COLORES DISPONIBLES</label>

    <div class="d-flex flex-wrap gap-3">
        @foreach($colores as $color)
            <label style="
                display:flex;
                align-items:center;
                gap:8px;
                border:1px solid #ddd;
                padding:8px 12px;
                border-radius:10px;
                cursor:pointer;
                background:#fff;
            ">
                <input
                    type="checkbox"
                    name="colores[]"
                    value="{{ $color->id_color }}"
                    {{ $producto->colores->contains('id_color', $color->id_color) ? 'checked' : '' }}
                >

                <span style="
                    width:24px;
                    height:24px;
                    border-radius:50%;
                    border:1px solid #999;
                    background:#{{ $color->id_color }};
                    display:inline-block;
                "></span>

                <span>{{ $color->nombre }}</span>
            </label>
        @endforeach
    </div>
</div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-next-tab px-4 py-2" onclick="cambiarPestaña('#tab-media-btn')">Siguiente <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div> 
 
                {{-- ══════════════ TAB 2: MULTIMEDIA ══════════════ --}}
                <div class="tab-pane fade" id="tab-media" role="tabpanel">
                    
                    <label class="form-label fw-bold mb-2">GALERÍA DE IMÁGENES (Máximo 6 imágenes en total)</label>
                    
                    {{-- Contenedor unificado de ordenamiento --}}
                    <div class="gallery-grid mb-4" id="sortable-gallery">
                        @if($imagenesExtra && $imagenesExtra->count() > 0)
                            @foreach($imagenesExtra as $img)
                                <div class="img-slot" data-id="existente-{{ $img->id }}">
                                    <button type="button" class="remove-btn" onclick="eliminarImagenSlot(this, 'existente-{{ $img->id }}')">✕</button>
                                    <img src="{{ asset($img->ruta) }}?v={{ $img->updated_at ? $img->updated_at->timestamp : time() }}" alt="Producto">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- DRAG & DROP DE IMÁGENES NUEVAS --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">AGREGAR IMÁGENES NUEVAS</label>
                        <div class="upload-area" id="drop-zone" onclick="document.getElementById('mass-image-input').click()">
                            <i class="bi bi-cloud-arrow-up fs-2 text-success mb-2 d-block"></i>
                            <span class="fw-bold text-secondary d-block">Arrastra tus imágenes aquí</span>
                            <span class="text-muted small">o haz clic para examinar (Máx. 6 imágenes • Hasta 2MB c/u)</span>
                            <input type="file"
                                   id="mass-image-input"
                                   name="imagenes[]"
                                   class="d-none"
                                   accept="image/jpg,image/jpeg,image/png,image/webp,image/gif"
                                   multiple>
                        </div>
                        <div class="form-text text-success" id="disponibles-text">Puedes agregar nuevas imágenes hasta completar un espacio de 6 recuadros.</div>
                    </div>

                    {{-- Video Promocional --}}
                    <label class="form-label fw-bold">VIDEO PROMOCIONAL (Archivo Local)</label>
                    <div class="d-flex gap-3 align-items-start mb-3">
                        <div style="flex: 1;">
                            <input type="file" name="video" id="video-input" class="form-control"
                                   accept="video/mp4,video/mkv,video/x-m4v,video/*"
                                   onchange="previewVideo(this)">
                            <div class="form-text">Se reemplaza el video anterior automáticamente si subes uno nuevo (Máx. 50MB).</div>
                        </div>
                    </div>

                    <div id="video-preview-container" class="mt-2 mb-4" style="{{ ($producto->video_path ?? null) ? '' : 'display:none;' }}">
                        <p class="small text-muted mb-1">Vista previa del Video (archivo local):</p>
                        <video id="video-tag" controls style="width: 45%; border-radius: 12px; background: #000;">
                            <source src="{{ ($producto->video_path ?? null) ? asset($producto->video_path) : '' }}" id="video-source">
                            Tu navegador no soporta la reproducción de video.
                        </video>
                    </div>

                    {{-- Video Promocional (URL de YouTube/Vimeo) — alternativa al archivo --}}
                    @php
                        $videoUrlActual = old('video_url', $producto->video_url ?? '');
                        $embedUrl = '';
                        if ($videoUrlActual) {
                            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $videoUrlActual, $m)) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1';
                            } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrlActual, $m)) {
                                $embedUrl = 'https://player.vimeo.com/video/' . $m[1];
                            }
                        }
                    @endphp
                    <div class="mb-4" style="background:#f0f9fa; border:1px solid #b2d8dc; border-radius:12px; padding:18px;">
                        <label class="form-label fw-bold" style="color:#1a7431;">
                            <i class="bi bi-play-circle me-1"></i> O bien, VIDEO PROMOCIONAL POR URL (YouTube o Vimeo)
                        </label>
                        <input
                            type="url"
                            name="video_url"
                            id="video-url-input"
                            class="form-control"
                            placeholder="https://www.youtube.com/watch?v=... o https://vimeo.com/..."
                            value="{{ $videoUrlActual }}"
                            oninput="previewVideoUrl(this.value)"
                        >
                        <div class="form-text">Si llenas este campo, no es necesario subir un archivo de video. Pega la URL del video de YouTube o Vimeo.</div>

                        <div id="video-url-preview-container" class="mt-3" style="{{ $embedUrl ? '' : 'display:none;' }}">
                            <p class="small text-muted mb-1">Vista previa:</p>
                            <div style="position:relative; padding-bottom:30%; height:0; overflow:hidden; border-radius:12px; max-width:480px;">
                                <iframe
                                    id="video-url-iframe"
                                    src="{{ $embedUrl }}"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-next-tab bg-white text-secondary px-4 py-2" onclick="cambiarPestaña('#tab-info-btn')"><i class="bi bi-arrow-left me-1"></i> Anterior</button>
                        <button type="button" class="btn btn-next-tab px-4 py-2" onclick="cambiarPestaña('#tab-docs-btn')">Siguiente Pestaña <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div>

                {{-- ══════════════ TAB 3: DOCUMENTOS ══════════════ --}}
                <div class="tab-pane fade" id="tab-docs" role="tabpanel">
                    @php
                        $fields = [
                            'doc1' => ['label' => 'Garantía',         'icon' => 'bi-shield-check',         'path' => $producto->doc1_url],
                            'doc2' => ['label' => 'Manual de Usuario', 'icon' => 'bi-book',                 'path' => $producto->doc2_url],
                            'doc3' => ['label' => 'Ficha Técnica',    'icon' => 'bi-file-earmark-pdf',      'path' => $producto->doc3_url],
                        ];
                    @endphp

                    @foreach($fields as $key => $data)
                        @php
                            $docUrl = null;
                            if (!empty($data['path'])) {
                                if (preg_match('#^https?://#', $data['path'])) { $docUrl = $data['path']; }
                                elseif (preg_match('#^/?storage/#', $data['path'])) { $docUrl = asset($data['path']); }
                                else { $docUrl = Storage::url($data['path']); }
                            }
                        @endphp
                    <div class="doc-box">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bi {{$data['icon']}} fs-3 me-3" style="color: var(--primary-green);"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{$data['label']}}</h6>
                                    @if($docUrl)
                                        <a href="{{ $docUrl }}" target="_blank" class="small text-success text-decoration-none">
                                            <i class="bi bi-eye"></i> Examinar documento actual
                                        </a>
                                    @endif
                                    <div id="new-{{$key}}" class="small text-primary fw-bold mt-1" style="display:none;"></div>
                                </div>
                            </div>
                            <label class="btn btn-sm btn-outline-success m-0">
                                <input type="file" name="{{$key}}" class="d-none" accept=".pdf,.doc,.docx" onchange="previewDoc(this, 'new-{{$key}}')">
                                <i class="bi bi-upload"></i> Subir Archivo
                            </label>
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-start mt-4">
                        <button type="button" class="btn btn-outline-secondary btn-next-tab bg-white text-secondary px-4 py-2" onclick="cambiarPestaña('#tab-media-btn')"><i class="bi bi-arrow-left me-1"></i> Anterior</button>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4">
                <span class="text-muted fw-bold" id="tabIndicator">Pestaña 1 de 3</span>
                <button type="submit" id="btn-global-submit" class="btn btn-save px-5 py-2 fs-5 shadow-sm d-none">
                    <i class="bi bi-check-circle me-2"></i> Guardar Todos los Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const galleryEl       = document.getElementById('sortable-gallery');
    const eliminadasInput = document.getElementById('imagenes_eliminadas');
    const btnGlobalSubmit = document.getElementById('btn-global-submit');
    const massInput       = document.getElementById('mass-image-input');
    const dropZone        = document.getElementById('drop-zone');

    let listaEliminadas = [];

    // --- Drag & Drop Core Logic ---
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => e.preventDefault(), false);
        document.body.addEventListener(eventName, (e) => e.preventDefault(), false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.style.background = 'var(--light-green)';
            dropZone.style.borderColor = 'var(--primary-green)';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.style.background = '#fafafa';
            dropZone.style.borderColor = 'var(--accent-green)';
        }, false);
    });

    dropZone.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            massInput.files = files;
            massInput.dispatchEvent(new Event('change'));
        }
    });

    // Lógica para renderizar, limitar a 6 imágenes y validar peso (2MB)
    massInput.addEventListener('change', function() {
        if (this.files) {
            const imagenesActuales = galleryEl.querySelectorAll('.img-slot').length;
            const espaciosDisponibles = 6 - imagenesActuales;

            if (espaciosDisponibles <= 0) {
                alert('Ya has alcanzado el límite máximo de 6 imágenes.');
                this.value = '';
                return;
            }

            const MAX_IMAGE_SIZE = 2 * 1024 * 1024;
            for (let file of this.files) {
                if (file.size > MAX_IMAGE_SIZE) {
                    alert(`La imagen "${file.name}" supera el límite de 2MB permitidos.`);
                    this.value = '';
                    return;
                }
            }

            const filesToProcess = Array.from(this.files).slice(0, espaciosDisponibles);

            filesToProcess.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const slot = document.createElement('div');
                    slot.classList.add('img-slot');
                    slot.setAttribute('data-id', `nueva-${index}`);
                    
                    slot.innerHTML = `
                        <button type="button" class="remove-btn" onclick="eliminarImagenSlot(this)">✕</button>
                        <img src="${e.target.result}" alt="Previa">
                    `;
                    galleryEl.appendChild(slot);
                    actualizarOrdenFormulario();
                }
                reader.readAsDataURL(file);
            });

            if (this.files.length > espaciosDisponibles) {
                alert(`Solo se agregaron ${espaciosDisponibles} imágenes para no superar el límite de 6.`);
            }
        }
    });

    function eliminarImagenSlot(btn, idBaseDatos = null) {
        if (idBaseDatos) {
            listaEliminadas.push(idBaseDatos);
            eliminadasInput.value = JSON.stringify(listaEliminadas);
        }
        btn.parentElement.remove();
        actualizarOrdenFormulario();
    }

    function actualizarOrdenFormulario() {
        const slots    = galleryEl.querySelectorAll('.img-slot');
        const mapeoIds = Array.from(slots).map(slot => slot.getAttribute('data-id'));
        document.getElementById('orden_imagenes').value = JSON.stringify(mapeoIds);
        
        document.getElementById('disponibles-text').innerText = `Imágenes actuales: ${slots.length} de 6 espacios ocupados.`;
    }

    Sortable.create(galleryEl, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        onStart: function () { galleryEl.style.cursor = 'grabbing'; },
        onEnd: function () {
            galleryEl.style.cursor = '';
            actualizarOrdenFormulario();
        }
    });

    function previewVideo(input) {
        const container = document.getElementById('video-preview-container');
        const video     = document.getElementById('video-tag');
        const source    = document.getElementById('video-source');
        
        if (input.files && input.files[0]) {
            // VALIDACIÓN: 50MB máximo (50 * 1024 * 1024)
            const MAX_VIDEO_SIZE = 50 * 1024 * 1024;
            if (input.files[0].size > MAX_VIDEO_SIZE) {
                alert('El video seleccionado supera el límite permitido de 50MB.');
                input.value = '';
                container.style.display = 'none';
                return;
            }

            source.src = URL.createObjectURL(input.files[0]);
            video.load();
            container.style.display = 'block';
        }
    }

    function previewVideoUrl(url) {
        const container = document.getElementById('video-url-preview-container');
        const iframe    = document.getElementById('video-url-iframe');
        let embed = '';

        const ytMatch = url.match(/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/);
        if (ytMatch) embed = `https://www.youtube.com/embed/${ytMatch[1]}?rel=0&modestbranding=1`;

        const vmMatch = url.match(/vimeo\.com\/(\d+)/);
        if (vmMatch) embed = `https://player.vimeo.com/video/${vmMatch[1]}`;

        if (embed) {
            iframe.src = embed;
            container.style.display = 'block';
        } else {
            iframe.src = '';
            container.style.display = 'none';
        }
    }

    function previewDoc(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files[0]) {
            const MAX_DOC_SIZE = 5 * 1024 * 1024;
            if (input.files[0].size > MAX_DOC_SIZE) {
                alert('El documento seleccionado supera el límite de 5MB.');
                input.value = '';
                display.style.display = 'none';
                return;
            }

            display.innerText      = "📄 Nuevo: " + input.files[0].name;
            display.style.display  = 'block';
        }
    }

    function cambiarPestaña(tabButtonId) {
        const triggerEl = document.querySelector(tabButtonId);
        bootstrap.Tab.getOrCreateInstance(triggerEl).show();
    }

    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((btn, idx) => {
        btn.addEventListener('shown.bs.tab', () => {
            document.getElementById('tabIndicator').innerText = `Pestaña ${idx + 1} de 3`;
            if (idx === 2) btnGlobalSubmit.classList.remove('d-none');
            else           btnGlobalSubmit.classList.add('d-none');
        });
    });

    document.getElementById('product-form').addEventListener('submit', function (e) {
        actualizarOrdenFormulario();

        btnGlobalSubmit.disabled = true;
        btnGlobalSubmit.style.backgroundColor = "var(--medium-green)";
        btnGlobalSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Actualizando producto...
        `;
    });

    document.addEventListener('DOMContentLoaded', actualizarOrdenFormulario);
</script>
</body>
</html>