<x-app-layout>
@auth('employee')

<div class="zx-wrapper">

    {{-- HEADER --}}
    <div class="zx-header">
        <a class="btn-back" href="{{ route('admin.dashboard') }}">← Regresar</a>
        <div class="zx-header-center">
            <h1 class="zx-title">Paleta de Colores</h1>
            <p class="zx-subtitle">Administra los colores disponibles para tus productos</p>
        </div>
        <a class="btn-add" href="{{ route('colors.create') }}">+ Añadir Color</a>
    </div>

    @if(session('success'))
        <div class="zx-alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($colors->isEmpty())
        <div class="zx-empty">
            No hay colores registrados aún.
            <div style="margin-top:14px;">
                <a href="{{ route('colors.create') }}" class="btn-add" style="display:inline-flex;">+ Añadir el primero</a>
            </div>
        </div>
    @else
        <div class="zx-card-list">
            @foreach($colors as $color)
                @php $hex = ltrim($color->id_color, '#'); @endphp
                <div class="zx-card">
                    <span class="zx-color-num">{{ $loop->iteration }}</span>
                    <div class="zx-color-swatch" style="background-color: #{{ $hex }};"></div>
                    <div class="zx-card-info">
                        <span class="zx-card-name">{{ $color->nombre }}</span>
                        <span class="zx-color-hex">#{{ strtoupper($hex) }}</span>
                    </div>
                    <div class="zx-card-actions">
                        <a href="{{ route('colors.edit', $color->id_color) }}" class="btn-circle-edit" title="Editar">
                            ✏️
                        </a>
                        <form action="{{ route('colors.destroy', ltrim($color->id_color, '#')) }}" method="POST" class="zx-inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-circle-delete" title="Eliminar"
                                onclick="return confirm('¿Eliminar el color {{ $color->nombre }}?')">
                                🗑
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

<style>
*{ box-sizing: border-box; }

body{
    background: linear-gradient(135deg, #a7f3d0, #6ee7b7);
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

/* ── Alert success ─────────────────────────── */
.zx-alert-success{
    background: #dcfce7;
    border-left: 4px solid #1a5c38;
    border-radius: 10px;
    color: #145030;
    font-weight: 600;
    font-size: 14px;
    padding: 12px 16px;
    margin-bottom: 20px;
}

/* ── Lista de colores ─────────────────────── */
.zx-card-list{ display: flex; flex-direction: column; gap: 10px; }

.zx-card{
    display: flex; align-items: center; gap: 18px;
    background: #fff;
    border-radius: 16px;
    padding: 15px 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #e5e7eb;
    transition: box-shadow .18s;
    flex-wrap: wrap;
}
.zx-card:hover{ box-shadow: 0 6px 18px rgba(0,0,0,.08); }

/* ── Número de orden ──────────────────────── */
.zx-color-num{
    font-size: 12px; font-weight: 700; color: #9ca3af;
    min-width: 20px; text-align: center; flex-shrink: 0;
}

/* ── Swatch circular ───────────────────────── */
.zx-color-swatch{
    width: 48px; height: 48px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.15), 0 0 0 1px #e5e7eb;
}

/* ── Info ──────────────────────────────────── */
.zx-card-info{
    flex: 1; min-width: 140px;
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
}
.zx-card-name{ font-size: 16px; font-weight: 700; color: #111827; }
.zx-color-hex{
    font-size: 12px; font-weight: 600; color: #6b7280;
    font-family: monospace; letter-spacing: .03em;
}

/* ── Acciones (círculos con icono) ────────── */
.zx-card-actions{ display: flex; gap: 8px; align-items: center; flex-shrink: 0; }
.zx-inline-form{ display: contents; }

.btn-circle-edit, .btn-circle-delete{
    width: 38px; height: 38px;
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 15px;
    border: none; cursor: pointer;
    text-decoration: none;
    transition: transform .18s, box-shadow .18s;
    flex-shrink: 0;
}

.btn-circle-edit{
    background: #1a5c38;
    box-shadow: 0 4px 10px rgba(26,92,56,.3);
}
.btn-circle-edit:hover{
    transform: scale(1.1);
    box-shadow: 0 6px 14px rgba(26,92,56,.45);
}

.btn-circle-delete{
    background: #ef4444;
    box-shadow: 0 4px 10px rgba(239,68,68,.3);
}
.btn-circle-delete:hover{
    transform: scale(1.1);
    box-shadow: 0 6px 14px rgba(239,68,68,.45);
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
}
</style>

@endauth
</x-app-layout>