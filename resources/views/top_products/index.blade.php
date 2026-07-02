<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<title>Productos Destacados</title>
<style>
:root {
    --panel-white:        #ffffff;
    --table-header-green: #e6f4ea;
    --table-hover-green:  #f1f9f5;
    --mint-accent:        #198754;
    --forest-text:        #0f4c3a;
    --border-light:       #dee2e6;
}

body {
    background: linear-gradient(135deg, #a7f3d0 0%, #86efac 100%);
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: var(--forest-text);
    min-height: 100vh;
}

header, footer, .whatsapp, #whatsapp { display: none !important; }

.panel-box {
    background: var(--panel-white);
    border: 1px solid var(--border-light);
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.panel-title { font-size: 1.75rem; font-weight: 700; color: var(--forest-text); }

/* Sección tabs */
.section-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }

.section-tab {
    padding: 8px 20px;
    border-radius: 50px;
    border: 1px solid #198754;
    background: transparent;
    color: var(--forest-text);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9rem;
}
.section-tab:hover   { background: #e6f4ea; }
.section-tab.active  { background: #198754; color: #fff; border-color: #198754; }

/* Tabla */
.green-table-responsive { border-radius: 10px; overflow: hidden; border: 1px solid var(--border-light); }

.table-green { margin-bottom: 0; background-color: var(--panel-white) !important; color: var(--forest-text); vertical-align: middle; }

.table-green thead th {
    background-color: var(--table-header-green) !important;
    color: var(--forest-text);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-light);
}

.table-green tbody tr { border-bottom: 1px solid var(--border-light); background-color: var(--panel-white) !important; transition: background-color 0.2s; }
.table-green tbody tr:hover { background-color: var(--table-hover-green) !important; }
.table-green tbody td { padding: 12px 16px; color: var(--forest-text); background-color: transparent !important; }

.product-thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-light); }
.product-thumb-placeholder { width: 48px; height: 48px; border-radius: 8px; background: #e6f4ea; display:flex; align-items:center; justify-content:center; color:#adb5bd; font-size: 1.2rem; }

/* Botones */
.btn-mint { background-color: #198754; color: #fff; font-weight: 500; border-radius: 6px; padding: 8px 16px; border: none; white-space: nowrap; transition: all 0.2s; }
.btn-mint:hover { background-color: #146c43; color: white; }

.btn-outline-green { background: transparent; color: var(--forest-text); border: 1px solid #198754; border-radius: 6px; font-weight: 500; padding: 8px 16px; transition: all 0.2s; }
.btn-outline-green:hover { background: #e6f4ea; color: var(--forest-text); }

.btn-table-delete { background: transparent; color: #dc2626; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 6px; transition: all 0.2s; }
.btn-table-delete:hover { background: #dc2626; color: white; }

/* Buscador de productos */
.search-wrap { position: relative; }
.search-results {
    position: absolute;
    top: 100%;
    left: 0; right: 0;
    background: #fff;
    border: 1px solid var(--border-light);
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    z-index: 999;
    max-height: 280px;
    overflow-y: auto;
    display: none;
}
.search-result-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    cursor: pointer;
    transition: background 0.15s;
    border-bottom: 1px solid #f0f0f0;
}
.search-result-item:last-child { border-bottom: none; }
.search-result-item:hover { background: var(--table-hover-green); }
.search-result-item img { width: 36px; height: 36px; object-fit: cover; border-radius: 6px; }
.search-result-item .item-name { font-size: 0.9rem; font-weight: 500; color: var(--forest-text); }

.table-input { background: #fff; color: var(--forest-text); border: 1px solid #ced4da; padding: 8px 12px; border-radius: 6px; font-size: 0.9rem; transition: all 0.2s; }
.table-input:focus { border-color: var(--mint-accent); box-shadow: 0 0 0 3px rgba(25,135,84,0.15); outline: none; }

/* Estado vacío */
.empty-state { text-align: center; padding: 40px 16px; color: #6c757d; }

/* Toast */
.toast-green-sync {
    position: fixed; bottom: 24px; right: 24px;
    background: #fff; color: var(--forest-text); border: 1px solid var(--mint-accent);
    padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1); z-index: 9999;
    opacity: 0; transform: translateY(10px); transition: all 0.3s;
    display: flex; align-items: center; gap: 10px; pointer-events: none;
}
.toast-green-sync.show { opacity: 1; transform: translateY(0); }

.badge-section { background: #e6f4ea; color: #198754; padding: 3px 10px; border-radius: 50px; font-size: 0.78rem; font-weight: 600; }

/* ===== Productos destacados: tabla responsive en celular ===== */
@media (max-width: 768px){

    .container{
        max-width:100% !important;
        padding-left:12px !important;
        padding-right:12px !important;
        margin-top:20px !important;
    }

    .panel-box{
        padding:16px 12px !important;
        overflow:hidden;
    }

    .panel-title{
        width:100%;
        text-align:center;
        font-size:1.35rem;
        line-height:1.2;
    }

    .green-table-responsive{
        width:100%;
        max-width:100%;
        overflow-x:auto !important;
        overflow-y:hidden;
        -webkit-overflow-scrolling:touch;
        border-radius:10px;
    }

    .table-green{
        min-width:720px;
        width:720px;
    }

    .table-green thead{
        display:table-header-group !important;
    }

    .table-green tbody{
        display:table-row-group !important;
    }

    .table-green tr{
        display:table-row !important;
    }

    .table-green th,
    .table-green td{
        display:table-cell !important;
        white-space:nowrap;
        vertical-align:middle;
        font-size:.82rem;
        padding:10px 12px;
    }

    .product-thumb,
    .product-thumb-placeholder{
        width:42px;
        height:42px;
    }

    .btn-table-delete{
        width:auto;
        padding:7px 11px;
        font-size:.82rem;
    }

    .green-table-responsive::after{
        content:"← Desliza para ver toda la tabla →";
        display:block;
        text-align:center;
        font-size:12px;
        color:#6c757d;
        padding:8px 0 2px;
    }
}

/* ===== Productos destacados: vista móvil para tabla de eliminar productos ===== */
@media (max-width: 768px){

    html,
    body{
        max-width:100%;
        overflow-x:hidden !important;
    }

    .container{
        width:100% !important;
        max-width:100% !important;
        padding-left:12px !important;
        padding-right:12px !important;
        margin-top:20px !important;
    }

    .panel-box{
        padding:16px 12px !important;
        border-radius:16px;
        overflow:hidden;
    }

    .panel-title{
        width:100%;
        text-align:center;
        font-size:1.35rem;
        line-height:1.2;
    }

    .section-tabs{
        flex-wrap:nowrap !important;
        overflow-x:auto !important;
        overflow-y:hidden !important;
        padding-bottom:8px;
        scrollbar-width:none;
    }

    .section-tabs::-webkit-scrollbar{
        display:none;
    }

    .section-tab{
        flex:0 0 auto;
        white-space:nowrap;
    }

    .search-wrap{
        width:100% !important;
        min-width:0 !important;
    }

    #buscarProducto{
        width:100% !important;
        min-width:0 !important;
    }

    /* Ocultar encabezado de tabla en móvil */
    .green-table-responsive{
        border:none !important;
        overflow:visible !important;
    }

    .table-green{
        display:block !important;
        width:100% !important;
        min-width:0 !important;
    }

    .table-green thead{
        display:none !important;
    }

    .table-green tbody{
        display:flex !important;
        flex-direction:column;
        gap:12px;
        width:100%;
    }

    .table-green tbody tr{
        display:grid !important;
        grid-template-columns:58px 1fr;
        gap:8px 12px;
        width:100%;
        background:#fff !important;
        border:1px solid #dee2e6 !important;
        border-radius:14px;
        padding:12px;
        box-shadow:0 4px 14px rgba(0,0,0,.06);
    }

    .table-green tbody td{
        display:block !important;
        padding:0 !important;
        border:none !important;
        background:transparent !important;
        white-space:normal !important;
    }

    /* Columna # */
    .table-green tbody td:nth-child(1){
        grid-column:1 / 2;
        grid-row:1 / 3;
        display:flex !important;
        align-items:center;
        justify-content:center;
        width:42px;
        height:42px;
        border-radius:50%;
        background:#e6f4ea !important;
        color:#198754 !important;
        font-weight:800;
        font-size:.85rem;
    }

    /* Imagen */
    .table-green tbody td:nth-child(2){
        grid-column:1 / 2;
        grid-row:2 / 4;
    }

    .product-thumb,
    .product-thumb-placeholder{
        width:54px !important;
        height:54px !important;
        border-radius:10px;
    }

    /* Nombre / ID producto */
    .table-green tbody td:nth-child(3){
        grid-column:2 / 3;
        grid-row:1 / 2;
        font-size:.9rem;
        font-weight:800;
        color:#198754;
        word-break:break-word;
    }

    /* Secciones */
    .table-green tbody td:nth-child(4){
        grid-column:2 / 3;
        grid-row:2 / 3;
        display:flex !important;
        flex-wrap:wrap;
        gap:5px;
    }

    .badge-section{
        display:inline-flex;
        width:max-content;
        font-size:.72rem;
        padding:4px 9px;
    }

    /* Acciones */
    .table-green tbody td:nth-child(5){
        grid-column:1 / 3;
        grid-row:4 / 5;
        text-align:center !important;
        margin-top:8px;
    }

    .btn-table-delete{
        width:100%;
        padding:10px 12px;
        font-size:.9rem;
        font-weight:800;
        border-radius:10px;
    }
}
</style>
</head>

<body>

@php
    $secciones      = $topProducts->pluck('section')->filter()->unique()->reject(fn($s) => strtolower($s) === 'todos')->values();
    $allProducts    = $products; // colección Producto::all() del controller
    $topProductsArr = $topProducts; // registros TopProduct con ->product
@endphp

<div class="container my-5">
    <div class="panel-box">

        {{-- Cabecera --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <h2 class="panel-title mb-0">
                <i class="bi bi-star-fill me-2" style="color:#198754; font-size:1.4rem;"></i>
                Productos Destacados
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-green">
                    <i class="bi bi-arrow-left-circle"></i> Volver al panel
                </a>
                <a href="{{ route('top-products.gestionar') }}" class="btn btn-outline-green">
                    <i class="bi bi-sliders"></i> Gestionar secciones
                </a>
            </div>
        </div>

        @if($secciones->isEmpty())
            {{-- Sin secciones --}}
            <div class="empty-state">
                <i class="bi bi-folder2-open" style="font-size:2.5rem; display:block; margin-bottom:12px; color:#adb5bd;"></i>
                <p class="mb-3">Aún no hay secciones creadas.</p>
                <a href="{{ route('top-products.gestionar') }}" class="btn btn-mint">
                    <i class="bi bi-plus-lg"></i> Crear primera sección
                </a>
            </div>
        @else

            {{-- Tabs de sección --}}
            <div class="section-tabs" id="sectionTabs">
                @foreach($secciones as $i => $sec)
                    <button class="section-tab {{ $i === 0 ? 'active' : '' }}"
                            data-section="{{ $sec }}">
                        {{ ucfirst($sec) }}
                    </button>
                @endforeach
            </div>

            {{-- Nombre sección activa + buscador --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
                <div>
                    <span class="fw-semibold" style="font-size:1.05rem;">
                        Productos en: <span id="labelSeccionActiva" class="badge-section">{{ ucfirst($secciones->first()) }}</span>
                    </span>
                    <span class="text-muted small ms-2" id="contadorProductos"></span>
                </div>

                {{-- Buscador para agregar productos --}}
                <div class="search-wrap" style="min-width: 300px;">
                    <div class="d-flex gap-2">
                        <input type="text"
                               id="buscarProducto"
                               class="table-input w-100"
                               placeholder="Buscar producto para agregar...">
                    </div>
                    <div class="search-results" id="searchResults"></div>
                </div>
            </div>

            {{-- Tabla de productos asignados --}}
            <div class="green-table-responsive table-responsive">
                <table class="table table-green">
                    <thead>
                        <tr>
                            <th style="width:6%">#</th>
                            <th style="width:8%">Imagen</th>
                            <th style="width:52%">Nombre del producto</th>
                            <th style="width:20%">Secciones</th>
                            <th style="width:14%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="productosTableBody"></tbody>
                </table>
            </div>

        @endif

    </div>
</div>

@if(!$secciones->isEmpty())

@php
    $jsAllProducts = $allProducts->map(fn($p) => [
        'id'         => $p->id,
        'codigo'     => $p->id,
        'nombre'     => $p->nombre,
        'imagen_url' => $p->imagen_url ?? null,
    ])->values();

    $jsTopEntries = $topProductsArr->map(fn($tp) => [
        'id'         => $tp->id,
        'product_id' => $tp->product_id,
        'section'    => $tp->section,
        'nombre'     => optional($tp->product)->nombre ?? '—',
        'imagen_url' => optional($tp->product)->imagen_url ?? null,
    ])->values();

    $jsPrimeraSeccion = $secciones->first();
@endphp

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Datos desde Blade ───────────────────────────────────────────────────
    const allProducts = @json($jsAllProducts);
    const topEntries  = @json($jsTopEntries);

    let seccionActiva = @json($jsPrimeraSeccion);
    let entriesLocal  = [...topEntries]; // copia local mutable

    // ── Toast ───────────────────────────────────────────────────────────────
    function toast(msg, error = false) {
        const t    = document.createElement('div');
        t.className = 'toast-green-sync';
        const icon  = error
            ? 'bi-x-circle-fill" style="color:#dc2626'
            : 'bi-check-circle-fill" style="color:#198754';
        t.innerHTML = `<i class="bi ${icon}; font-size:1.1rem;"></i> ${msg}`;
        document.body.appendChild(t);
        setTimeout(() => t.classList.add('show'), 50);
        setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 2400);
    }

    // ── Tabs ────────────────────────────────────────────────────────────────
    document.querySelectorAll('.section-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.section-tab').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            seccionActiva = this.dataset.section;
            document.getElementById('labelSeccionActiva').textContent =
                seccionActiva.charAt(0).toUpperCase() + seccionActiva.slice(1);
            document.getElementById('buscarProducto').value = '';
            document.getElementById('searchResults').style.display = 'none';
            renderTabla();
        });
    });

    // ── Render tabla ────────────────────────────────────────────────────────
    function renderTabla() {
        const tbody    = document.getElementById('productosTableBody');
        const contador = document.getElementById('contadorProductos');
        const filas    = entriesLocal.filter(e => e.section === seccionActiva);

        contador.textContent = `${filas.length} producto${filas.length !== 1 ? 's' : ''}`;
        tbody.innerHTML = '';

        if (filas.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5">
                <div class="empty-state">
                    <i class="bi bi-box-seam" style="font-size:2rem; display:block; margin-bottom:8px; color:#adb5bd;"></i>
                    No hay productos en esta sección. Usa el buscador para agregar.
                </div>
            </td></tr>`;
            return;
        }

        filas.forEach((entry, idx) => {
            // Secciones en las que aparece este producto
            const seccionesDelProducto = [...new Set(
                entriesLocal.filter(e => e.product_id === entry.product_id).map(e => e.section)
            )];

            const badgesSecciones = seccionesDelProducto
                .map(s => `<span class="badge-section me-1">${s.charAt(0).toUpperCase() + s.slice(1)}</span>`)
                .join('');

            const imgHtml = entry.imagen_url
                ? `<img src="${entry.imagen_url}" class="product-thumb" alt="${entry.nombre}">`
                : `<div class="product-thumb-placeholder"><i class="bi bi-image"></i></div>`;

            const tr = document.createElement('tr');
            tr.dataset.entryId = entry.id;
            tr.innerHTML = `
                <td class="fw-bold" style="color:#198754;">${idx + 1}</td>
                <td>${imgHtml}</td>
                <td>
    <span style="
        font-weight:700;
        color:#198754;
        font-size:14px;
        letter-spacing:.5px;
    ">
        ${entry.product_id}
    </span>
</td>
                <td>${badgesSecciones}</td>
                <td class="text-center">
                    <button class="btn btn-table-delete btn-quitar" title="Quitar de esta sección">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
            `;

            tr.querySelector('.btn-quitar').addEventListener('click', () => {
                quitarProducto(entry.id, entry.nombre, tr);
            });

            tbody.appendChild(tr);
        });
    }

    // ── Quitar producto de sección ──────────────────────────────────────────
    async function quitarProducto(topId, nombre, tr) {
        if (!confirm(`¿Quitar "${nombre}" de la sección "${seccionActiva}"?`)) return;

        try {
            const res = await fetch(`/employees/top-products/${topId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (data.success) {
                entriesLocal = entriesLocal.filter(e => e.id !== topId);
                tr.style.transition  = 'all 0.3s';
                tr.style.opacity     = '0';
                tr.style.background  = '#fde8e8';
                setTimeout(() => renderTabla(), 300);
                toast(`"${nombre}" quitado de la sección.`);
            } else {
                toast('No se pudo quitar el producto.', true);
            }
        } catch (e) {
            console.error(e);
            toast('Error de conexión.', true);
        }
    }

  // ─────────────────────────────────────────────────────────────
// BUSCADOR DE PRODUCTOS DEL CATÁLOGO
// ─────────────────────────────────────────────────────────────

const inputBuscar   = document.getElementById('buscarProducto');
const searchResults = document.getElementById('searchResults');

function renderProductosBusqueda(texto = '') {

    const q = texto.toLowerCase().trim();

    searchResults.innerHTML = '';

    const idsEnSeccion = new Set(
        entriesLocal
            .filter(e => e.section === seccionActiva)
            .map(e => e.product_id)
    );

    let productos = allProducts.filter(producto => {

        if (idsEnSeccion.has(producto.id)) {
            return false;
        }

        if (!q) {
            return true;
        }

        return (
            producto.nombre.toLowerCase().includes(q) ||
            producto.codigo.toLowerCase().includes(q)
        );
    });

    productos = productos.slice(0, 50);

    if (productos.length === 0) {

        searchResults.innerHTML = `
            <div class="search-result-item text-muted" style="cursor:default;">
                No se encontraron productos
            </div>
        `;

        searchResults.style.display = 'block';
        return;
    }

    productos.forEach(producto => {

        const item = document.createElement('div');
        item.className = 'search-result-item';

        const imgHtml = producto.imagen_url
            ? `<img src="${producto.imagen_url}" alt="${producto.nombre}">`
            : `
                <div style="
                    width:36px;
                    height:36px;
                    border-radius:6px;
                    background:#e6f4ea;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                ">
                    <i class="bi bi-image" style="color:#adb5bd;"></i>
                </div>
            `;

        item.innerHTML = `
            ${imgHtml}

            <div>
                <div style="
                    font-size:12px;
                    font-weight:700;
                    color:#198754;
                    line-height:1.2;
                ">
                    ${producto.codigo}
                </div>
        `;

        item.addEventListener('click', () => {
            agregarProducto(producto);
        });

        searchResults.appendChild(item);
    });

    searchResults.style.display = 'block';
}

// Mostrar toda la lista al hacer click
inputBuscar.addEventListener('focus', () => {
    renderProductosBusqueda();
});

// Filtrar mientras escribe
inputBuscar.addEventListener('input', function () {
    renderProductosBusqueda(this.value);
});

// Cerrar al hacer click fuera
document.addEventListener('click', (e) => {
    if (!e.target.closest('.search-wrap')) {
        searchResults.style.display = 'none';
    }
});
    // ── Agregar producto a sección ──────────────────────────────────────────
    async function agregarProducto(producto) {
        searchResults.style.display = 'none';
        inputBuscar.value = '';

        try {
            const res  = await fetch('/employees/top-products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: producto.id,
                    section:    seccionActiva
                })
            });
            const data = await res.json();

            if (data.success) {
                // Agregar a la lista local
                entriesLocal.push({
                    id:          data.data.id,
                    product_id:  producto.id,
                    section:     seccionActiva,
                    nombre:      producto.nombre,
                    imagen_url:  producto.imagen_url,
                });
                renderTabla();
                toast(`"${producto.nombre}" agregado a "${seccionActiva}".`);
            } else {
                toast(data.message ?? 'No se pudo agregar el producto.', true);
            }
        } catch (e) {
            console.error(e);
            toast('Error de conexión.', true);
        }
    }

    // ── Arranque ────────────────────────────────────────────────────────────
    renderTabla();
});
</script>
@endif

</body>
</html>
@endauth
</x-app-layout>