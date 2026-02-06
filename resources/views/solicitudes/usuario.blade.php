<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/solicitud.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script>
            function confirmarEliminar(event) {
                if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    event.preventDefault(); // Evita que el formulario se envíe
                }
            }
        </script>
    </head>
    <body class="bg-dark">
        <div class="container mt-5">
            <h1 class="text-center text-light mb-4">Tus Solicitudes</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light mb-3">Regresar</a>

            {{-- Reportes --}}
            <h2 class="text-warning mb-3">Reporte de soporte y quejas</h2>
            @if($reportes->count())
                <div class="list-group mb-4">
                    @foreach($reportes as $reporte)
                        <div class="list-group-item list-group-item-action bg-secondary text-light mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Asunto:</strong> {{ $reporte->descripcion }} <br>
                                <strong>Estado:</strong> <span class="badge bg-info">{{ $reporte->estado }}</span> <br>
                                <strong>Tipo de reporte:</strong> {{ $reporte->tipo_reporte }} <br>
                                <strong>Fecha:</strong> {{ $reporte->creado_en->format('d/m/Y H:i:s') }} <br>
                                <strong>Ultima actualizaciòn:</strong> {{ $reporte->actualizado_en->format('d/m/Y H:i:s') }}
                            </div>
                            <form action="{{ route('reportes.eliminar', $reporte->id_reporte) }}" method="POST" onsubmit="confirmarEliminar(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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
                                <strong>Descripción:</strong> {{ $mantenimiento->descripcion }} <br>
                                <strong>Estado:</strong> <span class="badge bg-warning">{{ $mantenimiento->status }}</span> <br>
                                <strong>Fecha:</strong> {{ $mantenimiento->created_at->format('d/m/Y H:i:s') }} <br>
                                <strong>Ultima actualizaciòn:</strong> {{ $mantenimiento->updated_at->format('d/m/Y H:i:s') }}
                            </div>
                            <form action="{{ route('mantenimientos.eliminar', $mantenimiento->id) }}" method="POST" onsubmit="confirmarEliminar(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>