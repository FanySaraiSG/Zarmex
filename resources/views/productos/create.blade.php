<x-app-layout>
    @auth('employee')
        @if(Auth::user()->rol === 'admin')

<style>
    #product-form {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        border-radius: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    :root {
        --primary: #1a5c38;
        --medium:  #2d6a4f;
        --light:   #e8f5e9;
        --bg:      #a8d5b5;
        --border:  #b0bec5;
        --success: #2e7d32;
    }

    .create-page {
        background: var(--bg);
        min-height: 100vh;
        width: 100% !important;
        max-width: 100% !important;
        padding: 20px 40px 40px !important;
        margin: 0 !important;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    .page-header-zone {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 16px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 900;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0;
    }

    .btn-back-top {
        position: absolute;
        left: 0;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 6px 20px;
        font-size: 0.85rem;
        text-decoration: none;
        font-weight: 700;
        transition: background .15s;
    }
    .btn-back-top:hover { background: var(--medium); color: #fff; }

    .card-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        background: #fff;
        border-radius: 20px;
        border: 2px dashed #90a4ae;
        padding: 24px;
        box-shadow: 0 8px 40px rgba(0,0,0,.12);
        box-sizing: border-box;
    }

    .cp-grid {
        display: grid;
        grid-template-columns: 54% 46%;
        gap: 24px;
        align-items: start;
        width: 100%;
    }

    .cp-media {
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-width: 0;
    }

    .cp-dropzone {
        border: 2px dashed #90a4ae;
        border-radius: 14px;
        min-height: 120px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: #fafafa;
        color: #888;
        font-size: 0.95rem;
        font-weight: 700;
        gap: 4px;
        transition: .2s;
    }
    .cp-dropzone:hover { background: var(--light); border-color: var(--primary); }
    .cp-dropzone i { font-size: 2.2rem; color: #90a4ae; }
    .cp-dropzone small { font-weight: 400; color: #bbb; font-size: 0.8rem; }

    .cp-thumbgrid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        width: 100%;
    }
    .cp-thumb {
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        border: 1.5px solid #e0e0e0;
        position: relative;
        background: #f5f5f5;
        cursor: grab;
    }
    .cp-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .cp-thumb .remove-btn {
        position: absolute; top: 4px; right: 4px;
        background: rgba(220,53,69,.9); color: #fff;
        border: none; border-radius: 50%;
        width: 22px; height: 22px; font-size: 11px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; z-index: 10;
    }

    .cp-thumb:first-child::before {
        content: "Principal";
        position: absolute;
        top: 6px;
        left: 6px;
        background: var(--primary);
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 6px;
        z-index: 5;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }

    .sortable-ghost  { opacity: .3; border: 2px dashed var(--primary) !important; }
    .sortable-chosen { box-shadow: 0 6px 16px rgba(0,0,0,.15); transform: scale(1.02); }

    .cp-video-label {
        font-size: .8rem;
        font-weight: 700;
        color: #555;
        margin-bottom: 4px;
        display: block;
    }
    .cp-video-input {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 7px 12px;
        font-size: .85rem;
        background: #fff;
    }
    #cp-video-preview { margin-top: 8px; }
    #cp-video-preview video {
        width: 100%;
        border-radius: 12px;
        background: #000;
        max-height: 180px;
    }

    .cp-form-panel {
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        min-width: 0;
        border: 1px solid #e0e0e0;
    }

    .cp-form-header {
        background: var(--primary);
        color: #fff;
        text-align: center;
        font-weight: 900;
        font-size: 0.95rem;
        letter-spacing: 1px;
        padding: 12px;
        text-transform: uppercase;
    }

    .cp-form-body {
        background: #fff;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .cp-row2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .cp-label {
        font-size: .78rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
        display: block;
    }

    .cp-input, .cp-select, .cp-textarea {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: .9rem;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        background: #fff;
        box-sizing: border-box;
    }
    .cp-input:focus, .cp-select:focus, .cp-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,92,56,.05);
    }
    .cp-input[readonly] { background: #f1f8f4; color: var(--medium); font-weight: 700; }
    .cp-textarea { resize: vertical; min-height: 70px; }

    .cp-docs-title {
        font-size: .75rem;
        font-weight: 800;
        color: #333;
        letter-spacing: .5px;
        text-transform: uppercase;
        margin: 4px 0 8px 0;
    }
    .cp-docs-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .cp-doc-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 10px 6px;
        cursor: pointer;
        font-size: .72rem;
        font-weight: 700;
        color: #333;
        text-align: center;
        transition: .2s;
        background: #fff;
    }
    .cp-doc-btn:hover { border-color: var(--primary); background: var(--light); }
    .cp-doc-btn i { font-size: 1.4rem; color: var(--primary); }
    
    .cp-doc-btn.selected { 
        border-color: var(--success); 
        background: #e8f5e9; 
        color: var(--success); 
    }

    .cp-btn-crear {
        width: 100%;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 900;
        font-size: 1rem;
        cursor: pointer;
        transition: background .15s;
        margin-top: 6px;
    }
    .cp-btn-crear:hover { background: var(--medium); }

    @media (max-width: 992px) {
        .cp-grid  { grid-template-columns: 1fr; }
        .create-page { padding: 16px !important; }
    }
