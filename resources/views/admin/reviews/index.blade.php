@extends('layouts.app')

@section('content')
<div class="zx-wrapper">

    {{-- HEADER --}}
    <div class="zx-header">
        <a class="btn-back" href="{{ route('admin.dashboard') }}">← Regresar</a>
        <div class="zx-header-center">
            <h1 class="zx-title">Gestión de Reseñas</h1>
            <p class="zx-subtitle">Modera y administra las reseñas de tus clientes</p>
        </div>
        <span></span>
    </div>

    @if(session('ok'))
        <div class="zx-alert-success">✅ {{ session('ok') }}</div>
    @endif

    {{-- =========================
        RESEÑAS PENDIENTES
    ========================== --}}
    <div class="zx-section">
        <div class="zx-section-header">Reseñas Pendientes</div>
        <div class="zx-card">
            @if($pendientes->isEmpty())
                <div class="zx-empty">No hay reseñas pendientes.</div>
            @else
                <div class="zx-table-scroll">
                    <table class="zx-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Calificación</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendientes as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->producto_id }}</td>
                                    <td>{{ $r->guest_nombre ?? 'Anónimo' }}</td>
                                    <td>{{ $r->guest_email ?? '-' }}</td>
                                    <td>{{ $r->calificacion }}/5</td>
                                    <td class="zx-td-desc">{{ $r->descripcion }}</td>
                                    <td>{{ $r->created_at }}</td>
                                    <td>
                                        <div class="zx-row-actions">
                                            {{-- Aprobar --}}
                                            <form method="POST" action="{{ route('admin.reviews.estado', $r->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estatus" value="aprobado">
                                                <button type="submit" class="btn-approve">✔ Aprobar</button>
                                            </form>

                                            {{-- Eliminar --}}
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete"
                                                        onclick="return confirm('¿Eliminar reseña?')">
                                                    🗑 Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- =========================
        RESEÑAS ACTIVAS (APROBADAS)
    ========================== --}}
    <div class="zx-section">
        <div class="zx-section-header">Reseñas Activas</div>
        <div class="zx-card">
            @if($activos->isEmpty())
                <div class="zx-empty">No hay reseñas activas.</div>
            @else
                <div class="zx-table-scroll">
                    <table class="zx-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Calificación</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activos as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->producto_id }}</td>
                                    <td>{{ $r->guest_nombre ?? 'Anónimo' }}</td>
                                    <td>{{ $r->guest_email ?? '-' }}</td>
                                    <td>{{ $r->calificacion }}/5</td>
                                    <td class="zx-td-desc">{{ $r->descripcion }}</td>
                                    <td>{{ $r->created_at }}</td>
                                    <td>
                                        <div class="zx-row-actions">
                                            {{-- Volver a pendiente --}}
                                            <form method="POST" action="{{ route('admin.reviews.estado', $r->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estatus" value="pendiente">
                                                <button type="submit" class="btn-edit">↺ Desactivar</button>
                                            </form>

                                            {{-- Eliminar --}}
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete"
                                                        onclick="return confirm('¿Eliminar reseña?')">
                                                    🗑 Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

<style>
*{ box-sizing: border-box; }

body{
    background: linear-gradient(135deg, #a7f3d0, #6ee7b7);
    font-family: 'Segoe UI', system-ui, sans-serif;
}

nav{ background-color: inherit !important; }

/* ── Wrapper ──────────────────────────────── */
.zx-wrapper{
    max-width: 1100px;
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

.btn-back{
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 20px;
    border: 1.5px solid #d1d5db; border-radius: 10px;
    background: #fff; color: #374151;
    font-weight: 600; font-size: 14px;
    text-decoration: none; transition: .18s; white-space: nowrap;
}
.btn-back:hover{ background: #f9fafb; border-color: #9ca3af; color: #111; transform: translateY(-1px); }

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

/* ── Secciones ─────────────────────────────── */
.zx-section{ margin-bottom: 28px; }
.zx-section-header{
    font-size: 15px; font-weight: 800; color: #1a1a2e;
    margin-bottom: 10px; padding-left: 4px;
}

.zx-card{
    background: #fff;
    border-radius: 16px;
    padding: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.zx-table-scroll{ overflow-x: auto; }

/* ── Tabla ─────────────────────────────────── */
.zx-table{
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.zx-table thead th{
    background: #1a5c38;
    color: #fff;
    padding: 11px 12px;
    text-align: left;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: .02em;
    white-space: nowrap;
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
.zx-td-desc{ max-width: 220px; }

/* ── Acciones por fila ────────────────────── */
.zx-row-actions{ display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
.zx-row-actions form{ display: contents; }

.btn-edit{
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 14px;
    border: 1.5px solid #3b82f6; border-radius: 8px;
    color: #3b82f6; background: transparent;
    font-weight: 700; font-size: 12px;
    cursor: pointer; transition: .14s; white-space: nowrap;
}
.btn-edit:hover{ background: #eff6ff; color: #2563eb; border-color: #2563eb; }

.btn-approve{
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 14px;
    border: 1.5px solid #1a5c38; border-radius: 8px;
    color: #1a5c38; background: transparent;
    font-weight: 700; font-size: 12px;
    cursor: pointer; transition: .14s; white-space: nowrap;
}
.btn-approve:hover{ background: #f0fdf4; color: #145030; border-color: #145030; }

.btn-delete{
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 12px;
    border: 1.5px solid #ef4444; border-radius: 8px;
    color: #ef4444; background: transparent;
    font-weight: 700; font-size: 12px;
    cursor: pointer; transition: .14s; white-space: nowrap;
}
.btn-delete:hover{ background: #fef2f2; color: #dc2626; border-color: #dc2626; }

/* ── Empty state ──────────────────────────── */
.zx-empty{
    text-align: center; color: #9ca3af; font-size: 14px;
    padding: 30px;
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 640px){
    .zx-header{ flex-direction: column; align-items: stretch; text-align: center; }
    .zx-table{ font-size: 12px; }
}
</style>