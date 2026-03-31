
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>   

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            /* Fondo de la página */
            color: #ffffff;
            /* Texto */
        }

        header {
            background-color: #28666e;
            /* Color de la barra de navegación */
            color: #fedc97;
            /* Color del texto en la barra de navegación */
            padding: 0 20px;
            height: 90px;
            display: flex;
            align-items: center;
            position: sticky;
            /* Hace que la barra de navegación sea pegajosa */
            top: 0;
            /* La barra se mantendrá pegada al tope de la ventana */
            z-index: 1000;
            /* Asegura que la barra se mantenga encima de otros elementos */
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            /* Transición para el color y la sombra */
        }

        /* Cambiar el color de fondo cuando el usuario hace scroll */
        header.sticky {
            background-color: #234d50;
            /* Color más oscuro cuando se hace scroll */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Agrega sombra cuando el usuario baja */
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: space-around;
            flex-grow: 1;
            margin: 0;
            height: 100%;
            align-items: center;
        }

        nav ul li {
            position: relative;
            margin: 0 20px;
        }

        nav ul li a {
            color: #fedc97;
            /* Color del texto en los enlaces del menú */
            text-decoration: none;
            font-size: 1.2em;
            transition: color 0.3s ease;
            padding: 0 10px;
        }

        nav ul li a:hover {
            color: #ffffff;
            /* Nuevo color del texto al pasar el ratón */
            text-decoration: underline;
        }

        nav ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #28666e;
            border-radius: 5px;
            box-shadow: none;
            min-width: 180px;
            padding: 10px 0;
            z-index: 1000;
        }

        nav ul li:hover>ul {
            display: block;
        }

        nav ul li ul li {
            margin: 0;
            padding: 10px 20px;
            background-color: #28666e;
        }

        nav ul li ul li a {
            font-size: 1em;
            color: #fedc97;
            text-decoration: none;
            padding: 5px 0;
            display: block;
        }

        nav ul li ul li a:hover {
            background-color: #7c9885;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo img {
            max-height: 70px;
            width: auto;
        }

        .nav-right {
            display: flex;
            align-items: center;
        }

        .nav-right .search-container {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .search-container input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            margin-right: 10px;
            width: 200px;
        }

        .search-container button {
            padding: 8px 12px;
            background-color: #28666e;
            color: #fedc97;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
        }

        .search-container button:hover {
            background-color: #7c9885;
        }

        .nav-right a {
            margin: 0 15px;
            color: #fedc97;
            text-decoration: none;
            font-size: 1.2em;
        }

        .nav-right a:hover {
            text-decoration: underline;
            color: #ffffff;
        }

        .nav-right a .cart-icon {
            font-size: 1.5em;
            vertical-align: middle;
            transition: color 0.3s ease;
        }

        .nav-right a:hover .cart-icon {
            color: #ffc107;
        }

        /* Actualización para el banner */
        .content-area {
            text-align: center;
            margin: 0;
            /* Elimina márgenes del contenedor */
        }

        .content-area img {
            width: 100%;
            /* El banner ocupa todo el ancho de la página */
            height: auto;
            /* Mantiene la proporción de la imagen */
            display: block;
            /* Elimina los espacios blancos alrededor de la imagen */
        }

        .products {
            margin: 40px 20px;
        }

        .products h2 {
            text-align: center;
            color: #28666e;
            font-size: 2em;
            margin: 20px 0;
        }

        .card-container {
            display: flex;
            justify-content: space-between;
            /* Espacio uniforme entre los productos */
            gap: 20px;
            /* Espacio entre las tarjetas */
            flex-wrap: wrap;
            /* Permite que los productos se ajusten a diferentes tamaños de pantalla */
        }

        .card {
            flex: 1 1 calc(20% - 20px);
            /* Cada tarjeta ocupa el 20% del contenedor menos el margen */
            box-sizing: border-box;
            /* Incluye el padding y el borde dentro del ancho */
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 25px;
            /* Aumentado */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 300px;
            /* Aumentado */
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
            /* Aumentado */
        }

        .card h3 {
            color: #28666e;
            font-size: 1.4em;
            /* Aumentado */
            margin-bottom: 15px;
            /* Aumentado */
        }

        .card p {
            color: #555;
            font-size: 1em;
            /* Aumentado */
            margin-bottom: 20px;
            /* Aumentado */
        }

        .card button {
            background-color: #28666e;
            color: #fedc97;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            /* Aumentado */
            cursor: pointer;
            font-size: 1.1em;
            /* Aumentado */
            transition: background-color 0.3s ease;
        }

        .card button a {
            background-color: #28666e;
            color: #fedc97;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            /* Aumentado */
            cursor: pointer;
            font-size: 1.1em;
            /* Aumentado */
            transition: background-color 0.3s ease;
        }

        .card button:hover {
            background-color: #7c9885;
        }

        .card:hover {
            transform: scale(1.08);
            /* Aumentado ligeramente */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            /* Aumentado */
        }

        /* Estilos para la sección de comentarios */
        .testimonials {
            margin: 60px 20px;
            /* Aumentado para darle más espacio a la sección */
            padding: 40px;
            /* Aumentado para mayor espacio interno */
            background-color: #f9f9f9;
            /* Fondo más claro */
            border-radius: 15px;
            /* Bordes más redondeados */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            /* Sombra más pronunciada */
        }

        .testimonials h2 {
            text-align: center;
            color: #28666e;
            margin-bottom: 30px;
            font-size: 2em;
            /* Título más grande */
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .testimonial-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            /* Aumentado el tamaño mínimo */
            gap: 30px;
            justify-items: center;
        }

        .testimonial {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 12px;
            /* Bordes más suaves */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Sombra más fuerte */
            padding: 30px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .testimonial:hover {
            transform: scale(1.05);
            /* Efecto de aumento al pasar el ratón */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            /* Sombra más fuerte */
        }

        .testimonial .user-icon {
            width: 90px;
            /* Aumentado tamaño del ícono */
            height: 90px;
            /* Aumentado tamaño del ícono */
            border-radius: 50%;
            background-color: #ddd;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8em;
            /* Aumentado tamaño del icono */
            color: #28666e;
            overflow: hidden;
        }

        .testimonial .user-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .testimonial p {
            color: #555;
            font-size: 1.3em;
            /* Aumentado tamaño del texto */
            margin-bottom: 20px;
            /* Más espacio entre el texto y el nombre */
            line-height: 1.6;
            /* Mejor legibilidad */
        }

        .testimonial h4 {
            color: #28666e;
            font-weight: bold;
            font-size: 1.6em;
            /* Aumentado tamaño del nombre */
            margin-bottom: 15px;
            /* Más espacio entre el nombre y las estrellas */
        }

        /* Estilo de estrellas */
        .stars {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            /* Más espacio entre las estrellas y el texto */
        }

        .stars i {
            color: #ffcc00;
            font-size: 1.6em;
            /* Aumentado tamaño de las estrellas */
            margin: 0 5px;
            /* Más espacio entre las estrellas */
        }

        .stars i.inactive {
            color: #ccc;
        }

        footer {
            background-color: #28666e;
            color: #fedc97;
            padding: 20px;
            /* Espacio general del footer */
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }

        footer .footer-section {
            margin: 0;
            flex: 1 1 calc(33% - 40px);
            /* Secciones con espacio uniforme */
            min-width: 250px;
            /* Ancho mínimo para cada sección */
            text-align: center;
            /* Centra el contenido de cada sección */
        }

        footer .footer-section h3 {
            color: #ffffff;
            margin-bottom: 10px;
            font-size: 1.5em;
            /* Aumenta el tamaño del título */
            border-bottom: 2px solid #fedc97;
            padding-bottom: 5px;
        }

        footer .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        footer .footer-section ul li {
            margin: 10px 0;
            /* Aumenta el espacio entre las líneas */
            font-size: 1.2em;
            /* Aumenta el tamaño de las letras */
            line-height: 1.6;
            /* Aumenta la separación entre las líneas */
        }

        footer .footer-section ul li a {
            color: #fedc97;
            text-decoration: none;
            font-size: 1em;
            transition: color 0.3s ease;
        }

        footer .footer-section ul li a:hover {
            color: #ffffff;
        }

        footer .social-icons a {
            font-size: 2.5em;
            /* Aumenta un poco más el tamaño de los íconos */
            color: #fedc97;
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: #ffffff;
        }

        footer .social-icons {
            display: flex;
            justify-content: center;
            gap: 40px;
            /* Aumenta la separación entre los íconos */
        }



        footer .footer-title {
            margin-top: 160px;
            /* Mucho más espacio para moverlo cerca del copyright */
            font-size: 5em;
            font-weight: bold;
            color: #fedc97;
            text-transform: uppercase;
            /* Convierte a mayúsculas */
            font-family: 'Arial', sans-serif;
            /* Fuente estándar o personalizada */
            text-align: center;
            /* Centra la palabra ZARMEX */
        }

        footer .copyright {
            text-align: center;
            font-size: 0.9em;
            margin-top: 20px;
            width: 100%;
            color: #ffffff;
            border-top: 1px solid #fedc97;
            padding-top: 10px;
        }
        /* Estilo para el formulario en una tarjeta */
.form-container {
    max-width: 1200px;  /* Hacer el formulario más ancho */
    margin: 40px auto; /* Centrado con margen superior */
    padding: 40px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Sombra más suave */
    font-size: 1.2em;
    border: 1px solid #ddd; /* Borde suave */
}

/* Título principal de la tarjeta */
.form-container h2 {
    text-align: center;
    color: #28666e; /* Color verde previo */
    font-size: 2.8em;
    margin-bottom: 30px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Estilo para cada grupo de campos dentro del formulario */
.form-group {
    margin-bottom: 30px;
}

.form-group label {
    display: block;
    font-size: 1.3em;
    color: #28666e; /* Color verde previo */
    margin-bottom: 10px;
    font-weight: bold;
}

/* Estilo para los campos del formulario */
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1.1em;
    box-sizing: border-box;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease;
}

/* Estilo al enfocar los campos */
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #28666e; /* Color verde previo */
    outline: none;
    box-shadow: 0 0 5px rgba(40, 102, 110, 0.6);
}

