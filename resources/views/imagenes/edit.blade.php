<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zarmex') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #ffffff; color: #ffffff; }

        header {
            background-color: #28666e;
            color: #fedc97;
            padding: 0 20px;
            height: 90px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        header.sticky { background-color: #234d50; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        .nav-container { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        nav ul { list-style: none; display: flex; justify-content: space-around; flex-grow: 1; margin: 0; height: 100%; align-items: center; }
        nav ul li { position: relative; margin: 0 20px; }
        nav ul li a { color: #fedc97; text-decoration: none; font-size: 1.2em; transition: color 0.3s ease; padding: 0 10px; }
        nav ul li a:hover { color: #ffffff; text-decoration: underline; }
        nav ul li ul { display: none; position: absolute; top: 100%; left: 0; background-color: #28666e; border-radius: 5px; min-width: 180px; padding: 10px 0; z-index: 1000; }
        nav ul li:hover > ul { display: block; }
        nav ul li ul li { margin: 0; padding: 10px 20px; background-color: #28666e; }
        nav ul li ul li a { font-size: 1em; color: #fedc97; text-decoration: none; padding: 5px 0; display: block; }
        nav ul li ul li a:hover { background-color: #7c9885; }

        .logo { display: flex; justify-content: center; align-items: center; position: absolute; left: 50%; transform: translateX(-50%); }
        .logo img { max-height: 70px; width: auto; }

        /* Formulario */
        .form-container {
            max-width: 860px;
            margin: 40px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            font-size: 1.1em;
            border: 1px solid #ddd;
            color: #333;
        }
        .form-container h2 {
            text-align: center;
            color: #28666e;
            font-size: 2em;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; font-size: 1.1em; color: #28666e; margin-bottom: 8px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 10px;
            font-size: 1em; box-sizing: border-box; background-color: #f9f9f9;
            transition: border-color 0.3s ease; color: #333;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #28666e;
            outline: none;
            box-shadow: 0 0 5px rgba(40,102,110,0.4);
        }

        /* ✅ Campo de enlace destacado */
        .link-field-wrap {
            background: #f0f9fa;
            border: 1px solid #b2d8dc;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 22px;
        }
        .link-field-wrap label { color: #28666e; font-weight: 700; font-size: 1.05em; }
        .link-field-wrap input:focus { border-color: #28666e; box-shadow: 0 0 0 0.2rem rgba(40,102,110,.2); }
        .link-field-wrap .hint { font-size: 0.82em; color: #6b7280; margin-top: 6px; }

        .current-link-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85em;
            background: #e8f4f5;
            color: #28666e;
            border: 1px solid #b2d8dc;
            border-radius: 20px;
            padding: 4px 12px;
            margin-top: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        .current-link-badge:hover { background: #28666e; color: #fedc97; }

        .img-thumbnail { border-radius: 10px; border: 1px solid #ddd; }

        .btn-submit {
            padding: 14px 30px;
            background-color: #28666e;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover { background-color: #1d4d52; }
        .btn-secondary-soft {
            background: rgba(35,77,80,.10);
            color: #234d50;
            border: 1px solid rgba(35,77,80,.18);
            font-weight: 700;
            border-radius: 8px;
            padding: 8px 16px;
            text-decoration: none;
            display: inline-block;
            font-size: 0.95em;
        }
        .btn-secondary-soft:hover { background: rgba(35,77,80,.18); color: #234d50; }
    </style>

  @auth('employee')
    @if(Auth::user()->rol === 'admin')
    <body>
        <div class="form-container">
            <h2>Editar Imagen</h2>

            <div class="form-group d-flex justify-content-between mb-3">
                <a href="{{ route('imagenes.index') }}" class="btn-secondary-soft">
                    ← Regresar
                </a>
            </div>

            @if(session('success'))
              <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
              <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

            <form action="{{ route('imagenes.update', $imagen->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- SECCIÓN --}}
                <div class="form-group">
                    <label for="seccion">Sección de la Imagen:</label>
                    <select class="form-control" id="seccion" name="seccion" required>
                        <option value="banner"          {{ $imagen->seccion == 'banner'          ? 'selected' : '' }}>Banner</option>
                        <option value="nosotros_banner" {{ $imagen->seccion == 'nosotros_banner' ? 'selected' : '' }}>Nosotros Banner</option>
                        <option value="nosotros"        {{ $imagen->seccion == 'nosotros'        ? 'selected' : '' }}>Nosotros</option>
                    </select>
                </div>

                {{-- NOMBRE --}}
                <div class="form-group">
                    <label for="nombre">Nombre de la Imagen:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ old('nombre', $imagen->nombre) }}" required>
                </div>

                {{-- VISTA PREVIA ACTUAL --}}
                <div class="form-group mt-3">
                    <label>Vista Previa Actual:</label><br>
                    @php
                      $ext = strtolower(pathinfo($imagen->imagen_url, PATHINFO_EXTENSION));
                      $esVideo = in_array($ext, ['mp4','webm','mov','avi','ogg']);
                    @endphp
                    @if($esVideo)
                      <video src="{{ asset($imagen->imagen_url) }}" width="260" controls class="img-thumbnail"></video>
                    @else
                      <img src="{{ asset($imagen->imagen_url) }}" alt="Imagen Actual" class="img-thumbnail" width="260">
                    @endif
                </div>

                {{-- NUEVA IMAGEN --}}
                <div class="form-group mt-3">
                    <label for="imagen">Cambiar Imagen (Opcional):</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    <img id="newPreview" style="display:none; margin-top:10px; border-radius:10px; max-height:200px; object-fit:cover;" alt="Nueva vista previa">
                </div>

                {{-- ✅ ENLACE DE REDIRECCIÓN --}}
                <div class="link-field-wrap">
                    <label for="link_url">
                        <i class="fa-solid fa-link me-1"></i> URL de redirección
                        <span style="font-weight:400; color:#6b7280;">(opcional)</span>
                    </label>
                    <input
                        type="url"
                        name="link_url"
                        id="link_url"
                        class="form-control @error('link_url') is-invalid @enderror"
                        placeholder="https://ejemplo.com/pagina"
                        value="{{ old('link_url', $imagen->link_url) }}"
                    >
                    @error('link_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($imagen->link_url)
                      <div class="mt-2">
                        <span style="font-size:0.8em; color:#6b7280;">Enlace actual:</span><br>
                        <a href="{{ $imagen->link_url }}" target="_blank" class="current-link-badge">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            {{ $imagen->link_url }}
                        </a>
                      </div>
                    @endif
                    <div class="hint">Si se asigna una URL, esta imagen será clickeable en el carrusel del sitio.</div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">Actualizar Imagen</button>
                </div>
            </form>
        </div>

        <script>
          document.getElementById('imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const prev = document.getElementById('newPreview');
            prev.src = URL.createObjectURL(file);
            prev.style.display = 'block';
          });
        </script>
    </body>

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