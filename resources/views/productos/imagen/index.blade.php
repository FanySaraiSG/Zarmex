<x-app-layout>
    @auth('employee')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .img-page { background: #f3f5f6; min-height: 100vh; padding: 30px 15px; }
        .img-shell { max-width: 1100px; margin: auto; background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 12px 30px rgba(0,0,0,.1); }
        .img-shell h1 { color: #234d50; font-weight: 900; text-align: center; margin-bottom: 6px; }
        .img-shell .subtitle { text-align: center; color: #888; font-size: 0.9rem; margin-bottom: 24px; }

        /* GRID DE SLOTS */
        .slots-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 30px; }
        @media(max-width: 768px) { .slots-grid { grid-template-columns: repeat(2, 1fr); } }
        @media(max-width: 480px) { .slots-grid { grid-template-columns: 1fr; } }

        .slot-card { border: 2px dashed #ccc; border-radius: 14px; overflow: hidden; background: #fafafa; position: relative; aspect-ratio: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: border-color 0.2s; }
        .slot-card.ocupado { border: 2px solid #28666e; background: #fff; }
        .slot-card.ocupado:hover { border-color: #e63946; }

        .slot-card img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .slot-num { position: absolute; top: 8px; left: 10px; background: #28666e; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px; z-index: 2; }

        .slot-empty-icon { font-size: 2.5rem; color: #ccc; margin-bottom: 8px; }
        .slot-empty-text { font-size: 0.75rem; color: #aaa; }

        .slot-actions { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.55); display: flex; justify-content: center; gap: 8px; padding: 8px; opacity: 0; transition: opacity 0.2s; }
        .slot-card.ocupado:hover .slot-actions { opacity: 1; }
        .slot-actions .btn { font-size: 11px; padding: 4px 10px; border-radius: 8px; }

        /* UPLOAD SECTION */
        .upload-section { background: #f8f9fa; border-radius: 14px; padding: 20px; border: 1px solid #eee; }
        .upload-section h5 { color: #234d50; font-weight: 700; margin-bottom: 4px; }
        .upload-section p { font-size: 0.82rem; color: #888; margin-bottom: 12px; }

        /* VIDEO SECTION */
        .video-section { background: #f0f7f8; border-radius: 14px; padding: 20px; border: 1px solid #c4e0e2; margin-top: 16px; }
        .video-section h5 { color: #234d50; font-weight: 700; margin-bottom: 4px; }
        .video-section p { font-size: 0.82rem; color: #888; margin-bottom: 12px; }
        .video-preview { border-radius: 10px; width: 100%; max-height: 200px; object-fit: cover; }

        .btn-zx { background: #28666e; color: #fff; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 700; }
        .btn-zx:hover { background: #1d4f55; color: #fff; }
        .btn-back { background: #eee; color: #333; border: none; border-radius: 10px; padding: 8px 18px; font-weight: 600; }

        .counter { font-size: 0.85rem; font-weight: 600; }
        .counter.ok { color: #28666e; }
        .counter.full { color: #e63946; }

        .form-actions { display:flex; justify-content:flex-end; margin-top: 18px; }
    </style>

    <div class="img-page">
        <div class="img-shell">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('productos.edit', $producto->id) }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Regresar
                </a>
                <span class="counter {{ $imagenes->count() >= 6 ? 'full' : 'ok' }}">
                    <i class="fa-solid fa-images me-1"></i>
                    {{ $imagenes->count() }} / 6 imágenes extra
                </span>
            </div>

            <h1>Galería del Producto</h1>
            <p class="subtitle">{{ $producto->nombre }} · {{ $producto->id }}</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- IMAGEN PRINCIPAL --}}
            <h6 class="fw-bold text-muted mb-2" style="font-size:0.8rem; letter-spacing:1px; text-transform:uppercase;">Imagen Principal</h6>
            <div class="d-flex align-items-center gap-3 mb-4 p-3" style="background:#f8f9fa; border-radius:12px; border:1px solid #eee;">
                <img src="{{ asset($producto->imagen_url) }}" style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:2px solid #28666e;">
                <div>
                    <div class="fw-bold" style="color:#234d50;">Imagen Principal</div>
                    <div style="font-size:0.78rem; color:#aaa;">{{ $producto->imagen_url }}</div>
                    <div style="font-size:0.75rem; color:#28666e;" class="mt-1"><i class="fa-solid fa-circle-info me-1"></i>Se edita desde "Editar Producto"</div>
                </div>
            </div>

            {{-- FORM ÚNICO (imágenes + video + reorden) --}}
            <form id="galeria-form" action="{{ route('productos.imagenes.guardarTodo', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- GRID DE SLOTS --}}
                <h6 class="fw-bold text-muted mb-2" style="font-size:0.8rem; letter-spacing:1px; text-transform:uppercase;">Imágenes Extra (máx. 6)</h6>

                <div class="slots-grid">
                    @for($i = 1; $i <= 6; $i++)
                        @php $img = $imagenes->firstWhere('orden', $i); @endphp
                        <div class="slot-card {{ $img ? 'ocupado' : '' }}"
                             draggable="{{ $img ? 'true' : 'false' }}"
                             ondragstart="dragStart({{ $img ? $img->img_id : 'null' }})"
                             ondragover="dragOver(event)"
                             ondrop="dropOnSlot(event, {{ $i }})"
                             data-slot="{{ $i }}">

                            <input type="hidden" name="ordenes[{{ $i }}]" id="orden_slot_{{ $i }}" value="{{ $img ? $img->img_id : '' }}">

                            <span class="slot-num">{{ $i }}</span>

                            @if($img)
                                <img src="{{ asset($img->ruta) }}?v={{ time() }}" alt="Imagen {{ $i }}">
                                {{-- Nota: no mostramos Editar/Borrar para cumplir "un solo botón al final" --}}
                            @else
                                <div class="slot-empty-icon"><i class="fa-regular fa-image"></i></div>
                                <div class="slot-empty-text">Vacío</div>
                            @endif
                        </div>
                    @endfor
                </div>

                {{-- SUBIR NUEVAS IMÁGENES --}}
                @if($imagenes->count() < 6)
                    <div class="upload-section">
                        <h5><i class="fa-solid fa-cloud-arrow-up me-2"></i>Subir Imágenes</h5>
                        <p>Puedes subir hasta {{ 6 - $imagenes->count() }} imagen(es) más. Formatos: JPG, PNG, WEBP, GIF. Máx. 2MB c/u.</p>

                        <div class="mb-3">
                            <input type="file" name="imagenes[]" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/gif" onchange="previewImages(this)">
                            <div class="form-text">Selecciona hasta {{ 6 - $imagenes->count() }} archivo(s) a la vez.</div>
                        </div>

                        <div id="preview-container" class="d-flex flex-wrap gap-2 mb-3"></div>
                    </div>
                @else
                    <div class="alert alert-warning mt-2">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        Ya tienes 6 imágenes. Elimina alguna para subir una nueva.
                    </div>
                @endif

                {{-- VIDEO --}}
                <div class="video-section">
                    <h5><i class="fa-solid fa-video me-2"></i>Video del Producto</h5>
                    <p>Sube un video en formato MP4. Máx. 50MB. Se guardará como video del producto.</p>

                    @if(!empty($producto->video_url))
                        <div class="mb-3">
                            <div class="fw-bold mb-1" style="font-size:0.8rem; color:#234d50;">Video actual:</div>
                            <video class="video-preview" controls>
                                <source src="{{ asset($producto->video_url) }}" type="video/mp4">
                            </video>
                        </div>
                    @endif

                    <div class="mb-3">
                        <input type="file" name="video" class="form-control" accept="video/mp4">
                        <div class="form-text">Si no seleccionas video, se conserva el actual.</div>
                    </div>
                </div>

                {{-- ÚNICO BOTÓN FINAL --}}
                <div class="form-actions">
                    <button type="submit" class="btn-zx">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let dragImgId = null;
        function dragStart(imgId) { dragImgId = imgId; }
        function dragOver(event) { event.preventDefault(); }

        let dragFromSlot = null;

        function dropOnSlot(event, slot) {
            event.preventDefault();
            if (!dragImgId) return;

            const inputDestino = document.getElementById('orden_slot_' + slot);
            if (!inputDestino) return;

            // Swap entre slot origen y destino para que el orden quede correcto.
            if (dragFromSlot && dragFromSlot !== slot) {
                const inputOrigen = document.getElementById('orden_slot_' + dragFromSlot);
                if (inputOrigen) {
                    const temp = inputDestino.value;
                    inputDestino.value = inputOrigen.value;
                    inputOrigen.value = temp;
                } else {
                    inputDestino.value = dragImgId;
                }
            } else {
                inputDestino.value = dragImgId;
            }
        }

        function previewImages(input) {
            const container = document.getElementById('preview-container');
            if (!container) return;

            container.innerHTML = '';
            const files = Array.from(input.files || []);
            const max = {{ 6 - $imagenes->count() }};

            if (files.length > max) {
                alert('Solo puedes subir ' + max + ' imagen(es) más.');
                input.value = '';
                return;
            }

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.style.cssText = 'position:relative;';
                    div.innerHTML = `<img src="${e.target.result}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:2px solid #28666e;">`;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>

    @endauth
</x-app-layout>

