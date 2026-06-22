<x-app-layout>
@auth('employee')

<div class="zx-wrapper">

    {{-- HEADER --}}
    <div class="zx-header">
        <a class="btn-back" href="{{ route('admin.dashboard') }}">← Regresar</a>
        <div class="zx-header-center">
            <h1 class="zx-title">Empleados</h1>
            <p class="zx-subtitle">Administra el personal con acceso al panel</p>
        </div>
        <a class="btn-add" href="{{ route('employees.create') }}">+ Agregar Empleado</a>
    </div>

    {{-- TARJETA CONTENEDORA --}}
    <div class="zx-card">

        @if($employees->isEmpty())
            <div class="zx-empty">No hay empleados registrados.</div>
        @else
            <table class="zx-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Número de Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="zx-td-name">{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->telefono }}</td>
                        <td><span class="zx-badge-rol">{{ $employee->rol }}</span></td>
                        <td>
                            @if (Auth::guard('employee')->user()->id_empleado !== $employee->id_empleado)
                                <div class="zx-row-actions">
                                    <a href="{{ route('employees.edit', $employee->id_empleado) }}"
                                       class="btn-edit">✏️ Editar</a>
                                    <form action="{{ route('employees.destroy', $employee->id_empleado) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete"
                                                onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
                                            🗑 Eliminar
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="zx-no-img">No disponible</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

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

/* ── Card contenedora ─────────────────────── */
.zx-card{
    background: #fff;
    border-radius: 16px;
    padding: 10px 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #e5e7eb;
}

/* ── Tabla ─────────────────────────────────── */
.zx-table{
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}
.zx-table thead th{
    background: #1a5c38;
    color: #fff;
    padding: 12px 14px;
    text-align: left;
    font-weight: 700;
    font-size: 12.5px;
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
.zx-table tbody td{ padding: 12px 14px; vertical-align: middle; color: #374151; }

.zx-td-name{ font-weight: 700; color: #111827; }

.zx-badge-rol{
    font-size: 12px; font-weight: 600;
    background: #dcfce7; color: #166534;
    border-radius: 20px; padding: 3px 11px;
    white-space: nowrap;
}

.zx-no-img{ color: #d1d5db; }

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
    width: auto;
    padding: 6px 12px;
    border: 1.5px solid #ef4444; border-radius: 8px;
    color: #ef4444; background: transparent;
    font-weight: 700; font-size: 12px;
    cursor: pointer; transition: .14s; white-space: nowrap;
}
.btn-delete:hover{ background: #fef2f2; color: #dc2626; border-color: #dc2626; }

/* ── Empty state ──────────────────────────── */
.zx-empty{
    text-align: center; color: #9ca3af; font-size: 15px;
    padding: 40px;
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 640px){
    .zx-header{ flex-direction: column; align-items: stretch; text-align: center; }
    .zx-table{ font-size: 12px; }
}
</style>

@if(session('success'))
<script>alert("{{ session('success') }}");</script>
@endif

@endauth
</x-app-layout>