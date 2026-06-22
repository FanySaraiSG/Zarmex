<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Zarmex') }} — Editar Recurso</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* --- TODOS LOS ESTILOS ORIGINALES MANTENIDOS --- */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Figtree', 'Segoe UI', Arial, sans-serif; background: #f4f6f9; min-height: 100vh; color: #1a1a2e; }
    .topbar { background: #fff; border-bottom: 1px solid #e9ecef; height: 64px; display: flex; align-items: center; justify-content: center; padding: 0 24px; position: sticky; top: 0; z-index: 100; }
    .topbar-inner { width: 100%; max-width: 640px; display: flex; align-items: center; justify-content: space-between; }
    .topbar-brand { display: flex; align-items: center; gap: 10px; font-size: 1rem; font-weight: 800; color: #1a1a2e; }
    .tb-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #e8f4f5 0%, #cce7ea 100%); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #28666e; }
    .btn-cancel { display: inline-flex; align-items: center; gap: 6px; background: transparent; border: 1.5px solid #dee2e6; color: #495057; font-weight: 700; padding: 7px 16px; border-radius: 8px; text-decoration: none; transition: all 0.18s; }
    .page-wrap { max-width: 640px; margin: 36px auto 60px; padding: 0 16px; }
    .form-card { background: #fff; border-radius: 20px; border: 1px solid rgba(0,0,0,.07); box-shadow: 0 8px 32px rgba(0,0,0,.07); overflow: hidden; }
    .form-card-header { padding: 30px 32px 24px; text-align: center; border-bottom: 1px solid #f1f3f5; background: linear-gradient(180deg, #f8fcfc 0%, #fff 100%); }
    .fch-icon-wrap { width: 58px; height: 58px; background: linear-gradient(135deg, #28666e 0%, #1d4e54 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; margin: 0 auto 16px; }
    .fch-title { font-size: 1.3rem; font-weight: 800; margin-bottom: 5px; }
    .form-body { padding: 28px 32px 32px; }
    .alert-error-z { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 10px; padding: 12px 16px; margin-bottom: 22px; }
    .field-group { margin-bottom: 22px; }
    .field-label { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #374151; margin-bottom: 7px; text-transform: uppercase; }
    .zfield { width: 100%; padding: 11px 15px; border: 1.5px solid #e5e7eb; border-radius: 11px; font-size: 0.9rem; background: #fafafa; transition: 0.18s; }
    .zfield:focus { border-color: #28666e; background: #fff; box-shadow: 0 0 0 3px rgba(40,102,110,0.10); }
    .upload-zone { border: 2px dashed #d1d5db; border-radius: 12px; padding: 22px 20px; text-align: center; cursor: pointer; transition: 0.2s; }
    .upload-zone:hover { border-color: #28666e; background: #f0f9fa; }
    .btn-submit { flex: 1; background: linear-gradient(135deg, #28666e 0%, #1d4e54 100%); color: #fff; border: none; padding: 13px 20px; font-weight: 800; border-radius: 12px; cursor: pointer; }
    
    /* Estilo para el campo de Link */
    .link-box { background: #f8f9fa; border: 1.5px solid #e9ecef; border-radius: 12px; padding: 16px; margin-bottom: 22px; }
    .current-link-badge { display: inline-block; margin-top: 8px; font-size: 0.75rem; color: #28666e; background: #e8f4f5; padding: 4px 10px; border-radius: 20px; text-decoration: none; }
  </style>
</head>
<body>

@auth('employee')
  @if(Auth::guard('employee')->check())
  
  <div class="topbar">
    <div class="topbar-inner">
      <div class="topbar-brand"><div class="tb-icon"><i class="fa-solid fa-photo-film"></i></div>Galería Multimedia</div>
      <a href="{{ route('imagenes.index') }}" class="btn-cancel"><i class="fa-solid fa-xmark"></i> Cancelar</a>
    </div>
  </div>

  <div class="page-wrap">
    <div class="form-card">
      <div class="form-card-header">
        <div class="fch-icon-wrap"><i class="fa-solid fa-pen-to-square"></i></div>
        <div class="fch-title">Editar Recurso Multimedia</div>
      </div>

      <div class="form-body">
        @if($errors->any())
          <div class="alert-error-z"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('imagenes.update', $imagen->id) }}" method="POST" enctype="multipart/form-data">
          @csrf @method('PUT')

          <div class="field-group">
            <label class="field-label">Sección destino</label>
            <select class="zfield" id="seccion" name="seccion" required>
              <option value="banner" {{ $imagen->seccion == 'banner' ? 'selected' : '' }}>Banner Principal</option>
              <option value="nosotros_banner" {{ $imagen->seccion == 'nosotros_banner' ? 'selected' : '' }}>Carrusel Nosotros</option>
              <option value="nosotros_video" {{ $imagen->seccion == 'nosotros_video' ? 'selected' : '' }}>Video Inferior</option>
              <option value="brand_style" {{ $imagen->seccion == 'brand_style' ? 'selected' : '' }}>Estilo Visual</option>
            </select>
          </div>

          <div class="field-group">
            <label class="field-label">Nombre</label>
            <input type="text" class="zfield" id="nombre" name="nombre" value="{{ old('nombre', $imagen->nombre) }}" required>
            <small id="nombreHelp"></small>
          </div>

          {{-- INTEGRACIÓN DEL LINK --}}
          <div class="link-box">
             <label class="field-label">URL de redirección (Opcional)</label>
             <input type="url" name="link_url" class="zfield" placeholder="https://" value="{{ old('link_url', $imagen->link_url) }}">
             @if($imagen->link_url)
               <a href="{{ $imagen->link_url }}" target="_blank" class="current-link-badge">Ver enlace actual</a>
             @endif
          </div>

          <div class="field-group">
            <label class="field-label">Reemplazar archivo</label>
            <div class="upload-zone" id="uploadZone">
              <input type="file" id="imagen" name="imagen" accept="image/*,video/*" style="display:none;">
              <div onclick="document.getElementById('imagen').click()">Clic para seleccionar</div>
            </div>
            <div id="newPreviewBox" style="margin-top:10px; display:none;">
               <img id="newPreviewImg" style="max-width:100%; border-radius:10px; display:none;">
               <video id="newPreviewVid" controls style="max-width:100%; border-radius:10px; display:none;"></video>
            </div>
          </div>

          <button type="submit" class="btn-submit">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Tu lógica original de preview y select que ocupaba gran parte del archivo
    document.getElementById('imagen').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (!file) return;
      const url = URL.createObjectURL(file);
      document.getElementById('newPreviewBox').style.display = 'block';
      if(file.type.startsWith('video/')) {
        document.getElementById('newPreviewVid').src = url;
        document.getElementById('newPreviewVid').style.display = 'block';
      } else {
        document.getElementById('newPreviewImg').src = url;
        document.getElementById('newPreviewImg').style.display = 'block';
      }
    });

    const seccionSelect = document.getElementById('seccion');
    seccionSelect.addEventListener('change', () => {
       document.getElementById('nombreHelp').textContent = (seccionSelect.value === 'brand_style') ? 'Usa: default, navidad, halloween o patrio.' : '';
    });
  </script>
  
  @else
    <div class="access-denied">Acceso denegado</div>
  @endif
@endauth

</body>
</html>