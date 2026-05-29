
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
        <title>{{ config('app.name', 'Zarmex') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @auth('employee')
            @if(Auth::user()->rol === 'admin')
                <section class="cardform">
                    <div class="form-container">
                        <h2>Añadir Categoría</h2>
                        <div class="form-group d-flex justify-content-between mb-3">
                            <a class="btn btn-secondary btn-sm" href="{{ url()->previous() }}">Regresar</a>
                        </div>
                        <form action="{{ route('categorias.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="id_categoria">ID de la Categoría:</label>
                                <input type="text" id="id_categoria" name="id_categoria" required>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="submit-btn">Crear Categoría</button>
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
