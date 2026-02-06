<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="antialiased">
    @include('header')
    <main>
        <section class="cardform">
    <div class="form-container">
        <h2>Registrar Reporte</h2>
        <div class="form-group d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{route('dashboard')}}">Regresar</a>
                </div>
        <form action="{{ route('reportes.store') }}" method="POST">
            @csrf

            <!-- ID del Usuario (Oculto) -->
            <input type="hidden" name="id" value="{{ Auth::id() }}">

            <!-- Tipo de Reporte -->
            <div class="form-group">
                <label for="tipo_reporte">Tipo de Reporte:</label>
                <select id="tipo_reporte" name="tipo_reporte" required>
                    <option value="soporte">Soporte</option>
                    <option value="queja">Queja</option>
                </select>
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="submit-btn">Enviar Reporte</button>
            </div>
        </form>
    </div>
</section>




    </main>
    @include('footer')
    
</body>

</html>