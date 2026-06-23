<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <div class="mant-page">

        <div class="mant-topbar">
            <a href="{{ url()->previous() }}" class="btn-regresar">← Regresar</a>
            <div class="mant-topbar-center">
                <h1 class="mant-title">Mantenimiento y Reparación</h1>
                <p class="mant-subtitle">Administra las solicitudes de servicio</p>
            </div>
            <div style="width:150px"></div>
        </div>

        <div class="mant-shell">

            {{-- Filtros --}}
            <form method="GET" action="{{ route('mantenimientos.index') }}" class="filter-form mb-4">
                <select name="tipo" class="filter-select" onchange="this.form.submit()">
                    <option value="">Todos los tipos</option>
                    <option value="mantenimiento" {{ request('tipo') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                    <option value="reparacion"    {{ request('tipo') == 'reparacion'    ? 'selected' : '' }}>Reparación</option>
                </select>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </form>

            @if(session('success'))
                <div class="alert-success-custom mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($mantenimientos->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>No hay solicitudes registradas{{ request('status') || request('tipo') ? ' con esos filtros' : '' }}.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="mant-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Ocupación</th>
                                <th>Máquina</th>
                                <th>Cód. Equipo</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Descripción</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mantenimientos as $mantenimiento)
                                <tr>
                                    <td class="td-id">{{ $mantenimiento->id }}</td>

                                    <td>
                                        @if($mantenimiento->tipo === 'reparacion')
                                            <span class="badge-tipo badge-reparacion">
                                                <i class="fas fa-wrench me-1"></i> Reparación
                                            </span>
                                        @else
                                            <span class="badge-tipo badge-mantenimiento">
                                                <i class="fas fa-tools me-1"></i> Mantenimiento
                                            </span>
                                        @endif
                                    </td>

                                    <td class="td-nombre">{{ $mantenimiento->nombre }}</td>
                                    <td>{{ $mantenimiento->ocupacion }}</td>
                                    <td>{{ $mantenimiento->tipo_maquina }}</td>
                                    <td class="td-center">{{ $mantenimiento->codigo_equipo }}</td>
                                    <td>{{ $mantenimiento->direccion }}, {{ $mantenimiento->estado }}, CP {{ $mantenimiento->codigo_postal }}</td>

                                    <td>
                                        @if($mantenimiento->correo_electronico)
                                            <a href="mailto:{{ $mantenimiento->correo_electronico }}" class="link-correo">
                                                {{ $mantenimiento->correo_electronico }}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>{{ $mantenimiento->numero_celular ?? '—' }}</td>

                                    <td>
                                        <span class="desc-preview" title="{{ $mantenimiento->descripcion }}">
                                            {{ Str::limit($mantenimiento->descripcion, 50) }}
                                        </span>
                                    </td>

                                    {{-- Cambio de estatus --}}
                                    <td>
                                        <form action="{{ route('mantenimientos.updateStatus', $mantenimiento->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                class="status-select status-{{ Str::slug($mantenimiento->status ?? 'en-revision') }}"
                                                onchange="this.form.submit()">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status }}" {{ $mantenimiento->status == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>

                                    {{-- Eliminar --}}
                                    <td class="td-acciones">
                                        <form action="{{ route('mantenimientos.destroy', $mantenimiento->id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar esta solicitud?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrap">
                    {{ $mantenimientos->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>

    <style>
        .mant-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #a8edbc 0%, #c8f5d5 50%, #b2f0c8 100%);
            padding: 30px 20px;
        }

        /* ── Topbar ── */
        .mant-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto 24px;
        }

        .btn-regresar {
            background: #fff;
            color: #234d50;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: background .2s;
        }
        .btn-regresar:hover { background: #f0faf2; color: #234d50; }

        .mant-topbar-center { text-align: center; }

        .mant-title {
            font-size: 1.9rem;
            font-weight: 900;
            color: #1a3d40;
            margin: 0;
        }

        .mant-subtitle {
            color: #2d6b50;
            font-size: 0.9rem;
            margin: 2px 0 0;
        }

        /* ── Shell ── */
        .mant-shell {
            max-width: 1400px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        /* ── Filtros ── */
        .filter-form { display: flex; gap: 10px; flex-wrap: wrap; }
        .filter-select {
            border: 2px solid #28666e;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 0.88rem;
            color: #234d50;
            font-weight: 600;
            background: #fff;
            cursor: pointer;
            outline: none;
        }
        .filter-select:focus { border-color: #1a4a50; }

        /* ── Alerta ── */
        .alert-success-custom {
            background: #d1fae5;
            color: #065f46;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: 600;
        }

        /* ── Vacío ── */
        .empty-state { text-align: center; color: #94a3b8; padding: 60px 0; }

        /* ── Tabla ── */
        .mant-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
        }

        .mant-table thead tr { background: #234d50; }
        .mant-table thead th {
            padding: 14px 14px;
            font-weight: 700;
            color: #fff;
            text-align: left;
            font-size: 0.8rem;
            white-space: nowrap;
        }
        .mant-table thead th:first-child { border-radius: 12px 0 0 0; }
        .mant-table thead th:last-child  { border-radius: 0 12px 0 0; }

        .mant-table tbody tr {
            border-bottom: 1px solid #eef2f3;
            transition: background .15s;
        }
        .mant-table tbody tr:hover { background: #f4fbf6; }
        .mant-table tbody td {
            padding: 12px 14px;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f3;
        }

        .td-id { font-weight: 800; color: #28666e; text-align: center; }
        .td-center { text-align: center; }
        .td-nombre { font-weight: 700; color: #1e293b; }

        /* Badges tipo */
        .badge-tipo {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-mantenimiento { background: #dbeafe; color: #1e40af; }
        .badge-reparacion    { background: #fce7f3; color: #9d174d; }

        .desc-preview {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 180px;
            color: #64748b;
            font-size: 0.82rem;
        }

        .link-correo { color: #28666e; font-weight: 600; text-decoration: none; }
        .link-correo:hover { text-decoration: underline; }

        /* Select estatus */
        .status-select {
            border: none;
            border-radius: 20px;
            padding: 10px 10px;
            font-size: 0.76rem;
            font-weight: 700;
            cursor: pointer;
            outline: none;
        }
        .status-en-revision      { background: #fef3c7; color: #92400e; }
        .status-en-procedimiento { background: #dbeafe; color: #1e40af; }
        .status-en-camino        { background: #ede9fe; color: #5b21b6; }
        .status-finalizado       { background: #d1fae5; color: #065f46; }

        /* Botón eliminar */
        .td-acciones { text-align: center; }
        .btn-eliminar {
            background: transparent;
            color: #dc2626;
            border: 2px solid #dc2626;
            border-radius: 5px;
            padding: 6px 6px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s, color .2s;
            white-space: nowrap;
        }
        .btn-eliminar:hover { background: #dc2626; color: #fff; }

        /* Paginación */
        .pagination-wrap { display: flex; justify-content: center; margin-top: 24px; }
        .pagination-wrap .pagination .page-link { color: #28666e; border-color: #c5d4d6; }
        .pagination-wrap .pagination .page-item.active .page-link {
            background-color: #28666e; border-color: #28666e; color: #fff;
        }

        @media (max-width: 768px) {
            .mant-topbar { flex-direction: column; gap: 12px; text-align: center; }
            .mant-title  { font-size: 1.3rem; }
        }
    </style>

</x-app-layout>