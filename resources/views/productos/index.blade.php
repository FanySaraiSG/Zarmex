<x-app-layout>
@auth('employee')

<div class="zx-wrapper">

    {{-- HEADER --}}
    <div class="zx-header">
        <a class="btn-back" href="{{ route('admin.dashboard') }}">← Regresar</a>
        <div class="zx-header-center">
            <h1 class="zx-title">Productos</h1>
            <p class="zx-subtitle">Administra y organiza tus productos por categoría</p>
        </div>
        <a class="btn-add" href="{{ route('productos.create') }}">+ Añadir Producto</a>
    </div>

    {{-- LISTA DE CATEGORÍAS --}}
    <div class="zx-card-list">
        @forelse ($categorias as $categoria)

        {{-- Wrapper por categoría --}}
        <div class="zx-categoria-grupo">

            {{-- Card de categoría --}}
            <div class="zx-card" id="cat-{{ $categoria->id_categoria }}">

                <div class="zx-card-icon">🏷️</div>

                <div class="zx-card-info">
                    <span class="zx-card-name">{{ $categoria->nombre }}</span>
                    <span class="zx-badge-count">{{ $categoria->productos_count }} productos</span>
                </div>

                <div class="zx-card-actions">
                    <button type="button"
                            class="btn-ver"
                            onclick="toggleProductos('{{ $categoria->id_categoria }}', this)">
                        Ver todos <span class="arrow">▼</span>
                    </button>
                </div>

            </div>

            {{-- Panel de productos (oculto por defecto) --}}
            <div class="zx-productos-panel" id="panel-{{ $categoria->id_categoria }}">
                <div class="zx-productos-inner">

                    @if($categoria->productos->isEmpty())
                        <p class="zx-no-productos">Esta categoría no tiene productos aún.</p>
                    @else
                        <table class="zx-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Docs</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoria->productos as $i => $producto)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="zx-td-id">{{ $producto->id }}</td>
                                    <td class="zx-td-desc">{{ Str::limit($producto->descripcion, 80) }}</td>
                                    <td>
                                        @if($producto->imagen_url)
                                            <img src="{{ asset($producto->imagen_url) }}"
                                                 class="zx-thumb" alt="img">
                                        @else
                                            <span class="zx-no-img">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="zx-docs">
                                            @if($producto->doc1_url)
                                                <a class="btn-doc" href="{{ asset($producto->doc1_url) }}" target="_blank">Garantía</a>
                                            @endif
                                            @if($producto->doc2_url)
                                                <a class="btn-doc" href="{{ asset($producto->doc2_url) }}" target="_blank">Manual</a>
                                            @endif
                                            @if($producto->doc3_url)
                                                <a class="btn-doc" href="{{ asset($producto->doc3_url) }}" target="_blank">Ficha</a>
                                            @endif
                                            @if(!$producto->doc1_url && !$producto->doc2_url && !$producto->doc3_url)
                                                <span class="zx-no-img">—</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="zx-row-actions">
                                            <a href="{{ route('productos.edit', $producto->id) }}"
                                               class="btn-edit">✏️ Editar</a>
                                            <form action="{{ route('productos.destroy', $producto->id) }}"
                                                  method="POST" style="margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete"
                                                        onclick="return confirm('¿Eliminar este producto?')">
                                                    🗑 Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>

        </div>
        @empty
        <div class="zx-empty">No hay categorías registradas.</div>
        @endforelse
    </div>

</div>

<style>
*{ box-sizing: border-box; }

