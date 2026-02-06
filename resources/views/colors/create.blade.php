<x-app-layout>
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
    <head>
        <section class="cardform">
        <div class="form-container">
            <h2>Añadir Color</h2>
            @auth('employee')
                @if(Auth::user()->rol === 'admin')
                    <div class="form-group d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="{{ route('colors.index') }}">Regresar</a>
                    </div>
                    <form action="{{ route('colors.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="id_color">Código de Color (Ejemplo: FF5733):</label>
                            <input type="text" id="id_color" name="id_color" required>
                        </div>
    
                        <div class="form-group">
                            <label for="nombre">Nombre del Color:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
    
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Crear Color</button>
                        </div>
                    </form>
                @endif
            @endauth
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
      </x-app-layout>
      