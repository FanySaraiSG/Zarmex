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
    <h2>Actualizar Empleado</h2>
    <form action="{{ route('employees.update', $employee->id_empleado) }}" method="post">
      @csrf
      @method('PUT')
      <div class="form-group d-flex justify-content-between mb-3">
          <a class="btn btn-secondary btn-sm" href="{{  route('employees.index')  }}">Regresar</a>
        </div>
      <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $employee->name }}" required>
      </div>
      <div class="form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="{{ $employee->email }}" required>
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="{{ $employee->telefono }}">
      </div>
      <div class="form-group">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
          <option value="admin" {{ $employee->rol == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="soporte" {{ $employee->rol == 'soporte' ? 'selected' : '' }}>Soporte</option>
          <option value="tecnico" {{ $employee->rol == 'tecnico' ? 'selected' : '' }}>Técnico</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="submit-btn">Actualizar Empleado</button>
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
</x-app-layout>