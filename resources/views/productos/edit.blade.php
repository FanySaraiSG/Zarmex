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

        /* Galería de Imágenes */
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .img-slot {
            aspect-ratio: 1; border: 2px dashed var(--accent-green);
            border-radius: 12px; position: relative; overflow: hidden;
            background: #fafafa; display: flex; align-items: center; justify-content: center;
        }
        .img-slot img { width: 100%; height: 100%; object-fit: cover; }
        .preview-label { cursor: pointer; text-align: center; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; }

        /* Video Preview */
        #video-preview-container video { width: 100%; border-radius: 12px; background: #000; margin-top: 10px; }

        /* Documentos */
        .doc-box { border: 1px solid #e0e0e0; border-radius: 12px; padding: 15px; margin-bottom: 15px; transition: 0.3s; }
        .doc-box:hover { border-color: var(--primary-green); background: var(--bg-gray); }

        .btn-save { background-color: var(--primary-green); color: white; border: none; padding: 12px 30px; border-radius: 12px; font-weight: bold; }
        .btn-back { background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-back:hover { background-color: #5a6268; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="edit-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: var(--primary-green);">Panel de Edición</h2>
            <a href="{{ route('productos.index') }}" class="btn-back"><i class="bi bi-arrow-left me-2"></i> Regresar</a>
        </div>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <ul class="nav nav-pills nav-justified nav-pills-custom mb-4" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-info" type="button">1. Información</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-media" type="button">2. Multimedia</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-docs" type="button">3. Documentos</button></li>
            </ul>

            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="tab-info">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold text-muted small">ID DEL PRODUCTO</label>
                            <input type="text" class="form-control bg-light" value="{{ $producto->id }}" readonly>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold text-muted small">CATEGORÍA</label>
                            <select name="categoria_id" class="form-select">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id_categoria }}" {{ $producto->categoria_id == $cat->id_categoria ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">NUEVA DESCRIPCIÓN DEL ADMINISTRADOR</label>
                            <textarea name="descripcion" class="form-control" rows="8" placeholder="Escriba aquí la descripción detallada..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-media">
                    <label class="form-label fw-bold mb-3">GALERÍA DE IMÁGENES (Arrastra para ordenar)</label>
                    <div class="gallery-grid mb-4" id="sortable-gallery">
                        @for($i = 0; $i < 6; $i++)
                        <div class="img-slot">
                            <label class="preview-label" id="label-img-{{$i}}">
                                <input type="file" name="imagenes[]" class="d-none" accept="image/*" onchange="previewImage(this, 'img-view-{{$i}}')">
                                <img id="img-view-{{$i}}" src="{{ isset($imagenesExtra[$i]) ? asset($imagenesExtra[$i]->ruta) : '' }}" 
                                     style="{{ isset($imagenesExtra[$i]) ? '' : 'display:none;' }}">
                                @if(!isset($imagenesExtra[$i]))
                                    <i class="bi bi-camera text-muted fs-2"></i>
                                    <span class="small text-muted">Agregar</span>
                                @endif
                            </label>
                        </div>
                        @endfor
                    </div>

                    <label class="form-label fw-bold">VIDEO PROMOCIONAL</label>
                    <input type="file" name="video_url" class="form-control" accept="video/*" onchange="previewVideo(this)">
                    <div id="video-preview-container" class="mt-2" style="{{ $producto->video_url ? '' : 'display:none;' }}">
                        <p class="small text-muted mb-1">Vista previa del video:</p>
                        <video id="video-tag" controls>
                            <source src="{{ $producto->video_url ? asset($producto->video_url) : '' }}" id="video-source">
                        </video>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-docs">
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
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4">
                <span class="text-muted fw-bold" id="tabIndicator">Pestaña 1 de 3</span>
                <button type="submit" class="btn btn-save">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // 1. Previsualización de Imágenes
    function previewImage(input, imgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                img.src = e.target.result;
                img.style.display = 'block';
                // Ocultar icono de 'plus' si existe
                input.parentElement.querySelector('i')?.remove();
                input.parentElement.querySelector('span')?.remove();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 2. Previsualización de Video
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

    // 3. Previsualización de Documentos
    function previewDoc(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files[0]) {
            display.innerText = "📄 Nuevo: " + input.files[0].name;
            display.style.display = 'block';
        }
    }

    // 4. SortableJS (Arrastrar)
    Sortable.create(document.getElementById('sortable-gallery'), {
        animation: 150,
        ghostClass: 'bg-light'
    });

    // 5. Indicador de pasos
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((btn, idx) => {
        btn.addEventListener('shown.bs.tab', () => {
            document.getElementById('tabIndicator').innerText = `Pestaña ${idx + 1} de 3`;
        });
    });
</script>

</body>
</html>