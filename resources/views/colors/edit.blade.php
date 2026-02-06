
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
    @if(Auth::user()->rol === 'admin')
    <section class="cardform">
        <div class="form-container">
            <h2>Editar Color</h2>
            <div class="form-group d-flex justify-content-between mb-3">
                <a class="btn btn-secondary btn-sm" href="{{ route('colors.index') }}">Regresar</a>
            </div>
            
            <form action="{{ route('colors.update', $color->id_color) }}" method="post">
                @csrf
                @method('PUT') {{-- Importante para indicar que es una actualización --}}
                <div class="form-group">
                    <label for="id_color">Código de Color:</label>
                    <input type="text" id="id_color" name="id_color" value="{{ $color->id_color }}" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre del Color:</label>
                    <input type="text" id="nombre" name="nombre" value="{{ $color->nombre }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Actualizar Color</button>
                </div>
            </form>
        </div>
    </section>
    
    @else
        <div class="container mt-5">
            <div class="alert alert-danger text-center">
                <h4>Access Denied</h4>
                <p>You do not have permission to view this page.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Go Back</a>
            </div>
        </div>
    @endif
@endauth