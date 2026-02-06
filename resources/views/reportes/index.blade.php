<x-app-layout>
  @auth('employee')
    <!DOCTYPE html>
    <html lang="es">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Reportes</title>
    <style>
      nav {
      background-color: inherit !important;
      }

      .table {
      background-color: white !important;
      }
    </style>
    </head>

    <body>
    <div class="container mt-5">
      <!-- Botones superiores -->
      <h1 style="text-align: center; color: aliceblue;">Reportes de Soporte y quejas</h1>
      @php
        $employee = auth('employee')->user();
        $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'soporte.dashboard';
      @endphp

      <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-secondary btn-sm" href="{{ route($dashboard) }}">
          Regresar
        </a>
      </div>


      <!-- Filtros -->
      <div class="d-flex justify-content-end mb-3">
      <form method="GET" action="{{ route('reportes.index') }}" class="d-flex gap-2">
        <select name="filtro" class="form-select form-select-sm">
        <option value="">-- Filtrar por --</option>
        <option value="soporte" {{ request('filtro') == 'soporte' ? 'selected' : '' }}>Soporte</option>
        <option value="queja" {{ request('filtro') == 'queja' ? 'selected' : '' }}>Queja</option>
        <option value="no_asignado" {{ request('filtro') == 'no_asignado' ? 'selected' : '' }}>No asignados</option>
        <option value="pendiente" {{ request('filtro') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        <a href="{{ route('reportes.index') }}" class="btn btn-secondary btn-sm">Restablecer</a>
      </form>
      </div>



      <!-- Tabla de Reportes -->
      <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
          <th>Id Reporte</th>
          <th>Nombre de usuario</th>
          <th>Correo de usuario</th>
          <th>Tipo</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Empleado Asignado</th>
          <th>Creado En</th>
          <th>Actualizado En</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($reportes as $reporte)
      <tr>
        <td>{{ $reporte->id_reporte }}</td>
        <td>{{ $reporte->usuario ? $reporte->usuario->name : 'Nombre desconocido desconocido' }}</td>
        <td>{{ $reporte->usuario ? $reporte->usuario->email : 'Correo electrónico desconocido' }}</td>
        <td>{{ ucfirst($reporte->tipo_reporte) }}</td>
        <td>{{ $reporte->descripcion }}</td>
        <td>{{ ucfirst($reporte->estado) }}</td>
        <td>{{ $reporte->empleado ? $reporte->empleado->name : 'No asignado' }}</td>
        <td>{{ $reporte->creado_en->format('d-m-Y H:i') }}</td>
        <td>{{ $reporte->actualizado_en->format('d-m-Y H:i') }}</td>
        <td>
        <a href="{{ route('reportes.edit', $reporte->id_reporte) }}" class="btn btn-primary btn-sm">Editar</a>
        <form action="{{ route('reportes.destroy', $reporte->id_reporte) }}" method="post" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('¿Estás seguro de eliminar este reporte?')">Eliminar</button>
        </form>
        </td>
      </tr>
    @endforeach
        </tbody>
      </table>
      </div>
    </div>
    </body>

    </html>
  @endauth
  @if(session('success'))
    <script>
    alert("{{ session('success') }}");
    </script>
  @endif
</x-app-layout>