/* Estilo para el textarea (campo de texto largo) */
textarea {
    height: 150px;
    resize: vertical; /* Permite redimensionar solo verticalmente */
}

/* Estilo para el contenedor de los botones */
.button-container {
    text-align: center;
    margin-top: 30px;
}

/* Estilo para el botón de enviar */
.button-container button {
    padding: 15px 30px;
    background-color: #28666e; /* Color verde previo */
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1.4em;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    width: 50%; /* Botón más grande */
    margin: 0 auto;
    display: block;
}

/* Estilo para el botón de enviar al hacer hover */
.button-container button:hover {
    background-color: #7c9885; /* Un verde más claro en hover */
}

/* Estilo para el botón de enviar cuando es presionado */
.button-container button:active {
    transform: scale(0.98);
}

/* Estilo para los mensajes de error o éxito */
.error-message,
.success-message {
    text-align: center;
    font-size: 1.3em;
    padding: 15px;
    margin-top: 20px;
    border-radius: 10px;
    font-weight: bold;
}

/* Estilo para el mensaje de error */
.error-message {
    background-color: #f8d7da;
    color: #721c24;
}

/* Estilo para el mensaje de éxito */
.success-message {
    background-color: #d4edda;
    color: #155724;
}

/* Estilo para los campos deshabilitados */
input[disabled],
select[disabled],
textarea[disabled] {
    background-color: #e9ecef;
    cursor: not-allowed;
}

