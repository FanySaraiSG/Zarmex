<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <title>Iniciar Sesión / Registrarse</title>
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
            <div class="login-header">
                <i class="fas fa-user-circle main-icon"></i>
                <h2>Inicio de Sesión - Empleados</h2>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-icon-group">
    <i class="fas fa-user"></i>
    <input type="email" name="email" placeholder="Tu correo" required autofocus>
</div>

<div class="input-icon-group">
    <i class="fas fa-lock"></i>
    <input type="password" name="password" placeholder="Tu contraseña" required>
</div>
                
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                <button type="submit">Iniciar Sesión</button>
            </form>
            
            <br>
            <a style="text-decoration: underline; font-weight: bold;" href="{{ route('employee.login') }}">
                ¿Eres parte de nuestro equipo? Ingresa aquí
            </a>
        </div>

        <div class="panel right green-bg" id="register-panel">
            <h2>¡Hola!</h2>
            <p>Regístrese con sus datos personales para usar todas las funciones del sitio</p>
            <button id="switch-to-register" onclick="switchToRegister()">Registrarse</button>
        </div>
    </div>

    <div id="register-container" class="container hidden">
        <div class="panel left green-bg">
            <h2>¡Bienvenido!</h2>
            <p>Regístrese para disfrutar de una experiencia personalizada</p>
            <button id="switch-to-login" onclick="switchToLogin()">Iniciar Sesión</button>
        </div>
        <div class="panel right">
            <h2>Registrarse</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" placeholder="Nombre" required value="{{ old('name') }}">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirmar Password" required>

                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                @error('password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>

    <script>
        function switchToRegister() {
            document.getElementById('main-container').classList.add('hidden');
            document.getElementById('register-container').classList.remove('hidden');
        }
        function switchToLogin() {
            document.getElementById('register-container').classList.add('hidden');
            document.getElementById('main-container').classList.remove('hidden');
        }
    </script>
</body>
</html>
