<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <title>Inicio de Sesión - Empleados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav-left">
                <a href="../"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="logo">
                <a href="../">
                    <img src="{{ asset('imagenes/Captura de pantalla 2025-01-19 134751.png') }}" alt="Zarmex">
                </a>
            </div>
            <div class="nav-right"></div>
        </div>
    </header>

    <div id="main-container" class="container">
        <div class="panel left">
            <h2>Inicio de Sesión - Empleados</h2>
            
            <!-- Mensajes de estado de sesión -->
            @if (session('status'))
                <p class="text-green-500 text-sm">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('employee.login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" placeholder="Tu correo" required value="{{ old('email') }}">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mt-4">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Tu contraseña" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

</body>
</html>
