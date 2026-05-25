@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #2F5F63; min-height: 100vh;">
    <div class="container bg-white p-4 rounded shadow">

    <h2 class="mb-4 fw-bold text-center titulo-reseñas">Gestión de Reseñas</h2>

    @if(session('ok'))
        <div class="alert alert-success">
            {{ session('ok') }}
        </div>
    @endif

    {{-- =========================
        BOTÓN REGRESAR
    ========================== --}}
    <div class="mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-regresar text-white">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    {{-- =========================
        RESEÑAS PENDIENTES
    ========================== --}}
    <div class="card mb-5">
        <div class="card-header encabezado-azul">
            <strong>Reseñas Pendientes</strong>
        </div>

        <div class="card-body">
            @if($pendientes->isEmpty())
                <p class="text-muted mb-0">No hay reseñas pendientes.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover vertical-align-middle">
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
                                    <td>{{ $r->descripcion }}</td>
                                    <td>{{ $r->created_at }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Aprobar --}}
                                            <form method="POST" action="{{ route('admin.reviews.estado', $r->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                {{-- ✅ CORREGIDO: El valor ahora es 'aprobado' para que pase el validador --}}
                                                <input type="hidden" name="estatus" value="aprobado">
                                                <button class="btn btn-success btn-sm">
                                                    <i class="fas fa-check me-1"></i> Aprobar
                                                </button>
                                            </form>

                                            {{-- Eliminar --}}
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar reseña?')">
                                                    <i class="fas fa-trash me-1"></i> Eliminar
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
    <div class="card">
        <div class="card-header encabezado-azul">
            <strong>Reseñas Activas</strong>
        </div>

        <div class="card-body">
            @if($activos->isEmpty())
                <p class="text-muted mb-0">No hay reseñas activas.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover vertical-align-middle">
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
                                    <td>{{ $r->descripcion }}</td>
                                    <td>{{ $r->created_at }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Volver a pendiente --}}
                                            <form method="POST" action="{{ route('admin.reviews.estado', $r->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estatus" value="pendiente">
                                                <button class="btn btn-secondary btn-sm">
                                                    <i class="fas fa-undo me-1"></i> Desactivar
                                                </button>
                                            </form>

                                            {{-- Eliminar --}}
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar reseña?')">
                                                    <i class="fas fa-trash me-1"></i> Eliminar
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
</div>
@endsection

<style>
.titulo-reseñas {
    font-size: 2rem;
    font-weight: 800;
    color: #1f3f42;
}
.btn-regresar {
    background-color: #2F5F63;
    font-weight: 600;
    border: none;
    transition: background-color 0.2s;
}
.btn-regresar:hover {
    background-color: #244b4f;
}
.encabezado-azul {
    background-color: #2F5F63 !important;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
}
.table text-center th, .table text-center td {
    vertical-align: middle;
}
</style>