/* Estilo para los campos con error */
input.error,
select.error,
textarea.error {
    border: 1px solid #e74c3c;
}

input.error:focus,
select.error:focus,
textarea.error:focus {
    border-color: #e74c3c;
    outline: none;
}

/* Agregar una sombra sutil a los campos cuando están en foco */
input:focus, select:focus, textarea:focus {
    box-shadow: 0 0 8px rgba(40, 102, 110, 0.3);
}

/* Estilos para la tarjeta del formulario */
.cardform {
    width: 100%;
    max-width: 1200px;  /* Aumentar el max-width para hacerlo más ancho */
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Estilos para los campos de entrada */
.form-group {
    display: flex;
    flex-direction: column;
}

input[type="text"],
textarea {
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 100%;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
textarea:focus {
    border-color: #007bff;
    outline: none;
}

/* Hacer el área de texto más grande */
textarea {
    height: 120px;
    resize: none;  /* Evitar que el usuario cambie el tamaño */
}

/* Estilo para el botón */
.submit-btn {
    background-color: #28666e; /* Color verde previo */
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    width: auto;
    align-self: center;
}

.submit-btn:hover {
    background-color: #7c9885; /* Un verde más claro en hover */
    transform: translateY(-2px);
}

.submit-btn:active {
    transform: translateY(1px);
}

/* Espaciado adicional para que el formulario se vea más grande */
.form-container h2 {
    font-size: 40px;
    margin-bottom: 20px;
}

    </style>
  @auth('employee')
    @if(Auth::user()->rol === 'admin')
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
    </head>
    <body>
        <div class="container mt-5">
            <div class="form-container">
                <div class="form-container">
                <h2 class="text-center">Editar Imagen</h2>
                <div class="form-group d-flex justify-content-between mb-3">
                    <a href="{{ route('imagenes.index') }}" class="btn btn-secondary btn-sm">Regresar</a>
                </div>
        
                <form action="{{ route('imagenes.update', $imagen->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
        
                    <!-- Sección de la Imagen -->
                    <div class="form-group">
                        <label for="seccion">Sección de la Imagen:</label>
                        <select class="form-control" id="seccion" name="seccion" required>
                            <option value="banner" {{ $imagen->seccion == 'banner' ? 'selected' : '' }}>Banner</option>
                            <option value="nosotros_banner" {{ $imagen->seccion == 'nosotros_banner' ? 'selected' : '' }}>Nosotros Banner</option>
                            <option value="nosotros" {{ $imagen->seccion == 'nosotros' ? 'selected' : '' }}>Nosotros</option>
                        </select>
                    </div>
        
                    <!-- Nombre de la Imagen -->
                    <div class="form-group">
                        <label for="nombre">Nombre de la Imagen:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ old('nombre', $imagen->nombre) }}" required>
                    </div>
        
                    <!-- Imagen Actual -->
                    <div class="form-group mt-3">
                        <label>Vista Previa de la Imagen Actual:</label><br>
                        <img src="{{ asset($imagen->imagen_url) }}" alt="Imagen Actual"
                            class="img-thumbnail" width="200">
                    </div>
        
                    <!-- Subir Nueva Imagen -->
                    <div class="form-group mt-3">
                        <label for="imagen">Cambiar Imagen (Opcional):</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>
        
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Actualizar Imagen</button>
                    </div>
                    
                </form>
            </div>
        </div>
        
    </body>
    </html>
    
    @else
      <div class="container mt-5">
        <div class="alert alert-danger text-center">
          <h4>Acceso Denegado</h4>
          <p>No tienes permiso para acceder a esta página.</p>
          <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver</a>
        </div>
      </div>
    @endif
  @endauth

