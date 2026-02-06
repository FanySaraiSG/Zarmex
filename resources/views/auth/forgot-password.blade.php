<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav-left">
                <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i></a>
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
        <div class="panel left" id="login-panel">
            <h2>¿Olvidaste tu contraseña?</h2>

            <p style="font-size: 14px; color: aliceblue; margin-bottom: 15px;">
                No hay problema. Solo dinos tu correo electrónico y te enviaremos un enlace para restablecerla.
            </p>

            <!-- Mensaje de estado de la sesión -->
            @if (session('status'))
                <div class="text-green-500 text-sm mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <input type="email" name="email" placeholder="Correo electrónico" required autofocus value="{{ old('email') }}">

                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <button type="submit">Enviar enlace de recuperación</button>
            </form>

            <br>
            <a style="text-decoration: underline;" href="{{ route('login') }}">
                ¿Recordaste tu contraseña? Inicia sesión aquí
            </a>
        </div>

    </div>
</body>
</html>
