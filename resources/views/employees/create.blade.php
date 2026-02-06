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
<section class="cardform">
  <div class="form-container">
    <h2>Agregar Empleado</h2>
    @auth('employee')
      @if(Auth::user()->rol === 'admin')
        <div class="form-group d-flex justify-content-between mb-3">
          <a class="btn btn-secondary btn-sm" href="{{  route('employees.index')  }}">Regresar</a>
        </div>
        <form action="{{ route('employees.store') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">
          </div>
          <div class="form-group">
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
              <option value="admin">Admin</option>
              <option value="soporte" selected>Soporte</option>
              <option value="tecnico">Técnico</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="submit-btn">Crear Empleado</button>
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