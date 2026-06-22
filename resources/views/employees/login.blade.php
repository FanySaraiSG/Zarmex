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
        <a href="{{ url('/') }}" class="back-btn" aria-label="Volver">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="topbar-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" height="70">
        </div>
    </header>

    <main class="login-page">
        <section class="login-card">
            <div class="login-avatar">
                <i class="fa-solid fa-user"></i>
            </div>

            <h1>Inicio de Sesión - Empleados</h1>

            <form method="POST" action="{{ route('employee.login') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="Tu correo"
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
                    <label for="password">Contraseña</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Tu contraseña"
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

</body>
</html>