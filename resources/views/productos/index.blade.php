<x-app-layout>
@auth('employee')

<div class="zx-wrapper">

    {{-- HEADER --}}
    <div class="zx-header">
        <a class="btn-back" href="{{ route('admin.dashboard') }}">← Regresar</a>

        <div class="zx-header-center">
            <h1 class="zx-title">{{ $categoriaNombre }}</h1>
            <p class="zx-subtitle">Administra y organiza tus productos por categoría</p>
        </div>

        <a class="btn-add" href="{{ route('productos.create') }}">+ Añadir Producto</a>
    </div>

    {{-- CARDS LIST --}}
    <div class="zx-card-list">
        @foreach ($productos as $producto)
        <div class="zx-card">

            {{-- Ícono / Imagen --}}
            <div class="zx-card-icon">
                @if($producto->imagen_url)
                    <img src="{{ asset($producto->imagen_url) }}" alt="img">
                @else
                    <span class="zx-icon-placeholder">📦</span>
                @endif
            </div>

            {{-- Info principal --}}
            <div class="zx-card-info">
                <span class="zx-card-name">{{ Str::limit($producto->descripcion, 60) }}</span>
                <span class="zx-card-meta">
                    <span class="zx-badge">ID #{{ $producto->id }}</span>
                    <span class="zx-badge">Stock: {{ $producto->stock }}</span>
                    <span class="zx-badge">${{ number_format($producto->precio, 2) }}</span>
                    @if($producto->categoria)
                        <span class="zx-badge zx-badge-cat">{{ $producto->categoria->nombre }}</span>
                    @endif
                </span>
            </div>

            {{-- Docs --}}
            <div class="zx-card-docs">
                @if($producto->doc1_url)
                    <a class="btn-doc" href="{{ asset($producto->doc1_url) }}" target="_blank">Garantía</a>
                @endif
                @if($producto->doc2_url)
                    <a class="btn-doc" href="{{ asset($producto->doc2_url) }}" target="_blank">Manual</a>
                @endif
                @if($producto->doc3_url)
                    <a class="btn-doc" href="{{ asset($producto->doc3_url) }}" target="_blank">Ficha</a>
                @endif
            </div>

            {{-- Acciones --}}
            <div class="zx-card-actions">
                <a href="{{ route('productos.edit', $producto->id) }}" class="btn-edit">
                    ✏️ Editar
                </a>
                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete"
                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                        🗑 Eliminar
                    </button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

</div>

<style>
/* ── Reset / Base ────────────────────────────────── */
*{ box-sizing: border-box; }

body{
    background: #f0f2f5;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

nav{ background-color: inherit !important; }

header,
footer,
.whatsapp,
#whatsapp,
.btn-whatsapp{ display: none !important; }

/* ── Wrapper ─────────────────────────────────────── */
.zx-wrapper{
    max-width: 1100px;
    margin: 0 auto;
    padding: 32px 20px 60px;
}

/* ── Header ──────────────────────────────────────── */
.zx-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.zx-header-center{
    text-align: center;
    flex: 1;
}

.zx-title{
    font-size: 26px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0 0 4px;
}

.zx-subtitle{
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

/* ── Back / Add buttons ──────────────────────────── */
.btn-back{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border: 1.5px solid #d1d5db;
    border-radius: 10px;
    background: #fff;
    color: #374151;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: .18s;
    white-space: nowrap;
}

.btn-back:hover{
    background: #f9fafb;
    border-color: #9ca3af;
    color: #111;
    transform: translateY(-1px);
}

.btn-add{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 22px;
    background: #1a5c38;
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 4px 14px rgba(26,92,56,.25);
    transition: .18s;
}

.btn-add:hover{
    background: #145030;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(26,92,56,.3);
}

/* ── Card list ───────────────────────────────────── */
.zx-card-list{
    display: flex;
    flex-direction: column;
    gap: 14px;
}

/* ── Card ────────────────────────────────────────── */
.zx-card{
    display: flex;
    align-items: center;
    gap: 18px;
    background: #fff;
    border-radius: 16px;
    padding: 16px 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #e5e7eb;
    transition: box-shadow .18s, transform .18s;
    flex-wrap: wrap;
}

.zx-card:hover{
    box-shadow: 0 6px 20px rgba(0,0,0,.10);
    transform: translateY(-1px);
}

/* ── Icon ────────────────────────────────────────── */
.zx-card-icon{
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: #d4edda;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.zx-card-icon img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
}

.zx-icon-placeholder{
    font-size: 24px;
    line-height: 1;
}

/* ── Info ────────────────────────────────────────── */
.zx-card-info{
    flex: 1;
    min-width: 160px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.zx-card-name{
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
}

.zx-card-meta{
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.zx-badge{
    font-size: 11.5px;
    font-weight: 600;
    background: #f3f4f6;
    color: #4b5563;
    border-radius: 20px;
    padding: 3px 10px;
}

.zx-badge-cat{
    background: #dcfce7;
    color: #166534;
}

/* ── Docs ────────────────────────────────────────── */
.zx-card-docs{
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    align-items: center;
}

.btn-doc{
    font-size: 12px;
    font-weight: 600;
    padding: 6px 13px;
    border-radius: 8px;
    border: 1.5px solid #d1d5db;
    color: #374151;
    background: #fff;
    text-decoration: none;
    transition: .15s;
}

.btn-doc:hover{
    background: #f0fdf4;
    border-color: #6ee7b7;
    color: #065f46;
}

/* ── Actions ─────────────────────────────────────── */
.zx-card-actions{
    display: flex;
    gap: 8px;
    align-items: center;
    flex-shrink: 0;
}

.btn-edit{
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 18px;
    border: 1.5px solid #3b82f6;
    border-radius: 9px;
    color: #3b82f6;
    background: #fff;
    font-weight: 700;
    font-size: 13.5px;
    text-decoration: none;
    transition: .15s;
    white-space: nowrap;
}

.btn-edit:hover{
    background: #eff6ff;
    color: #2563eb;
    border-color: #2563eb;
}

.btn-delete{
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 18px;
    border: 1.5px solid #ef4444;
    border-radius: 9px;
    color: #ef4444;
    background: #fff;
    font-weight: 700;
    font-size: 13.5px;
    cursor: pointer;
    transition: .15s;
    white-space: nowrap;
}

.btn-delete:hover{
    background: #fef2f2;
    color: #dc2626;
    border-color: #dc2626;
}

/* ── Responsive ──────────────────────────────────── */
@media (max-width: 640px){
    .zx-header{ flex-direction: column; align-items: stretch; text-align: center; }
    .zx-card{ gap: 12px; }
    .zx-card-info{ width: 100%; }
}
</style>

@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

@endauth
</x-app-layout>