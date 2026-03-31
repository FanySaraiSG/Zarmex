<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Empleados</title>

    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header class="topbar">
    <a href="{{ url('/') }}" class="topbar-logo">
        <img src="{{ asset('imagenes/Captura de pantalla 2025-01-19 134751.png') }}" alt="Zarmex">
    </a>
</header>
    <main class="login-page">
        <section class="login-card">
            <div class="login-avatar">
                <svg class="user-icon" viewBox="0 0 24 24" fill="none">
               <circle cx="12" cy="8" r="4" stroke="white" stroke-width="1.5"/>
    <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="white" stroke-width="1.5"/>
</svg>
            </div>

            <h1>Inicio de Sesión - Empleados</h1>

            <form method="POST" action="{{ route('employee.login') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email"></label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="Email"
                            required
                            autofocus
                            value="{{ old('email') }}"
                        >
                    </div>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password"></label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required
                        >

                        
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-btn">Ingresar</button>
            </form>
        </section>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>