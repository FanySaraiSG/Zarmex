<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Administrador
        </h2>
    </x-slot>
    {{-- Bootstrap + FontAwesome: lo ideal es ponerlos en el layout, pero aquí funciona --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div class="admin-page">
        <div class="admin-shell">
            <h1 class="admin-title">Panel de Administrador</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-users fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Empleados</h3>
                        <a href="{{ route('employees.index') }}" class="btn btn-light mt-2">Gestionar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-tags fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Categorías</h3>
                        <a href="{{ route('categorias.index') }}" class="btn btn-light mt-2">Ver categorías</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-stethoscope fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Equipos Médicos</h3>
                        <a href="{{ route('productos.index') }}" class="btn btn-light mt-2">Administrar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-palette fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Colores</h3>
                        <a href="{{ route('colors.index') }}" class="btn btn-light mt-2">Gestionar Colores</a>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-tools fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Mantenimiento y Reparación</h3>
                        <a href="/mantenimientos" class="btn btn-light mt-2">Gestionar servicios</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-chart-line fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Productos más vendidos</h3>
                        <a href="{{ route('top-products.index') }}" class="btn btn-light mt-2">Gestionar productos</a>
                    </div>
                </div>
                <div class="col">
    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
        <i class="fas fa-star fa-4x icon-accent"></i>
        <h3 class="text-light mt-3">Reseñas</h3>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-light mt-2">
            Gestionar Reseñas
        </a>
    </div>
</div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-images fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Imágenes Sitio</h3>
                        <a href="{{ route('imagenes.index') }}" class="btn btn-light mt-2">Gestionar Imágenes</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-percent fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Promociones</h3>
                        <button type="button" class="btn btn-light mt-2" data-bs-toggle="modal" data-bs-target="#modalPromocionesAdmin">
                            Gestionar Promociones
                        </button>
                    </div>
                </div>

            </div>
       </div>
    </div>

    <style>
        .admin-page{
            min-height: calc(100vh - 160px);
            padding: 28px 15px;
            background: #f3f5f6;
            position: relative;
            z-index: 50;
        }
        .admin-shell{
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,.12);
        }
        .admin-title{
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

        .admin-card{ transition: transform .2s ease, box-shadow .2s ease; }
        .admin-card:hover{
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(0,0,0,.18);
        }

        .icon-accent{
            color: #fedc97 !important;
            transition: transform 0.2s ease-in-out;
        }
        .admin-card:hover .icon-accent{ transform: scale(1.08); }
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

                        {{-- PROMO 1 --}}
                        <div class="col-6 col-md-3">
                            <div class="promo-select-card" data-bs-toggle="modal" data-bs-target="#modalPromo1" data-bs-dismiss="modal">
                                <div class="promo-card-img-wrap">
                                    @php $promo1 = \App\Models\Promocion::find(1); @endphp
                                    <img src="{{ $promo1?->imagen_url ? asset($promo1->imagen_url) : asset('imagenes/promo-placeholder.png') }}" alt="Promoción 1">
                                </div>
                                <div class="promo-card-label">Promoción 1</div>
                                <div class="promo-card-name text-truncate">{{ $promo1?->nombre ?? 'Sin nombre' }}</div>
                            </div>
                        </div>

                        {{-- PROMO 2 --}}
                        <div class="col-6 col-md-3">
                            <div class="promo-select-card" data-bs-toggle="modal" data-bs-target="#modalPromo2" data-bs-dismiss="modal">
                                <div class="promo-card-img-wrap">
                                    @php $promo2 = \App\Models\Promocion::find(2); @endphp
                                    <img src="{{ $promo2?->imagen_url ? asset($promo2->imagen_url) : asset('imagenes/promo-placeholder.png') }}" alt="Promoción 2">
                                </div>
                                <div class="promo-card-label">Promoción 2</div>
                                <div class="promo-card-name text-truncate">{{ $promo2?->nombre ?? 'Sin nombre' }}</div>
                            </div>
                        </div>

                        {{-- PROMO 3 --}}
                        <div class="col-6 col-md-3">
                            <div class="promo-select-card" data-bs-toggle="modal" data-bs-target="#modalPromo3" data-bs-dismiss="modal">
                                <div class="promo-card-img-wrap">
                                    @php $promo3 = \App\Models\Promocion::find(3); @endphp
                                    <img src="{{ $promo3?->imagen_url ? asset($promo3->imagen_url) : asset('imagenes/promo-placeholder.png') }}" alt="Promoción 3">
                                </div>
                                <div class="promo-card-label">Promoción 3</div>
                                <div class="promo-card-name text-truncate">{{ $promo3?->nombre ?? 'Sin nombre' }}</div>
                            </div>
                        </div>

                        {{-- PROMO 4 --}}
                        <div class="col-6 col-md-3">
                            <div class="promo-select-card" data-bs-toggle="modal" data-bs-target="#modalPromo4" data-bs-dismiss="modal">
                                <div class="promo-card-img-wrap">
                                    @php $promo4 = \App\Models\Promocion::find(4); @endphp
                                    <img src="{{ $promo4?->imagen_url ? asset($promo4->imagen_url) : asset('imagenes/promo-placeholder.png') }}" alt="Promoción 4">
                                </div>
                                <div class="promo-card-label">Promoción 4</div>
                                <div class="promo-card-name text-truncate">{{ $promo4?->nombre ?? 'Sin nombre' }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== MODALES INDIVIDUALES DE CADA PROMOCIÓN ===================== --}}
    @for($n = 1; $n <= 4; $n++)
    @php $promoItem = \App\Models\Promocion::find($n); @endphp
    <div class="modal fade" id="modalPromo{{ $n }}" tabindex="-1" aria-labelledby="modalPromo{{ $n }}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content promo-modal-shell">
                <div class="modal-header promo-modal-header">
                    <h5 class="modal-title" id="modalPromo{{ $n }}Label">
                        <i class="fas fa-edit me-2"></i> Editar Promoción {{ $n }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">

{{-- Temporal: ver qué URL genera --}}
{{ route('promociones.update', $n) }}

                    <form action="{{ route('promociones.update', $n) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                       

                        {{-- Vista previa de imagen --}}
                        <div class="text-center mb-4">
                            <div class="promo-edit-img-wrap mx-auto">
                                <img id="previewPromo{{ $n }}"
                                     src="{{ $promoItem?->imagen_url ? asset($promoItem->imagen_url) : asset('imagenes/promo-placeholder.png') }}"
                                     alt="Vista previa">
                            </div>
                        </div>

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label class="form-label promo-field-label">
                                <i class="fas fa-tag me-1"></i> Nombre de la promoción
                            </label>
                            <input
                                type="text"
                                name="nombre"
                                class="form-control promo-input"
                                value="{{ $promoItem?->nombre ?? '' }}"
                                placeholder="Ej: 20% de descuento en equipos"
                                maxlength="120"
                                required>
                        </div>

                        {{-- Imagen --}}
                        <div class="mb-4">
                            <label class="form-label promo-field-label">
                                <i class="fas fa-image me-1"></i> Imagen
                            </label>
                            <input
                                type="file"
                                name="imagen"
                                class="form-control promo-input"
                                accept="image/*"
                                onchange="previewPromoImg(event, {{ $n }})">
                            <small class="text-muted">Formatos: JPG, PNG, WEBP. Máx. 2 MB.</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <button type="button"
                                    class="btn promo-btn-back"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalPromocionesAdmin"
                                    data-bs-dismiss="modal">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </button>
                            <button type="submit" class="btn promo-btn-save">
                                <i class="fas fa-save me-1"></i> Guardar cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @endfor

    {{-- ===================== ESTILOS PROMOCIONES ===================== --}}
    <style>
        /* Shell del modal */
        .promo-modal-shell { border-radius: 18px; overflow: hidden; border: 0; box-shadow: 0 20px 50px rgba(0,0,0,0.2); }

        /* Header */
        .promo-modal-header { background: #28666e; color: #fedc97; border-bottom: none; padding: 18px 24px; }
        .promo-modal-header .modal-title { font-weight: 800; font-size: 1.1rem; }
        .promo-modal-header .btn-close-white { filter: invert(1) brightness(2); opacity: .85; }

        /* Subtítulo */
        .promo-subtitle { color: #6c757d; font-size: 0.92rem; }

        /* Tarjetas de selección */
        .promo-select-card {
            background: #f8fafb;
            border: 2px solid #e2e8ea;
            border-radius: 14px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            text-align: center;
        }
        .promo-select-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(40,102,110,0.18);
            border-color: #28666e;
        }
        .promo-card-img-wrap {
            height: 110px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-bottom: 1px solid #eef0f2;
        }
        .promo-card-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .promo-card-label { background: #28666e; color: #fedc97; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; padding: 4px 0; }
        .promo-card-name { font-size: 0.8rem; color: #444; font-weight: 600; padding: 6px 10px 8px; }

        /* Vista previa imagen en edición */
        .promo-edit-img-wrap {
            width: 200px;
            height: 150px;
            border-radius: 12px;
            border: 2px dashed #c5d4d6;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f8f9;
        }
        .promo-edit-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; }

        /* Inputs */
        .promo-field-label { font-weight: 700; color: #28666e; font-size: 0.88rem; }
        .promo-input { border-radius: 10px; border: 1.5px solid #c5d4d6; font-size: 0.92rem; padding: 10px 14px; }
        .promo-input:focus { border-color: #28666e; box-shadow: 0 0 0 3px rgba(40,102,110,0.12); outline: none; }

        /* Botones de acción */
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
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>

    @if(session('success'))
        <script>alert(@json(session('success')));</script>
    @endif
</x-app-layout>