body{
    background: #f0f2f5;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

nav{ background-color: inherit !important; }

header, footer, .whatsapp, #whatsapp, .btn-whatsapp{ display: none !important; }

/* ── Wrapper ──────────────────────────────── */
.zx-wrapper{
    max-width: 1060px;
    margin: 0 auto;
    padding: 32px 20px 60px;
}

/* ── Header ───────────────────────────────── */
.zx-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.zx-header-center{ text-align: center; flex: 1; }
.zx-title{ font-size: 28px; font-weight: 800; color: #1a1a2e; margin: 0 0 4px; }
.zx-subtitle{ font-size: 13px; color: #6b7280; margin: 0; }

/* ── Botones header ───────────────────────── */
.btn-back{
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 20px;
    border: 1.5px solid #d1d5db; border-radius: 10px;
    background: #fff; color: #374151;
    font-weight: 600; font-size: 14px;
    text-decoration: none; transition: .18s; white-space: nowrap;
}
.btn-back:hover{ background: #f9fafb; border-color: #9ca3af; color: #111; transform: translateY(-1px); }

.btn-add{
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 22px;
    background: #1a5c38; color: #fff;
    border-radius: 10px; font-weight: 700; font-size: 14px;
    text-decoration: none; white-space: nowrap;
    box-shadow: 0 4px 14px rgba(26,92,56,.25); transition: .18s;
}
.btn-add:hover{ background: #145030; color: #fff; transform: translateY(-1px); }

/* ── Lista de categorías ──────────────────── */
.zx-card-list{ display: flex; flex-direction: column; gap: 10px; }

/* ── Grupo categoría ──────────────────────── */
.zx-categoria-grupo{ display: flex; flex-direction: column; }

/* ── Card categoría ───────────────────────── */
.zx-card{
    display: flex; align-items: center; gap: 18px;
    background: #fff;
    border-radius: 16px;
    padding: 15px 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #e5e7eb;
    transition: box-shadow .18s, border-radius .25s;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}
.zx-card.open{
    border-radius: 16px 16px 0 0;
    border-bottom-color: transparent;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

/* ── Ícono ────────────────────────────────── */
.zx-card-icon{
    width: 48px; height: 48px;
    border-radius: 12px;
    background: #d1fae5;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 21px;
}

/* ── Info categoría ───────────────────────── */
.zx-card-info{
    flex: 1; min-width: 140px;
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
}
.zx-card-name{ font-size: 16px; font-weight: 700; color: #111827; }
.zx-badge-count{
    font-size: 12px; font-weight: 600;
    background: #dcfce7; color: #166534;
    border-radius: 20px; padding: 3px 11px;
}

/* ── Botón Ver todos ──────────────────────── */
.zx-card-actions{ display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

.btn-ver{
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 18px;
    border: 1.5px solid #d1d5db; border-radius: 9px;
    color: #374151; background: #fff;
    font-weight: 600; font-size: 13.5px;
    cursor: pointer; transition: .15s; white-space: nowrap;
}
.btn-ver:hover{ background: #f9fafb; border-color: #9ca3af; }
.btn-ver .arrow{ display: inline-block; transition: transform .25s; font-size: 11px; }
.btn-ver.active .arrow{ transform: rotate(180deg); }

/* ── Panel de productos ───────────────────── */
.zx-productos-panel{
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows .3s ease;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 16px 16px;
    overflow: hidden;
}
.zx-productos-panel.open{
    grid-template-rows: 1fr;
    box-shadow: 0 6px 18px rgba(0,0,0,.07);
}
.zx-productos-inner{
    min-height: 0;
    overflow: hidden;
    padding: 0 20px;
    transition: padding .3s ease;
}
.zx-productos-panel.open .zx-productos-inner{
    padding: 16px 20px 20px;
}

/* ── Tabla productos ──────────────────────── */
.zx-table{
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}
.zx-table thead th{
    background: #1a5c38;
    color: #fff;
    padding: 10px 12px;
    text-align: left;
    font-weight: 700;
    font-size: 12.5px;
    letter-spacing: .02em;
}
.zx-table thead th:first-child{ border-radius: 10px 0 0 0; }
.zx-table thead th:last-child{ border-radius: 0 10px 0 0; }

.zx-table tbody tr{
    border-bottom: 1px solid #f0f0f0;
    transition: background .12s;
}
.zx-table tbody tr:last-child{ border-bottom: none; }
.zx-table tbody tr:hover{ background: #f9fafb; }
.zx-table tbody td{ padding: 10px 12px; vertical-align: middle; color: #374151; }

.zx-td-id{ font-family: monospace; font-size: 12px; color: #6b7280; }
.zx-td-desc{ max-width: 260px; }

.zx-thumb{
    width: 46px; height: 46px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}
.zx-no-img{ color: #d1d5db; }

/* ── Docs dentro de tabla ─────────────────── */
.zx-docs{ display: flex; gap: 5px; flex-wrap: wrap; }
.btn-doc{
    font-size: 11.5px; font-weight: 600;
    padding: 4px 10px;
    border-radius: 7px;
    border: 1.5px solid #d1d5db;
    color: #374151; background: #fff;
    text-decoration: none; transition: .13s;
}
.btn-doc:hover{ background: #f0fdf4; border-color: #6ee7b7; color: #065f46; }

/* ── Acciones por fila ────────────────────── */
.zx-row-actions{ display: flex; gap: 6px; align-items: center; }
.zx-row-actions form{ display: contents; }

.btn-edit{
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 14px;
    border: 1.5px solid #3b82f6; border-radius: 8px;
    color: #3b82f6; background: #fff;
    font-weight: 700; font-size: 12.5px;
    text-decoration: none; transition: .14s; white-space: nowrap;
}
.btn-edit:hover{ background: #eff6ff; color: #2563eb; border-color: #2563eb; }

.btn-delete{
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 14px;
    border: 1.5px solid #ef4444; border-radius: 8px;
    color: #ef4444; background: transparent;
    font-weight: 700; font-size: 12.5px;
    text-decoration: none; transition: .14s; white-space: nowrap;
}
.btn-delete:hover{ background: #fef2f2; color: #dc2626; border-color: #dc2626; }

/* ── Sin productos ────────────────────────── */
.zx-no-productos{
    text-align: center; color: #9ca3af;
    font-size: 14px; padding: 24px 0;
}

/* ── Empty state ──────────────────────────── */
.zx-empty{
    text-align: center; color: #9ca3af; font-size: 15px;
    padding: 40px; background: #fff;
    border-radius: 16px; border: 1px dashed #e5e7eb;
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 640px){
    .zx-header{ flex-direction: column; align-items: stretch; text-align: center; }
    .zx-card{ gap: 12px; }
    .zx-card-info{ width: 100%; }
    .zx-table{ font-size: 12px; }
}
</style>

<script>
function toggleProductos(id, btn) {
    const panel = document.getElementById('panel-' + id);
    const card  = document.getElementById('cat-' + id);
    const isOpen = panel.classList.contains('open');

    // Cerrar todos los demás
    document.querySelectorAll('.zx-productos-panel.open').forEach(p => {
        p.classList.remove('open');
    });
    document.querySelectorAll('.zx-card.open').forEach(c => {
        c.classList.remove('open');
    });
    document.querySelectorAll('.btn-ver.active').forEach(b => {
        b.classList.remove('active');
    });

    // Abrir/cerrar el actual
    if (!isOpen) {
        panel.classList.add('open');
        card.classList.add('open');
        btn.classList.add('active');

        // Scroll suave hacia el panel
        setTimeout(() => {
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }
}
</script>

@if(session('success'))
<script>alert("{{ session('success') }}");</script>
@endif

@endauth
</x-app-layout>