</style>

<div class="create-page">

    @if ($errors->any())
        <div style="max-width:1400px;margin:0 auto 16px;box-sizing:border-box;"
             class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0" style="font-size: 0.85rem;">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-header-zone">
        <a href="{{ route('productos.index') }}" class="btn-back-top">Regresar</a>
        <h1 class="page-title">Añadir Producto</h1>
    </div>

    <div class="card-wrapper">
        <form action="{{ route('productos.store') }}" method="POST"
              enctype="multipart/form-data" id="product-form">
            @csrf
            <input type="hidden" name="orden_imagenes" id="orden_imagenes">

            <div class="cp-grid">
                <div class="cp-media">
                    <div class="cp-dropzone"
                         onclick="document.getElementById('mass-image-input').click()"
                         ondragover="event.preventDefault()"
                         ondrop="handleDrop(event)">
                        <i class="bi bi-upload"></i>
                        <span>Arrastra tus imágenes aquí</span>
                        <small>o haz clic para examinar (Máx. 6 imágenes • Hasta 2MB c/u)</small>
                        <input type="file" id="mass-image-input" name="imagenes[]"
                               class="d-none" accept="image/*" multiple
                               onchange="previsualizarNuevas(this)">
                    </div>

                    <div class="cp-thumbgrid" id="sortable-gallery"></div>

                    <div>
                        <span class="cp-video-label">Video Promocional <small class="text-muted">(Opcional - Máx. 50MB)</small>:</span>
                        <input type="file" name="video" id="video-input"
                               class="cp-video-input"
                               accept="video/mp4,video/mkv,video/x-m4v,video/*"
                               onchange="previewVideo(this)">
                        <div id="cp-video-preview" style="display: none;">
                            <video id="video-tag" controls>
                                 <source src="" id="video-source">
                            </video>
                        </div>
                    </div>

                    {{-- Video Promocional (URL de YouTube/Vimeo) — alternativa al archivo --}}
                    <div class="mt-3" style="background:#f0f9fa; border:1px solid #b2d8dc; border-radius:12px; padding:18px;">
                        <label class="cp-video-label" style="color:#1a7431;">
                            <i class="bi bi-play-circle me-1"></i> O bien, Video Promocional por URL <small class="text-muted">(YouTube o Vimeo)</small>:
                        </label>
                        <input
                            type="url"
                            name="video_embed_url"
                            id="video-url-input"
                            class="cp-video-input"
                            placeholder="https://www.youtube.com/watch?v=... o https://vimeo.com/..."
                            oninput="previewVideoUrl(this.value)">
                        <div class="form-text">Si llenas este campo, no es necesario subir un archivo de video.</div>

                        <div id="video-url-preview-container" class="mt-3" style="display:none;">
                            <p class="small text-muted mb-1">Vista previa:</p>
                            <div style="position:relative; padding-bottom:30%; height:0; overflow:hidden; border-radius:12px; max-width:480px;">
                                <iframe
                                    id="video-url-iframe"
                                    src=""
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cp-form-panel">
                    <div class="cp-form-header">Identificador del Producto</div>
                    <div class="cp-form-body">
                        <div class="cp-row2">
                            <div>
                                <label class="cp-label">Categoría: <span class="text-danger">*</span></label>
                                <select class="cp-select" id="categoria_id" name="categoria_id"
                                        required onchange="generarId()">
                                    <option value="">Seleccionar</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="cp-label">ID Categoría:</label>
                                <input type="text" id="id_categoria" name="id_categoria"
                                       class="cp-input" readonly>
                            </div>
                        </div>

                        <div class="cp-row2">
                            <div>
                                <label class="cp-label">Número Base: <span class="text-danger">*</span></label>
                                <input type="text" id="numero_base" name="numero_base" class="cp-input"
                                       placeholder="Ej: 011" required autocomplete="off">
                            </div>
                            <div>
                                <label class="cp-label">Variante Base (opcional):</label>
                                <input type="text" id="variante_base" name="variante_base" class="cp-input"
                                       placeholder="Ej: 005" autocomplete="off">
                            </div>
                        </div>

                        <div>
                            <label class="cp-label">ID Autogenerado:</label>
                            <input type="text" id="id" name="id" class="cp-input" readonly required>
                        </div>

                        <div>
                            <label class="cp-label">Descripción: <span class="text-danger">*</span></label>
                            <textarea name="descripcion" class="cp-textarea" required
                                      placeholder="Escribe la descripción de la pieza...">{{ old('descripcion') }}</textarea>
                        </div>

                        <div>
                            <p class="cp-docs-title">Documentos Técnicos <small class="text-muted">(PDF, DOCX - Máx. 5MB)</small></p>
                            <div class="cp-docs-row">
                                <label class="cp-doc-btn" id="label-doc1">
                                    <i class="bi bi-file-earmark-arrow-up"></i> Garantía
                                    <input type="file" name="doc1" class="d-none" id="doc1"
                                           accept=".pdf,.doc,.docx"
                                           onchange="validarYMarcarDoc(this,'label-doc1')">
                                </label>
                                <label class="cp-doc-btn" id="label-doc2">
                                    <i class="bi bi-file-earmark-arrow-up"></i> Manual
                                    <input type="file" name="doc2" class="d-none" id="doc2"
                                           accept=".pdf,.doc,.docx"
                                           onchange="validarYMarcarDoc(this,'label-doc2')">
                                </label>
                                <label class="cp-doc-btn" id="label-doc3">
                                    <i class="bi bi-file-earmark-arrow-up"></i> Ficha Técnica
                                    <input type="file" name="doc3" class="d-none" id="doc3"
                                           accept=".pdf,.doc,.docx"
                                           onchange="validarYMarcarDoc(this,'label-doc3')">
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="cp-btn-crear" id="submit-btn">Crear Producto</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    function generarId() {
    const catSelect = document.getElementById('categoria_id');
    const idCat = catSelect.value;
    
    if (!idCat) {
        document.getElementById('id_categoria').value = '';
        document.getElementById('id').value = '';
        return;
    }

    document.getElementById('id_categoria').value = idCat;
    
    // CAMBIO AQUÍ: La URL debe incluir el prefijo '/employees/' 
    // porque tu ruta en web.php está dentro de ese grupo.
    const url = "{{ url('/employees/productos/obtener-siguiente-base') }}/" + encodeURIComponent(idCat);

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Error ' + response.status);
            return response.json();
        })
        .then(data => {
            // Asigna el número base y actualiza el ID final
            document.getElementById('numero_base').value = data.siguiente_numero;
            procesarCadenaId(idCat, data.siguiente_numero, document.getElementById('variante_base').value);
        })
        .catch(err => {
            console.error("Error al obtener ID:", err);
            // Fallback por si la API falla
            document.getElementById('numero_base').value = '001';
            procesarCadenaId(idCat, '001', document.getElementById('variante_base').value);
        });
}

    function procesarCadenaId(idCat, numBase, variante) {
        const partes = [idCat, numBase, variante].filter(item => item && item.trim() !== "");
        document.getElementById('id').value = partes.length >= 2 ? partes.join('-') : '';
    }

    document.getElementById('numero_base').addEventListener('input', function() {
        procesarCadenaId(document.getElementById('categoria_id').value, this.value, document.getElementById('variante_base').value);
    });

    document.getElementById('variante_base').addEventListener('input', function() {
        procesarCadenaId(document.getElementById('categoria_id').value, document.getElementById('numero_base').value, this.value);
    });

    const galleryEl = document.getElementById('sortable-gallery');

    function previsualizarNuevas(input) {
        if (!input.files || !input.files.length) return;
        
        const actuales = galleryEl.querySelectorAll('.cp-thumb').length;
        const espacios = 6 - actuales;
        
        const MAX_IMAGE_SIZE = 2 * 1024 * 1024; 
        let archivosFiltrados = Array.from(input.files);

        for (let file of archivosFiltrados) {
            if (file.size > MAX_IMAGE_SIZE) {
                alert(`La imagen "${file.name}" supera el límite de 2MB permitidos.`);
                input.value = '';
                return;
            }
        }
        
        archivosFiltrados.slice(0, espacios).forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = e => {
                const slot = document.createElement('div');
                slot.classList.add('cp-thumb');
                slot.setAttribute('data-id', `nueva-${actuales + idx}`);
                slot.innerHTML = `
                    <button type="button" class="remove-btn" onclick="quitarThumb(this)">✕</button>
                    <img src="${e.target.result}" alt="${file.name}">
                `;
                galleryEl.appendChild(slot);
                actualizarOrden();
            };
            reader.readAsDataURL(file);
        });
    }

    function handleDrop(e) {
        e.preventDefault();
        const inputImagenes = document.getElementById('mass-image-input');
        inputImagenes.files = e.dataTransfer.files;
        previsualizarNuevas(inputImagenes);
    }

    function quitarThumb(btn) {
        btn.parentElement.remove();
        actualizarOrden();
    }

    function actualizarOrden() {
        const ids = Array.from(galleryEl.querySelectorAll('.cp-thumb'))
                        .map(s => s.getAttribute('data-id'));
        document.getElementById('orden_imagenes').value = JSON.stringify(ids);
    }

    Sortable.create(galleryEl, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: actualizarOrden
    });

    function previewVideo(input) {
        if (input.files && input.files[0]) {
            const MAX_VIDEO_SIZE = 50 * 1024 * 1024;
            if (input.files[0].size > MAX_VIDEO_SIZE) {
                alert('El video seleccionado es demasiado pesado. El límite máximo es de 50MB.');
                input.value = '';
                document.getElementById('cp-video-preview').style.display = 'none';
                return;
            }

            document.getElementById('video-source').src = URL.createObjectURL(input.files[0]);
            document.getElementById('video-tag').load();
            document.getElementById('cp-video-preview').style.display = 'block';
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

    function validarYMarcarDoc(input, labelId) {
        if (input.files && input.files[0]) {
            const MAX_DOC_SIZE = 5 * 1024 * 1024;
            if (input.files[0].size > MAX_DOC_SIZE) {
                alert(`El documento seleccionado supera el límite de 5MB.`);
                input.value = '';
                document.getElementById(labelId).classList.remove('selected');
                return;
            }
            document.getElementById(labelId).classList.add('selected');
        }
    }

    document.getElementById('product-form').addEventListener('submit', function(e) {
        if (!document.getElementById('id').value) {
            e.preventDefault();
            alert('Por favor genera el ID del producto antes de continuar.');
            return;
        }
        
        actualizarOrden();
        
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.style.background = "#2d6a4f";
        btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 8px;"></span> Guardando...`;
        
        this.submit();
    });

    document.addEventListener('DOMContentLoaded', function() {
        ['div.zx-bg-wrap', 'main'].forEach(function(sel) {
            const el = document.querySelector(sel);
            if (el) {
                el.style.setProperty('width', '100vw', 'important');
                el.style.setProperty('max-width', '100vw', 'important');
                el.style.setProperty('padding-left', '0', 'important');
                el.style.setProperty('padding-right', '0', 'important');
                el.style.setProperty('margin-left', '0', 'important');
                el.style.setProperty('margin-right', '0', 'important');
            }
        });
        actualizarOrden();
    });
</script>

        @else
            <div class="container mt-5">
                <div class="alert alert-danger text-center">
                    <h4>Acceso Denegado</h4>
                    <p>No tienes los permisos administrativos necesarios para ingresar aquí.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Regresar al Inicio</a>
                </div>
            </div>
        @endif
    @endauth
</x-app-layout>