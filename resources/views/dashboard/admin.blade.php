<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Administrador
        </h2>
    </x-slot>

    {{-- Bootstrap + FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div class="admin-page">
        <div class="admin-shell">
            <h1 class="admin-title">Panel de Administrador</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-users fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Empleados</h3>
                        <a href="{{ route('employees.index') }}" class="btn btn-light mt-auto">Gestionar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-tags fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Categorías</h3>
                        <a href="{{ route('categorias.index') }}" class="btn btn-light mt-auto">Ver categorías</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-stethoscope fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Equipos Médicos</h3>
                        <a href="{{ route('productos.index') }}" class="btn btn-light mt-auto">Administrar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-palette fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Colores</h3>
                        <a href="{{ route('colors.index') }}" class="btn btn-light mt-auto">Gestionar Colores</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-tools fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Mantenimiento y Reparación</h3>
                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-light mt-auto">Gestionar servicios</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-chart-line fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Productos más vendidos</h3>
                        <a href="{{ route('top-products.index') }}" class="btn btn-light mt-auto">Gestionar productos</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-star fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Reseñas</h3>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-light mt-auto">Gestionar Reseñas</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-images fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Imágenes Sitio</h3>
                        <a href="{{ route('imagenes.index') }}" class="btn btn-light mt-auto">Gestionar Imágenes</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-images fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Imágenes Mantenimiento</h3>
                        <a href="{{ route('admin.mantenimientos.imagenes.edit') }}" class="btn btn-light mt-auto">Gestionar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card h-100 d-flex flex-column">
                        <i class="fas fa-percent fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Promociones</h3>
                        <button type="button" class="btn btn-light mt-auto" data-bs-toggle="modal" data-bs-target="#modalPromocionesAdmin">
                            Gestionar Promociones
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .admin-page {
            min-height: calc(100vh - 160px);
            padding: 28px 15px;
            background: #f3f5f6;
            position: relative;
            z-index: 50;
        }
        .admin-shell {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,.12);
        }
        .admin-title {
            text-align: center;
            font-weight: 900;
            color: #234d50;
            margin: 5px 0 18px;
        }

        .bg-custom { background-color: #28666e; border-radius: 15px; border: 0; }
        .text-light { color: #fedc97 !important; }

        .btn.btn-light {
            background-color: #fedc97;
            color: #28666e;
            border: none;
            font-size: 1.05em;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 800;
        }
        .btn.btn-light:hover { background-color: #ffffff; color: #234d50; }

        .admin-card { transition: transform .2s ease, box-shadow .2s ease; }
        .admin-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(0,0,0,.18);
        }

        .icon-accent {
            color: #fedc97 !important;
            transition: transform 0.2s ease-in-out;
        }
        .admin-card:hover .icon-accent { transform: scale(1.08); }
    </style>

    {{-- ===================== MODAL PRINCIPAL: PROMOCIONES ===================== --}}
    <div class="modal fade" id="modalPromocionesAdmin" tabindex="-1" aria-labelledby="modalPromocionesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content promo-modal-shell">
                <div class="modal-header promo-modal-header">
                    <h5 class="modal-title" id="modalPromocionesLabel">
                        <i class="fas fa-percent me-2"></i> Gestionar Promociones
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-center promo-subtitle mb-4">Selecciona una promoción para editar su nombre e imagen.</p>
                    <div class="row g-4">
                        @for($n = 1; $n <= 4; $n++)
                        @php $promo = \App\Models\Promotion::find($n); @endphp
                        <div class="col-6 col-md-3">
                            <div class="promo-select-card" onclick="abrirModalPromo({{ $n }})" data-bs-toggle="modal" data-bs-target="#modalPromo{{ $n }}">
                                <div class="promo-card-img-wrap">
                                    @if($promo && $promo->imagen_url)
                                        <img src="{{ asset($promo->imagen_url) }}" alt="Promo {{ $n }}">
                                    @else
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    @endif
                                </div>
                                <div class="promo-card-label">Promoción {{ $n }}</div>
                                <div class="promo-card-name">{{ $promo->nombre ?? 'Sin nombre' }}</div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    @for($n = 1; $n <= 4; $n++)
    @php $promo = \App\Models\Promotion::find($n); @endphp
    <div class="modal fade" id="modalPromo{{ $n }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content promo-modal-shell">
                <div class="modal-header promo-modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Editar Promoción {{ $n }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <div class="promo-edit-img-wrap">
                            <img id="previewPromo{{ $n }}"
                                 src="{{ $promo && $promo->imagen_url ? asset($promo->imagen_url) : '' }}"
                                 alt="Preview"
                                 style="{{ $promo && $promo->imagen_url ? '' : 'display:none' }}">
                        </div>
                        <label class="btn btn-sm" style="background:#e8f4f5;color:#28666e;font-weight:700;border-radius:8px;">
                            <i class="fas fa-upload me-1"></i> Cambiar imagen
                            <input type="file" id="imagenPromo{{ $n }}" accept="image/*" style="display:none"
                                   onchange="previewPromoImg(event, {{ $n }})">
                        </label>
                        <div class="w-100">
                            <label class="promo-field-label mb-1 d-block">Nombre de la promoción</label>
                            <input type="text" id="nombrePromo{{ $n }}" class="form-control promo-input"
                                   value="{{ $promo->nombre ?? '' }}" placeholder="Ej: Promoción verano">
                        </div>
                        <div id="feedbackPromo{{ $n }}" style="display:none;border-radius:8px;padding:8px 14px;width:100%;font-size:0.88rem;font-weight:600;"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-3 px-4 gap-2">
                    <button class="btn promo-btn-back" onclick="volverAlPrincipal({{ $n }})">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </button>
                    <button id="btnGuardarPromo{{ $n }}" class="btn promo-btn-save" onclick="guardarPromo({{ $n }})">
                        <i class="fas fa-save me-1"></i> Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endfor

    <style>
        .promo-modal-shell { border-radius: 18px; overflow: hidden; border: 0; box-shadow: 0 20px 50px rgba(0,0,0,0.2); }
        .promo-modal-header { background: #28666e; color: #fedc97; border-bottom: none; padding: 18px 24px; }
        .promo-modal-header .modal-title { font-weight: 800; font-size: 1.1rem; }
        .promo-modal-header .btn-close-white { filter: invert(1) brightness(2); opacity: .85; }
        .promo-subtitle { color: #6c757d; font-size: 0.92rem; }
        .promo-select-card {
            background: #f8fafb; border: 2px solid #e2e8ea; border-radius: 14px;
            overflow: hidden; cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; text-align: center;
        }
        .promo-select-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(40,102,110,0.18); border-color: #28666e; }
        .promo-card-img-wrap { height: 110px; background: #fff; display: flex; align-items: center; justify-content: center; padding: 10px; border-bottom: 1px solid #eef0f2; }
        .promo-card-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .promo-card-label { background: #28666e; color: #fedc97; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; padding: 4px 0; }
        .promo-card-name { font-size: 0.8rem; color: #444; font-weight: 600; padding: 6px 10px 8px; }
        .promo-edit-img-wrap { width: 200px; height: 150px; border-radius: 12px; border: 2px dashed #c5d4d6; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f4f8f9; }
        .promo-edit-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .promo-field-label { font-weight: 700; color: #28666e; font-size: 0.88rem; }
        .promo-input { border-radius: 10px; border: 1.5px solid #c5d4d6; font-size: 0.92rem; padding: 10px 14px; }
        .promo-input:focus { border-color: #28666e; box-shadow: 0 0 0 3px rgba(40,102,110,0.12); outline: none; }
        .promo-btn-back { background: #f0f3f4; color: #28666e; border: 1.5px solid #c5d4d6; border-radius: 10px; font-weight: 700; padding: 9px 20px; }
        .promo-btn-back:hover { background: #e2e8ea; }
        .promo-btn-save { background: #28666e; color: #fedc97; border: none; border-radius: 10px; font-weight: 800; padding: 9px 22px; }
        .promo-btn-save:hover { background: #1a4a50; color: #fff; }
    </style>

    <script>
        function previewPromoImg(event, n) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('previewPromo' + n);
                if (img) { img.src = e.target.result; img.style.display = ''; }
            };
            reader.readAsDataURL(file);
        }

        function guardarPromo(n) {
            const nombre    = document.getElementById('nombrePromo' + n)?.value?.trim();
            const fileInput = document.getElementById('imagenPromo' + n);
            const feedback  = document.getElementById('feedbackPromo' + n);
            const btn       = document.getElementById('btnGuardarPromo' + n);

            if (!nombre) { mostrarFeedback(feedback, 'El nombre es obligatorio.', false); return; }

            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('nombre', nombre);
            if (fileInput?.files?.[0]) formData.append('imagen', fileInput.files[0]);

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';

            fetch('{{ url("employees/promociones") }}/' + n, {
                method: 'POST', body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => {
                if (res.ok || res.redirected) {
                    mostrarFeedback(feedback, '✅ Promoción ' + n + ' actualizada correctamente.', true);
                    btn.innerHTML = '<i class="fas fa-check me-1"></i> Guardado';
                    const cardName = document.querySelector('#modalPromocionesAdmin .col-6:nth-child(' + n + ') .promo-card-name');
                    if (cardName) cardName.textContent = nombre;
                } else {
                    mostrarFeedback(feedback, '❌ Error al guardar. Intenta de nuevo.', false);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save me-1"></i> Guardar cambios';
                }
            })
            .catch(() => {
                mostrarFeedback(feedback, '❌ Error de conexión.', false);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save me-1"></i> Guardar cambios';
            });
        }

        function mostrarFeedback(el, msg, exito) {
            el.textContent = msg; el.style.display = 'block';
            el.style.background = exito ? '#d1fae5' : '#fee2e2';
            el.style.color      = exito ? '#065f46' : '#991b1b';
        }

        function volverAlPrincipal(n) {
            const modalInd = bootstrap.Modal.getInstance(document.getElementById('modalPromo' + n));
            if (modalInd) modalInd.hide();
            setTimeout(function () {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                const modalPrincipal = new bootstrap.Modal(document.getElementById('modalPromocionesAdmin'));
                modalPrincipal.show();
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.modal').forEach(function (modal) {
                modal.addEventListener('hidden.bs.modal', function () {
                    if (!document.querySelector('.modal.show')) {
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }
                });
            });
        });
    </script>

    @if(session('success'))
        <script>alert(@json(session('success')));</script>
    @endif
</x-app-layout>