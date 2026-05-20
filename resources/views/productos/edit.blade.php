<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
            --bg-gray: #f0f4f2;
        }

        body { background-color: var(--bg-gray); font-family: 'Segoe UI', sans-serif; }
        
        .edit-card {
            width: 100%; max-width: 1000px; background: #fff;
            border-radius: 20px; border-top: 10px solid var(--primary-green);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); padding: 40px;
            margin: 40px auto;
        }

        /* Tabs Verdes */
        .nav-pills-custom { background-color: var(--light-green); border-radius: 15px; padding: 6px; }
        .nav-pills-custom .nav-link { color: var(--medium-green); font-weight: 600; border-radius: 12px; border: none; }
        .nav-pills-custom .nav-link.active {
            background-color: var(--primary-green) !important; color: white !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Zona de Carga Masiva Unificada */
        .upload-area {
            border: 2px dashed var(--accent-green); background: #fafafa;
            border-radius: 15px; padding: 40px; text-align: center;
            cursor: pointer; transition: 0.3s; margin-bottom: 25px;
        }
        .upload-area:hover { background: var(--light-green); border-color: var(--primary-green); }

        /* Contenedor de Previsualización Dinámica */
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .img-slot {
            aspect-ratio: 1; border: 1px solid #e0e0e0;
            border-radius: 12px; position: relative; overflow: hidden;
            background: #fff; display: flex; align-items: center; justify-content: center;
            cursor: grab; box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            max-width: 150px;
        }

        .img-slot:active { cursor: grabbing; }
        .img-slot img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Botón para remover imágenes individuales */
        .remove-btn {
            position: absolute; top: 8px; right: 8px;
            background: rgba(220, 53, 69, 0.9); color: white;
            border: none; border-radius: 50%; width: 28px; height: 28px;
            font-size: 14px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 10;
        }

        /* Video Preview */
        #video-preview-container video { width: 35%; border-radius: 50px; background: #000; margin-top: 10px; }


        /* Documentos */
        .doc-box { border: 1px solid #e0e0e0; border-radius: 12px; padding: 20px; margin-bottom: 20px; transition: 0.3s; }
        .doc-box:hover { border-color: var(--primary-green); background: var(--bg-gray); }

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

            <input type="hidden" name="orden_imagenes" id="orden_imagenes">
            <input type="hidden" name="imagenes_eliminadas" id="imagenes_eliminadas" value="[]">

            <ul class="nav nav-pills nav-justified nav-pills-custom mb-4" id="productTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="tab-info-btn" data-bs-toggle="tab" data-bs-target="#tab-info" type="button" role="tab">1. Información Del Producto</button></li>
                <li class="nav-item"><button class="nav-link" id="tab-media-btn" data-bs-toggle="tab" data-bs-target="#tab-media" type="button" role="tab">2. Multimedia (Imágenes y Video)</button></li>
                <li class="nav-item"><button class="nav-link" id="tab-docs-btn" data-bs-toggle="tab" data-bs-target="#tab-docs" type="button" role="tab">3. Documentos</button></li>
            </ul>

            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                    <div class="row align-items-start">
                        <div class="col-md-8 mb-3">
                            <label for="categoria_id" class="form-label fw-bold">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id_categoria }}" {{ $producto->categoria_id == $cat->id_categoria ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="id" class="form-label fw-bold">ID</label>
                            <input type="text" name="id" id="id" class="form-control" value="{{ old('id', $producto->id) }}">
                            <small class="text-muted">Modifica este código solo si es estrictamente necesario.</small>
                        </div>

                        <div class="col-md-12 mb-4">

                            <label class="form-label fw-bold text-muted small">NUEVA DESCRIPCIÓN DEL ADMINISTRADOR</label>
                            <textarea name="descripcion" class="form-control" rows="6" placeholder="Escriba aquí la descripción...">{{ old('descripcion', $producto->descripcion) }}</textarea>

                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-next-tab px-4 py-2" onclick="cambiarPestaña('#tab-media-btn')">Siguiente Pestaña <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div> <div class="tab-pane fade" id="tab-media" role="tabpanel">
                    <label class="form-label fw-bold mb-2">GALERÍA DE IMÁGENES</label>
                    
                    <div class="upload-area" onclick="document.getElementById('mass-image-input').click()">
                        <i class="bi bi-images fs-1 text-muted"></i>
                        <p class="mb-0 fw-bold text-muted mt-2">Haz clic aquí para seleccionar o arrastrar tus imágenes (Máx. 6)</p>
                        <input type="file" id="mass-image-input" name="imagenes[]" class="d-none" accept="image/*" multiple>
                    </div>

                    <div class="gallery-grid mb-4" id="sortable-gallery">
                        @foreach($imagenesExtra as $img)
                            <div class="img-slot" data-id="existente-{{ $img->id }}">
                                <button type="button" class="remove-btn" onclick="eliminarImagenSlot(this, '{{ $img->id }}')">✕</button>
                                <img src="{{ asset($img->ruta) }}" alt="Producto">
                            </div>
                        @endforeach
                    </div>

                    <label class="form-label fw-bold">VIDEO PROMOCIONAL (Archivo Local)</label>
                    <div class="d-flex gap-3 align-items-start mb-3">
                        <div style="flex: 1;">
                            <input type="file" name="video" id="video-input" class="form-control" accept="video/mp4,video/mkv,video/x-m4v,video/*" onchange="previewVideo(this)">
                            <div class="form-text">Se reemplaza el video anterior (si subes uno nuevo).</div>
                        </div>
                        @if(!empty($producto->video_url))
                            <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="borrarVideoActual({{ $producto->id }})">Borrar video actual</button>
                        @endif
                    </div>
                    
                    <div id="video-preview-container" class="mt-2 mb-4" style="{{ $producto->video_url ? '' : 'display:none;' }}">

                        <p class="small text-muted mb-1">Vista previa del video seleccionado:</p>
                        <video id="video-tag" controls style="width: 100%; border-radius: 12px; background: #000;">
                            <source src="{{ $producto->video_url ? asset($producto->video_url) : '' }}" id="video-source">
                            Tu navegador no soporta carga de videos.
                        </video>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-next-tab bg-white text-secondary px-4 py-2" onclick="cambiarPestaña('#tab-info-btn')"><i class="bi bi-arrow-left me-1"></i> Anterior</button>
                        <button type="button" class="btn btn-next-tab px-4 py-2" onclick="cambiarPestaña('#tab-docs-btn')">Siguiente Pestaña <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-docs" role="tabpanel">
                    @php 
                        $fields = [
                            'doc1' => ['label' => 'Garantía', 'icon' => 'bi-shield-check', 'path' => $producto->doc1_url],
                            'doc2' => ['label' => 'Manual de Usuario', 'icon' => 'bi-book', 'path' => $producto->doc2_url],
                            'doc3' => ['label' => 'Ficha Técnica', 'icon' => 'bi-file-earmark-pdf', 'path' => $producto->doc3_url]
                        ];
                    @endphp

                    @foreach($fields as $key => $data)
                    <div class="doc-box">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi {{$data['icon']}} fs-3 me-3" style="color: var(--primary-green);"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{$data['label']}}</h6>
                                    @if($data['path'])
                                        <a href="{{ asset($data['path']) }}" target="_blank" class="small text-success">
                                            <i class="bi bi-eye"></i> Ver archivo anterior
                                        </a>
                                    @endif
                                    <div id="new-{{$key}}" class="small text-primary fw-bold mt-1" style="display:none;"></div>
                                </div>
                            </div>
                            <label class="btn btn-sm btn-outline-success">
                                <input type="file" name="{{$key}}" class="d-none" onchange="previewDoc(this, 'new-{{$key}}')">
                                <i class="bi bi-upload"></i> Nuevo Archivo
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
    const massInput = document.getElementById('mass-image-input');
    const galleryEl = document.getElementById('sortable-gallery');
    const eliminadasInput = document.getElementById('imagenes_eliminadas');
    const btnGlobalSubmit = document.getElementById('btn-global-submit');
    let listaEliminadas = [];

    function cambiarPestaña(tabButtonId) {
        const triggerEl = document.querySelector(tabButtonId);
        bootstrap.Tab.getOrCreateInstance(triggerEl).show();
    }

    massInput.addEventListener('change', function() {
        if (this.files) {
            const imagenesActuales = galleryEl.querySelectorAll('.img-slot').length;
            const espaciosDisponibles = 6 - imagenesActuales;
            const filesToProcess = Array.from(this.files).slice(0, espaciosDisponibles);

            filesToProcess.forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const slot = document.createElement('div');
                    slot.classList.add('img-slot');
                    slot.setAttribute('data-id', `nueva-${file.name}`);
                    
                    slot.innerHTML = `
                        <button type="button" class="remove-btn" onclick="eliminarImagenSlot(this)">✕</button>
                        <img src="${e.target.result}" alt="Previa">
                    `;
                    galleryEl.appendChild(slot);
                    actualizarOrdenFormulario();
                }
                reader.readAsDataURL(file);
            });
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

    function previewVideo(input) {
        const container = document.getElementById('video-preview-container');
        const video = document.getElementById('video-tag');
        const source = document.getElementById('video-source');

        if (input.files && input.files[0]) {
            const fileURL = URL.createObjectURL(input.files[0]);
            source.src = fileURL;
            video.load();
            container.style.display = 'block';
        }
    }

    function borrarVideoActual(productoId) {
        if (!confirm('¿Seguro que deseas borrar el video actual?')) return;

        fetch(`{{ url('/employees/productos') }}/${productoId}/video`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data && data.success) location.reload();
            else alert('No se pudo borrar el video.');
        })
        .catch(() => alert('Error al borrar el video.'));
    }


    function previewDoc(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files[0]) {
            display.innerText = "📄 Nuevo: " + input.files[0].name;
            display.style.display = 'block';
        }
    }

    Sortable.create(galleryEl, {
        animation: 150,
        ghostClass: 'bg-light',
        onEnd: function () {
            actualizarOrdenFormulario();
        }
    });

    function actualizarOrdenFormulario() {
        const slots = galleryEl.querySelectorAll('.img-slot');
        const mapeoIds = Array.from(slots).map(slot => slot.getAttribute('data-id'));
        document.getElementById('orden_imagenes').value = JSON.stringify(mapeoIds);
    }

    document.addEventListener("DOMContentLoaded", actualizarOrdenFormulario);

    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((btn, idx) => {
        btn.addEventListener('shown.bs.tab', () => {
            document.getElementById('tabIndicator').innerText = `Pestaña ${idx + 1} de 3`;
            
            if (idx === 2) {
                btnGlobalSubmit.classList.remove('d-none');
            } else {
                btnGlobalSubmit.classList.add('d-none');
            }
        });
    });

    document.getElementById('product-form').addEventListener('submit', function(e) {
        actualizarOrdenFormulario();
    });
</script>
</body>
</html>