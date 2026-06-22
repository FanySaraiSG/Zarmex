<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <title>Restablecer Contraseña</title>
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
                    <img src="{{ asset('imagenes/logo.jpeg') }}" alt="Zarmex">
                </a>
            </div>
            <div class="nav-right"></div>
        </div>
    </header>

    <div id="main-container" class="container">
        <div class="panel left" id="login-panel">
            <h2>Restablecer Contraseña</h2>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token oculto -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <input type="email" name="email" placeholder="Correo electrónico" required autofocus value="{{ old('email', $request->email) }}">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Nueva contraseña -->
                <input type="password" name="password" placeholder="Nueva contraseña" required>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Confirmación -->
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                @error('password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <button type="submit">Restablecer Contraseña</button>
            </form>

            <br>
            <a style="text-decoration: underline;" href="{{ route('login') }}">
                Volver al inicio de sesión
            </a>
        </div>
    </div>
</body>
</html>
