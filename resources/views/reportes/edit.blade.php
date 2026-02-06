<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @auth('employee')
            <!DOCTYPE html>
            <html lang="es">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">

                <title>Editar Reporte</title>
            </head>

        <body>
            <div class="container mt-5">
                <div class="form-container">
                    <h2 class="text-center">Editar Reporte</h2>

                    <div class="form-group d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="{{route('reportes.index')}}">Regresar</a>
                    </div>

                    <form action="{{ route('reportes.update', $reporte->id_reporte) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Estado -->
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="pendiente" {{ $reporte->estado == 'pendiente' ? 'selected' : '' }}>Pendiente
                                </option>
                                <option value="en proceso" {{ $reporte->estado == 'en proceso' ? 'selected' : '' }}>En Proceso
                                </option>
                                <option value="resuelto" {{ $reporte->estado == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_empleado">Asignar a un Empleado:</label>
                            <select id="id_empleado" name="id_empleado" class="form-control">
                                <option value="">No Asignado</option>
                                @foreach($empleados as $empleado)
                                    @if($empleado->rol != 'tecnico') <!-- Filtramos los empleados con rol 'tecnico' -->
                                        <option value="{{ $empleado->id_empleado }}" {{ $reporte->id_empleado == $empleado->id_empleado ? 'selected' : '' }}>
                                            {{ $empleado->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>



                        <button type="submit" class="btn btn-primary mt-3">Actualizar Reporte</button>
                    </form>
                </div>
            </div>
        </body>

        </html>
    @endauth