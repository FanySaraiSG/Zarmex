<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Festividad</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; }
    body { background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; min-height: 100vh; }
    .topbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: 0 32px; height: 64px; display: flex; align-items: center; justify-content: center; position: sticky; top: 0; z-index: 50; }
    .topbar-inner { width: 100%; max-width: 700px; display: flex; align-items: center; justify-content: space-between; }
    .topbar-title { display: flex; align-items: center; gap: 10px; font-size: 1.05rem; font-weight: 800; color: #1a1a2e; }
    .t-icon { width: 36px; height: 36px; background: #f3e8ff; border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #7e22ce; font-size: 1rem; }
    .btn-cancel { display: inline-flex; align-items: center; gap: 6px; background: transparent; border: 1.5px solid #dee2e6; color: #495057; font-weight: 600; font-size: 0.83rem; padding: 7px 16px; border-radius: 8px; text-decoration: none; transition: all 0.18s; }
    .btn-cancel:hover { background: #f1f3f5; border-color: #adb5bd; color: #343a40; }
    .page-wrap { max-width: 700px; margin: 36px auto 60px; padding: 0 16px; }
    .form-card { background: #fff; border-radius: 18px; border: 1px solid rgba(0,0,0,.07); box-shadow: 0 8px 32px rgba(0,0,0,.07); overflow: hidden; }
    .form-card-header { padding: 28px 32px 22px; border-bottom: 1px solid #f1f3f5; text-align: center; }
    .fch-icon { width: 52px; height: 52px; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #7e22ce; font-size: 1.4rem; margin: 0 auto 14px; }
    .form-card-header h2 { font-size: 1.25rem; font-weight: 800; color: #1a1a2e; margin: 0 0 4px; }
    .form-card-header p { font-size: 0.83rem; color: #6c757d; margin: 0; }
    .form-body { padding: 28px 32px 32px; }
    .alert-success-z { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .alert-error-z { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 20px; }
    .alert-error-z ul { margin: 0; padding-left: 18px; }
    .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    @media(max-width:560px){ .grid2 { grid-template-columns: 1fr; } }
    .field-group { margin-bottom: 16px; }
    .field-label { display: block; font-size: 0.82rem; font-weight: 700; color: #374151; margin-bottom: 7px; }
    .req { color: #ef4444; margin-left: 2px; }
    .field-hint { font-size: 0.75rem; color: #9ca3af; margin-top: 4px; }
    .zfield { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; color: #1a1a2e; background: #fafafa; transition: border-color 0.18s, box-shadow 0.18s; outline: none; }
    .zfield:focus { border-color: #7e22ce; background: #fff; box-shadow: 0 0 0 3px rgba(126,34,206,0.08); }
    .sec-select-wrap { position: relative; }
    .sec-select-wrap::after { content: '\f078'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; font-size: 0.75rem; }
    .zfield.zselect { appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer; }
    .color-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .color-swatch { width: 28px; height: 28px; border-radius: 50%; border: 2px solid transparent; cursor: pointer; transition: transform .15s, border-color .15s; flex-shrink: 0; }
    .color-swatch:hover { transform: scale(1.15); }
    .color-swatch.sel { border-color: #1a1a2e; transform: scale(1.18); }
    .color-picker-input { width: 36px; height: 36px; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 2px; cursor: pointer; background: none; }
    .deco-grid { display: flex; flex-wrap: wrap; gap: 8px; }
    .deco-chip { border: 1.5px solid #e9d5ff; border-radius: 20px; padding: 5px 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #6c757d; transition: all .15s; user-select: none; background: #fff; }
    .deco-chip input { display: none; }
    .deco-chip:has(input:checked) { border-color: #7e22ce; background: #f3e8ff; color: #7e22ce; font-weight: 600; }
    .header-preview { background: #1a2a2a; border-radius: 12px; padding: 14px 20px; display: flex; align-items: center; gap: 12px; }
    #fPrevia { font-size: 1.6rem; font-weight: 900; letter-spacing: 3px; }
    .form-divider { border: none; border-top: 1px solid #f1f3f5; margin: 20px 0; }
    .btn-submit { width: 100%; background: linear-gradient(135deg, #7e22ce 0%, #6b21a8 100%); color: #fff; border: none; padding: 13px 20px; font-size: 0.95rem; font-weight: 800; border-radius: 12px; cursor: pointer; margin-top: 8px; transition: opacity 0.18s, transform 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-submit:hover { opacity: 0.92; transform: translateY(-1px); }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="topbar-inner">
      <div class="topbar-title">
        <div class="t-icon"><i class="fa-solid fa-pen"></i></div>
        Editar festividad
      </div>
      <a href="{{ route('imagenes.index') }}" class="btn-cancel">
        <i class="fa-solid fa-xmark"></i> Cancelar
      </a>
    </div>
  </div>

  <div class="page-wrap">
    <div class="form-card">

      <div class="form-card-header">
        <div class="fch-icon"><i class="fa-solid fa-pen"></i></div>
        <h2>{{ $festividad->nombre }}</h2>
        <p>Modifica el estilo y las decoraciones de esta festividad.</p>
      </div>

      <div class="form-body">

        @if(session('success'))
          <div class="alert-success-z"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert-error-z">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        @php $decoActivas = old('decoraciones', $festividad->decoraciones ?? []); $colorActual = old('color_texto', $festividad->color_texto); @endphp

        <form action="{{ route('festividades.update', $festividad) }}" method="POST">
          @csrf @method('PUT')

          <div class="grid2">
            <div class="field-group">
              <label class="field-label" for="nombre">Nombre <span class="req">*</span></label>
              <input type="text" name="nombre" id="nombre" class="zfield" value="{{ old('nombre', $festividad->nombre) }}" required>
            </div>
            <div class="field-group">
              <label class="field-label" for="texto_header">Texto en el header <span class="req">*</span></label>
              <input type="text" name="texto_header" id="texto_header" class="zfield" maxlength="50" value="{{ old('texto_header', $festividad->texto_header) }}" required>
              <div class="field-hint">Máx. 50 caracteres. Puedes incluir emojis.</div>
            </div>
          </div>

          <hr class="form-divider">

          <div class="grid2">
            <div class="field-group">
              <label class="field-label">Color del texto</label>
              <div class="color-row">
                <input type="color" name="color_texto" id="colorPicker" class="color-picker-input" value="{{ $colorActual }}">
                @foreach(['#b8a120'=>'Dorado','#c0392b'=>'Rojo','#27ae60'=>'Verde','#e67e22'=>'Naranja','#8e44ad'=>'Morado','#e91e8c'=>'Rosa','#2980b9'=>'Azul'] as $hex => $label)
                  <div class="color-swatch {{ $colorActual === $hex ? 'sel' : '' }}" style="background:{{ $hex }};" data-color="{{ $hex }}" title="{{ $label }}"></div>
                @endforeach
              </div>
            </div>
            <div class="field-group">
              <label class="field-label" for="efecto">Efecto del texto</label>
              <div class="sec-select-wrap">
                <select name="efecto" id="efecto" class="zfield zselect">
                  <option value="none"     {{ old('efecto',$festividad->efecto)==='none'     ?'selected':'' }}>Sin efecto</option>
                  <option value="glow"     {{ old('efecto',$festividad->efecto)==='glow'     ?'selected':'' }}>✨ Brillo (glow)</option>
                  <option value="tricolor" {{ old('efecto',$festividad->efecto)==='tricolor' ?'selected':'' }}>🇲🇽 Tricolor</option>
                  <option value="shadow"   {{ old('efecto',$festividad->efecto)==='shadow'   ?'selected':'' }}>🌑 Sombra oscura</option>
                  <option value="outline"   {{ old('efecto',$festividad->efecto)==='outline'   ?'selected':'' }}>✏️ Contorno</option>
                  <option value="rainbow"   {{ old('efecto',$festividad->efecto)==='rainbow'   ?'selected':'' }}>🌈 Arcoíris</option>
                  <option value="fire"      {{ old('efecto',$festividad->efecto)==='fire'      ?'selected':'' }}>🔥 Efecto fuego</option>
                  <option value="ice"       {{ old('efecto',$festividad->efecto)==='ice'       ?'selected':'' }}>❄️ Efecto hielo</option>
                  <option value="neon"      {{ old('efecto',$festividad->efecto)==='neon'      ?'selected':'' }}>💡 Neón</option>
                  <option value="vintage"   {{ old('efecto',$festividad->efecto)==='vintage'   ?'selected':'' }}>🎞️ Vintage</option>
                  <option value="pulse"     {{ old('efecto',$festividad->efecto)==='pulse'     ?'selected':'' }}>💓 Pulso</option>
                  <option value="shimmer"   {{ old('efecto',$festividad->efecto)==='shimmer'   ?'selected':'' }}>✨ Destello</option>
                  <option value="retro"     {{ old('efecto',$festividad->efecto)==='retro'     ?'selected':'' }}>📺 Retro</option>
                  <option value="matrix"    {{ old('efecto',$festividad->efecto)==='matrix'    ?'selected':'' }}>🟩 Matrix</option>
                  <option value="pirate"    {{ old('efecto',$festividad->efecto)==='pirate'    ?'selected':'' }}>☠️ Pirata</option>
                  <option value="carnival"  {{ old('efecto',$festividad->efecto)==='carnival'  ?'selected':'' }}>🎡 Carnaval</option>
                  <option value="coral"     {{ old('efecto',$festividad->efecto)==='coral'     ?'selected':'' }}>🪸 Coral</option>
                  <option value="aurora"    {{ old('efecto',$festividad->efecto)==='aurora'    ?'selected':'' }}>🌌 Aurora boreal</option>
                  <option value="lava"      {{ old('efecto',$festividad->efecto)==='lava'      ?'selected':'' }}>🌋 Lava</option>
                </select>
              </div>
            </div>
          </div>

          <hr class="form-divider">

          <div class="field-group">
            <label class="field-label">Decoraciones animadas</label>
            <div class="deco-grid">
              @foreach(['nieve'=>'❄️ Nieve','flores'=>'🌸 Flores','velas'=>'🕯️ Velas','murcielagos'=>'🦇 Murciélagos','fantasmas'=>'👻 Fantasmas','calabazas'=>'🎃 Calabazas','corazones'=>'❤️ Corazones','confetti'=>'🎊 Confetti','estrellas'=>'⭐ Estrellas','rosas'=>'🌹 Rosas','acebo'=>'🍃 Acebo','banderas'=>'🇲🇽 Banderas','fuegos'=>'🎆 Fuegos artificiales','arboles'=>'🎄 Árbol de Navidad','regalos'=>'🎁 Regalos','campanas'=>'🔔 Campanas','globos'=>'🎈 Globos','soles'=>'☀️ Soles','lunas'=>'🌙 Lunas','arcoiris'=>'🌈 Arcoíris','mariposas'=>'🦋 Mariposas','diamantes'=>'💎 Diamantes','coronas'=>'👑 Coronas','notas'=>'🎵 Notas musicales','serpentinas'=>'🎊 Serpentinas','brujitas'=>'🧙 Brujitas'] as $val => $label)
                <label class="deco-chip">
                  <input type="checkbox" name="decoraciones[]" value="{{ $val }}" {{ in_array($val, $decoActivas) ? 'checked' : '' }}>
                  {{ $label }}
                </label>
              @endforeach
            </div>
          </div>

          <hr class="form-divider">

          <div class="grid2">
            <div class="field-group">
              <label class="field-label" for="fecha_inicio">Inicio automático <span style="font-weight:400;color:#9ca3af;">(opcional)</span></label>
              <input type="date" name="fecha_inicio" id="fecha_inicio" class="zfield" value="{{ old('fecha_inicio', $festividad->fecha_inicio ? $festividad->fecha_inicio->format('Y-m-d') : '') }}">
            </div>
            <div class="field-group">
              <label class="field-label" for="fecha_fin">Fin automático <span style="font-weight:400;color:#9ca3af;">(opcional)</span></label>
              <input type="date" name="fecha_fin" id="fecha_fin" class="zfield" value="{{ old('fecha_fin', $festividad->fecha_fin ? $festividad->fecha_fin->format('Y-m-d') : '') }}">
            </div>
          </div>
          <div class="field-hint" style="margin-top:-10px;margin-bottom:16px;">Sin fechas, se activa manualmente. Con fechas, el sistema la activa y desactiva solo.</div>

          <hr class="form-divider">

          <div class="field-group">
            <label class="field-label">Vista previa en el header</label>
            <div class="header-preview">
              <span style="width:34px;height:34px;background:#1d4e37;border-radius:50%;border:1.5px solid #b8a120;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid fa-bolt" style="color:#b8a120;font-size:13px;"></i>
              </span>
              <span id="fPrevia" style="color:{{ $colorActual }};">{{ old('texto_header', $festividad->texto_header) }}</span>
            </div>
          </div>

          <button type="submit" class="btn-submit">
            <i class="fa-solid fa-save"></i> Guardar cambios
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    const colorPicker = document.getElementById('colorPicker');
    const textoInput  = document.getElementById('texto_header');
    const efectoSel   = document.getElementById('efecto');
    const previa      = document.getElementById('fPrevia');

    function applyPreview() {
      const color = colorPicker.value, efecto = efectoSel.value;
      previa.style.cssText = 'font-size:1.6rem;font-weight:900;letter-spacing:3px;';
      if (efecto === 'glow') { previa.style.color = color; previa.style.textShadow = `0 0 10px ${color}99`; }
      else if (efecto === 'shadow') { previa.style.color = color; previa.style.textShadow = '2px 2px 6px rgba(0,0,0,.8)'; }
      else if (efecto === 'tricolor') { previa.style.background = 'linear-gradient(90deg,#006847 33%,#fff 33%,#fff 66%,#ce1126 66%)'; previa.style.webkitBackgroundClip = 'text'; previa.style.webkitTextFillColor = 'transparent'; previa.style.backgroundClip = 'text'; }
      else { previa.style.color = color; }
    }

    document.querySelectorAll('.color-swatch').forEach(sw => {
      sw.addEventListener('click', () => {
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('sel'));
        sw.classList.add('sel');
        colorPicker.value = sw.dataset.color;
        applyPreview();
      });
    });

    colorPicker.addEventListener('input', applyPreview);
    textoInput.addEventListener('input', () => { previa.textContent = textoInput.value || 'ZARMEX'; });
    efectoSel.addEventListener('change', applyPreview);
    applyPreview();
  </script>
</body>
</html>
@else
  <div class="container mt-5">
    <div class="alert alert-danger text-center">
      <h4>Acceso denegado</h4>
      <p>No tienes permisos para ver esta página.</p>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Regresar</a>
    </div>
  </div>
@endauth
</x-app-layout>