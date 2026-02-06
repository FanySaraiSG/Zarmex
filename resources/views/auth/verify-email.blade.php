<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <title>Verifica tu Correo</title>
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
        <div class="panel left" id="login-panel">
            <h2>Verifica tu Correo Electrónico</h2>

            <p style="font-size: 14px; color: aliceblue; margin-bottom: 15px;">
                ¡Gracias por registrarte! Antes de comenzar, por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar.
                <br><br>
                Si no recibiste el correo, podemos enviarte otro con gusto pero no olvides revisar tu bandeja de spam.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="text-green-500 text-sm mb-4 font-medium">
                    Se ha enviado un nuevo enlace de verificación al correo que proporcionaste.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom: 10px;">
                @csrf
                <button type="submit">Reenviar Correo de Verificación</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background: transparent; color: #444; border: none; text-decoration: underline; cursor: pointer;">
                    Cerrar Sesión
                </button>
            </form>
        </div>

        <div class="panel right green-bg">
            <h2>¡Casi Listo!</h2>
            <p>Solo necesitas verificar tu correo para comenzar a disfrutar del sitio.</p>
        </div>
    </div>
</body>
</html>
