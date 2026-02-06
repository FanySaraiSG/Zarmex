
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

       <section class="cardform">
    <div class="form-container">
        <h2>Añadir Reseña</h2>
        <div class="form-group d-flex justify-content-between mb-3">
            <a class="btn btn-secondary btn-sm" href="{{route('dashboard')}}">Regresar</a>
        </div>
        <form action="{{ route('reseñas.store') }}" method="post">
            @csrf
            
            <!-- Email (Foráneo de Users) -->
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
            </div>
            
            <!-- Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            
            <!-- Calificación (1 al 5) -->
            <div class="form-group">
                <label for="calificacion">Calificación:</label>
                <select id="calificacion" name="calificacion" required>
                    <option value="1">1 - Muy Malo</option>
                    <option value="2">2 - Malo</option>
                    <option value="3">3 - Regular</option>
                    <option value="4">4 - Bueno</option>
                    <option value="5">5 - Excelente</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="submit-btn">Enviar Reseña</button>
            </div>
        </form>
    </div>
</section>
