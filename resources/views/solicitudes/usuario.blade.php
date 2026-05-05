<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/solicitud.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script>
            function confirmarEliminar(event) {
                if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                }
            }
        </script>
    </head>
    <body class="bg-dark">
        <div class="container mt-5">
            <h1 class="text-center text-light mb-4">Tus Solicitudes</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light mb-3">Regresar</a>

            {{-- Reportes --}}
            <h2 class="text-warning mb-3">Reporte de soporte y quejas</h2>
            @if($reportes->count())
                <div class="list-group mb-4">
                    @foreach($reportes as $reporte)
                        <div class="list-group-item list-group-item-action bg-secondary text-light mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Asunto:</strong> {{ Str::limit($reporte->descripcion, 50) }} <br>
                                <strong>Estado:</strong> <span class="badge bg-info">{{ $reporte->estado }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <!-- BOTÓN PARA ABRIR EL MODAL -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalReporte{{ $reporte->id_reporte }}">
                                    Ver más
                                </button>

                                <form action="{{ route('reportes.eliminar', $reporte->id_reporte) }}" method="POST" onsubmit="confirmarEliminar(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- CUADRO EMERGENTE (MODAL) PARA REPORTES -->
                        <div class="modal fade" id="modalReporte{{ $reporte->id_reporte }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark text-light border-warning">
                                    <div class="modal-header border-warning">
                                        <h5 class="modal-title text-warning">Detalle de Solicitud</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Descripción Completa:</strong><br>{{ $reporte->descripcion }}</p>
                                        <hr>
                                        <p><strong>Tipo:</strong> {{ $reporte->tipo_reporte }}</p>
                                        <p><strong>Estado:</strong> {{ $reporte->estado }}</p>
                                        <p><strong>Fecha:</strong> {{ $reporte->creado_en->format('d/m/Y H:i:s') }}</p>
                                        <p><strong>Última actualización:</strong> {{ $reporte->actualizado_en->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                    <div class="modal-footer border-warning">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-white">No hay reportes registrados.</p>
            @endif

            {{-- Mantenimientos --}}
            <h2 class="text-info mb-3">Servicios</h2>
            @if($mantenimientos->count())
                <div class="list-group">
                    @foreach($mantenimientos as $mantenimiento)
                        <div class="list-group-item list-group-item-action bg-secondary text-light mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Descripción:</strong> {{ Str::limit($mantenimiento->descripcion, 50) }} <br>
                                <strong>Estado:</strong> <span class="badge bg-warning">{{ $mantenimiento->status }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <!-- BOTÓN PARA ABRIR EL MODAL -->
                                <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalMantenimiento{{ $mantenimiento->id }}">
                                    Ver más
                                </button>

                                <form action="{{ route('mantenimientos.eliminar', $mantenimiento->id) }}" method="POST" onsubmit="confirmarEliminar(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- CUADRO EMERGENTE (MODAL) PARA MANTENIMIENTOS -->
                        <div class="modal fade" id="modalMantenimiento{{ $mantenimiento->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark text-light border-info">
                                    <div class="modal-header border-info">
                                        <h5 class="modal-title text-info">Detalle del Servicio</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Descripción:</strong><br>{{ $mantenimiento->descripcion }}</p>
                                        <hr>
                                        <p><strong>Estatus:</strong> {{ $mantenimiento->status }}</p>
                                        <p><strong>Fecha Solicitud:</strong> {{ $mantenimiento->created_at->format('d/m/Y H:i:s') }}</p>
                                        <p><strong>Última actualización:</strong> {{ $mantenimiento->updated_at->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                    <div class="modal-footer border-info">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-white">No hay mantenimientos registrados.</p>
            @endif
        </div>
        <br>
        @include('footer')
    </body>
</x-app-layout>