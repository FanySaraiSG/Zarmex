<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Gestión de Imágenes
        </h2>
    </x-slot>

    <div class="gi-root">

        <div class="gi-topbar">
            <button type="button" class="btn-back" onclick="window.history.back();">
                <img src="{{ asset('iconos/gi-volver.png') }}" class="gi-btn-icon" alt="">
                Volver al Panel
            </button>
            <div style="flex:1;">
                <h1>Gestión de Imágenes · Reparación</h1>
                <p>Sube hasta 3 imágenes por columna. Usa el tache para quitar las que no quieras.</p>
                {{-- ── Navegación entre secciones ── --}}
                <div style="display:flex;gap:8px;margin-top:8px;">
                    <a href="{{ route('admin.mantenimientos.imagenes.edit') }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:8px;font-size:.78rem;font-weight:700;text-decoration:none;background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.35);transition:background .18s;">
                        <i class="fas fa-wrench"></i> Mantenimiento
                    </a>
                    <span style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:8px;font-size:.78rem;font-weight:700;background:#2f7265;color:#fff;cursor:default;">
                        <i class="fas fa-screwdriver-wrench"></i> Reparación
                    </span>
                </div>
            </div>
        </div>

        <div class="gi-body">
            <div class="gi-cols-wrap">

                {{-- ── COLUMNA IZQUIERDA ── --}}
                <div class="gi-col-card">
                    <div class="gi-col-header">
                        <div class="gi-col-icon">
                            <img src="{{ asset('iconos/gi-col-izquierda.png') }}" class="gi-icon-img" alt="">
                        </div>
                        <span class="gi-col-title">Columna izquierda</span>
                    </div>

                    <div class="gi-slots-stack" id="stack-izq"></div>

                    <button type="button" class="btn-upload-col" onclick="selectMultiple('izq')">
                        <img src="{{ asset('iconos/gi-subir.png') }}" class="gi-btn-icon" alt="">
                        Subir imágenes
                    </button>
                    <input type="file" id="multi-input-izq" accept="image/jpeg,image/png,image/webp" multiple style="display:none">
                    <span class="gi-hint">jpg · png · webp · Máx. 3MB · hasta 3 imágenes</span>
                </div>

                {{-- ── COLUMNA DERECHA ── --}}
                <div class="gi-col-card">
                    <div class="gi-col-header">
                        <div class="gi-col-icon">
                            <img src="{{ asset('iconos/gi-col-derecha.png') }}" class="gi-icon-img" alt="">
                        </div>
                        <span class="gi-col-title">Columna derecha</span>
                    </div>

                    <div class="gi-slots-stack" id="stack-der"></div>

                    <button type="button" class="btn-upload-col" onclick="selectMultiple('der')">
                        <img src="{{ asset('iconos/gi-subir.png') }}" class="gi-btn-icon" alt="">
                        Subir imágenes
                    </button>
                    <input type="file" id="multi-input-der" accept="image/jpeg,image/png,image/webp" multiple style="display:none">
                    <span class="gi-hint">jpg · png · webp · Máx. 3MB · hasta 3 imágenes</span>
                </div>

            </div>

            {{-- ── PANEL VISTA PREVIA ── --}}
            <div class="gi-preview-panel">
                <span class="gi-preview-label">Vista previa</span>
                <div class="gi-mini-canvas">
                    <div class="gi-mini-col" id="mini-izq"></div>
                    <div class="gi-mini-form">
                        @foreach([55,100,70,100,45,100,60] as $w)
                            <div class="gi-fake-field" style="width:{{$w}}%"></div>
                        @endforeach
                    </div>
                    <div class="gi-mini-col" id="mini-der"></div>
                </div>
                <button type="button" class="btn-save" onclick="guardarDiseno()">
                    <img src="{{ asset('iconos/gi-guardar.png') }}" class="gi-btn-icon" alt="">
                    Guardar Cambios
                </button>
            </div>

        </div>
    </div>

<style>
html, body {
    overflow: hidden !important;
    height: 100vh;
    margin: 0; padding: 0;
    background: linear-gradient(135deg, #e4f6e8, #d5efe0);
}
footer, .bg-gradient-to-r, [class*="barra-verde"], .fixed-bottom-bar {
    display: none !important;
}
.gi-root {
    display: flex; flex-direction: column;
    height: calc(100vh - 40px); width: 100%;
    padding: 16px 20px; box-sizing: border-box;
    gap: 14px; font-family: system-ui, -apple-system, sans-serif;
}

/* ── Topbar ── */
.gi-topbar { display:flex; align-items:center; gap:20px; flex-shrink:0; }
.gi-topbar > div { display:flex; flex-direction:column; justify-content:center; }
.gi-topbar h1 { font-size:1.5rem; font-weight:800; color:#1f4f47; margin:0; }
.gi-topbar p  { font-size:.88rem; color:#5d7d77; margin:4px 0 0; }

.btn-back {
    background:linear-gradient(135deg,#4e9b88,#2f7265);
    color:#fff; border:none; padding:11px 16px; border-radius:12px;
    font-size:.88rem; font-weight:700; cursor:pointer;
    display:flex; align-items:center; gap:8px;
    box-shadow:0 6px 16px rgba(0,0,0,.12); transition:.22s; flex-shrink:0;
}
.btn-back:hover { transform:translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.18); }

/* ── Íconos ── */
.gi-btn-icon { width:16px; height:16px; object-fit:contain; flex-shrink:0; }
.gi-icon-img { width:20px; height:20px; object-fit:contain; }
.gi-placeholder-icon { width:36px; height:36px; object-fit:contain; opacity:.35; }

/* ── Body layout ── */
.gi-body { display:flex; gap:16px; flex:1; min-height:0; overflow:hidden; }
.gi-cols-wrap { display:flex; gap:14px; flex:1; min-height:0; }

/* ── Tarjeta de columna ── */
.gi-col-card {
    background:linear-gradient(180deg,#f8fffa,#eef8f2);
    border:1px solid #b8d8c1; border-radius:18px;
    padding:14px 12px 12px;
    display:flex; flex-direction:column; align-items:center; gap:10px;
    flex:1; min-height:0; overflow:hidden; box-sizing:border-box;
    box-shadow:0 8px 18px rgba(0,0,0,.08);
}

/* ── Header de columna ── */
.gi-col-header { display:flex; align-items:center; gap:10px; width:100%; }
.gi-col-icon {
    width:36px; height:36px; border-radius:50%; background:#2f7265;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.gi-col-title { font-size:.9rem; font-weight:800; color:#1f4f47; }

/* ── Stack de slots ── */
.gi-slots-stack {
    display:flex; flex-direction:column; gap:8px;
    width:100%; flex:1; min-height:0; overflow-y:auto;
}

/* ── Slot vacío (placeholder grande cuando no hay imágenes) ── */
.gi-slot-empty {
    flex:1; min-height:80px;
    border:1.5px dashed #c8dcd2; border-radius:12px;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:6px; color:#9fbdb6; font-size:.75rem; font-weight:600;
    background:#f4faf6; cursor:pointer; transition:.2s;
}
.gi-slot-empty:hover { background:#e6f4ec; border-color:#7dc4aa; }

/* ── Cada slot con imagen ── */
.gi-slot-item {
    width:100%; flex:1; min-height:60px;
    position:relative; border-radius:12px; overflow:hidden;
    flex-shrink:0;
}
.gi-img-box {
    width:100%; height:100%; min-height:60px;
    border-radius:12px; overflow:hidden;
    border:1.5px solid #9fcebc;
}
.gi-img-box img { width:100%; height:100%; object-fit:cover; display:block; }

/* ── Tachito flotante ── */
.btn-clear {
    position:absolute; top:6px; right:6px;
    width:26px; height:26px; border-radius:50%;
    background:rgba(192,57,43,.88);
    border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    transition:.18s; z-index:20;
    box-shadow:0 2px 6px rgba(0,0,0,.3);
    opacity:0;
}
.gi-slot-item:hover .btn-clear { opacity:1; }
.btn-clear:hover { background:#e74c3c; transform:scale(1.15); }
.btn-clear img { width:12px; height:12px; object-fit:contain; filter:brightness(0) invert(1); }

/* ── Botón subir ── */
.btn-upload-col {
    width:100%; padding:10px 12px; border-radius:12px;
    border:none; background:linear-gradient(135deg,#4e9b88,#2f7265);
    color:#fff; font-size:.82rem; font-weight:700;
    cursor:pointer; display:flex; align-items:center;
    justify-content:center; gap:8px; transition:.2s; flex-shrink:0;
    box-shadow:0 4px 12px rgba(47,114,101,.25);
}
.btn-upload-col:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(47,114,101,.35); }
.btn-upload-col:disabled { opacity:.5; cursor:not-allowed; transform:none; }

.gi-hint { font-size:.62rem; color:#92aca4; text-align:center; flex-shrink:0; }
.hidden { display:none !important; }

/* ── Panel vista previa ── */
.gi-preview-panel {
    width:300px; flex-shrink:0;
    background:linear-gradient(180deg,#fff,#eef8f2);
    border:1px solid #b8d8c1; border-radius:18px; padding:14px;
    display:flex; flex-direction:column; gap:12px; min-height:0;
    box-sizing:border-box; box-shadow:0 8px 18px rgba(0,0,0,.08);
}
.gi-preview-label {
    font-size:.7rem; font-weight:800; letter-spacing:1.5px;
    text-transform:uppercase; color:#2f7265;
}
.gi-mini-canvas {
    display:flex; gap:8px; flex:1; min-height:0; overflow:hidden;
    background:#f8fcf9; border:1px solid #d7e8dc; border-radius:10px;
    padding:8px; box-sizing:border-box;
}
.gi-mini-col { width:42px; flex-shrink:0; display:flex; flex-direction:column; gap:3px; }
.gi-mini-col .mini-img { flex:1; background:#9FE1CB; border-radius:3px; min-height:8px; }
.gi-mini-form { flex:1; display:flex; flex-direction:column; justify-content:center; gap:6px; }
.gi-fake-field { height:7px; background:#d7e4db; border-radius:4px; }

.btn-save {
    background:linear-gradient(135deg,#4ea97d,#2f7265);
    color:#fff; border:none; padding:14px; border-radius:12px;
    font-size:.95rem; font-weight:800; cursor:pointer; transition:.25s;
    display:flex; align-items:center; justify-content:center; gap:8px; flex-shrink:0;
}
.btn-save:hover { transform:translateY(-2px); }
/* ── Toast notificación ── */
.gi-toast {
    position:fixed; bottom:28px; left:50%; transform:translateX(-50%) translateY(20px);
    background:linear-gradient(135deg,#2f7265,#1f4f47);
    color:#fff; padding:12px 28px; border-radius:14px;
    font-size:.9rem; font-weight:700; letter-spacing:.3px;
    box-shadow:0 8px 24px rgba(0,0,0,.22);
    opacity:0; transition:opacity .3s, transform .3s;
    pointer-events:none; z-index:9999; white-space:nowrap;
    display:flex; align-items:center; gap:10px;
}
.gi-toast.show { opacity:1; transform:translateX(-50%) translateY(0); }
.gi-toast svg { flex-shrink:0; }
</style>

@php
$_stateDefault = [
    'izq_1' => null, 'izq_2' => null, 'izq_3' => null,
    'der_1' => null, 'der_2' => null, 'der_3' => null,
];
$_stateData = $imagenesActuales ?? $_stateDefault;
@endphp
<script>
const MAX_SLOTS = 3;
const state = @json($_stateData);

document.addEventListener('DOMContentLoaded', () => {
    renderColumn('izq');
    renderColumn('der');
});

/* ─── RENDERIZAR COLUMNA ─── */
function renderColumn(col) {
    const stack = document.getElementById(`stack-${col}`);
    stack.innerHTML = '';

    // Recopilar imágenes activas (compactar huecos)
    const imgs = [];
    for (let i = 1; i <= MAX_SLOTS; i++) {
        if (state[`${col}_${i}`]) imgs.push(state[`${col}_${i}`]);
    }

    // Reasignar state limpio sin huecos
    for (let i = 1; i <= MAX_SLOTS; i++) {
        state[`${col}_${i}`] = imgs[i - 1] ?? null;
    }

    if (imgs.length === 0) {
        // Mostrar placeholder grande invitando a subir
        const empty = document.createElement('div');
        empty.className = 'gi-slot-empty';
        empty.id = `empty-${col}`;
        empty.onclick = () => document.getElementById(`multi-input-${col}`).click();
        empty.innerHTML = `
            <img src="{{ asset('iconos/gi-placeholder.png') }}" class="gi-placeholder-icon" alt="">
            <span>Clic para subir imágenes</span>
        `;
        stack.appendChild(empty);
    } else {
        imgs.forEach((src, idx) => {
            const key  = `${col}_${idx + 1}`;
            const item = document.createElement('div');
            item.className = 'gi-slot-item';
            item.id = `slot-${key}`;
            item.innerHTML = `
                <div class="gi-img-box" id="box-${key}">
                    <img id="img-${key}" src="${src}" alt="">
                </div>
                <button type="button" class="btn-clear" id="clear-${key}"
                        onclick="clearSlot('${key}')">
                    <img src="{{ asset('iconos/gi-quitar.png') }}" alt="quitar">
                </button>
            `;
            stack.appendChild(item);
        });
    }

    // Deshabilitar botón de subir si ya hay 3
    const btn = document.querySelector(`#stack-${col}`)?.closest('.gi-col-card')?.querySelector('.btn-upload-col');
    if (btn) btn.disabled = (imgs.length >= MAX_SLOTS);

    updateMiniPreview();
}

/* ─── QUITAR IMAGEN ─── */
function clearSlot(key) {
    const col = key.split('_')[0];
    state[key] = null;
    renderColumn(col); // re-render compacta automáticamente
}

/* ─── MINI VISTA PREVIA ─── */
function updateMiniPreview() {
    ['izq', 'der'].forEach(col => {
        const mini = document.getElementById(`mini-${col}`);
        mini.innerHTML = '';
        for (let i = 1; i <= MAX_SLOTS; i++) {
            const src = state[`${col}_${i}`];
            if (!src) continue;
            const d = document.createElement('div');
            d.className = 'mini-img';
            d.style.backgroundImage    = `url(${src})`;
            d.style.backgroundSize     = 'cover';
            d.style.backgroundPosition = 'center';
            mini.appendChild(d);
        }
        if (!mini.children.length) {
            const d = document.createElement('div');
            d.className = 'mini-img';
            d.style.opacity = '.3';
            mini.appendChild(d);
        }
    });
}

/* ─── SELECCIÓN MÚLTIPLE (CORREGIDO) ─── */
function selectMultiple(col) {
    const input = document.getElementById(`multi-input-${col}`);
    input.onchange = function () {
        const files = Array.from(this.files);

        // Encontrar cuántos slots vacíos quedan reales en la interfaz
        const emptySlots = [];
        for (let i = 1; i <= MAX_SLOTS; i++) {
            if (!state[`${col}_${i}`]) emptySlots.push(`${col}_${i}`);
        }

        if (!emptySlots.length) {
            alert('Esta columna ya tiene 3 imágenes. Quita alguna primero.');
            this.value = ''; return;
        }

        // Cortar la lista de archivos según los espacios disponibles
        const filesToProcess = files.slice(0, emptySlots.length);
        let completedCount = 0;

        filesToProcess.forEach((file, idx) => {
            if (file.size > 3 * 1024 * 1024) {
                alert(`"${file.name}" supera los 3MB y fue omitido.`);
                completedCount++;
                // Si todos terminaron (o fallaron/omitieron), renderizar de golpe
                if (completedCount === filesToProcess.length) renderColumn(col);
                return;
            }

            const r = new FileReader();
            r.onload = e => {
                state[emptySlots[idx]] = e.target.result;
                completedCount++;
                
                // CONTROL CRÍTICO ASÍNCRONO: Solo renderiza cuando ABSOLUTAMENTE TODOS los archivos terminen
                if (completedCount === filesToProcess.length) {
                    renderColumn(col);
                }
            };
            r.onerror = () => {
                completedCount++;
                if (completedCount === filesToProcess.length) renderColumn(col);
            };
            r.readAsDataURL(file);
        });

        if (files.length > emptySlots.length) {
            alert(`Solo había ${emptySlots.length} espacio(s) libre(s). Las imágenes sobrantes se ignoraron.`);
        }

        this.value = ''; // Limpiar input para permitir re-subir los mismos archivos si se desea
    };
    input.click();
}

/* ─── GUARDAR ─── */
function guardarDiseno() {
    const payload = {
        izq_1: state['izq_1'] ?? null,
        izq_2: state['izq_2'] ?? null,
        izq_3: state['izq_3'] ?? null,
        der_1: state['der_1'] ?? null,
        der_2: state['der_2'] ?? null,
        der_3: state['der_3'] ?? null,
    };

    const token   = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    const btnSave = document.querySelector('.btn-save');
    const origHtml = btnSave.innerHTML;
    btnSave.disabled  = true;
    btnSave.innerHTML = 'Guardando…';

    fetch('/employees/admin/reparacion/imagenes', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(r => { if (!r.ok) throw new Error('Status: ' + r.status); return r.json(); })
    .then(data => {
        if (data.success) {
            if (data.imagenes) {
                Object.keys(data.imagenes).forEach(key => {
                    state[key] = data.imagenes[key] || null;
                });
                renderColumn('izq');
                renderColumn('der');
            }
            showToast();
        } else {
            alert('Error al guardar: ' + data.message);
        }
    })
    .catch(err => { console.error(err); alert('Error al conectarse con el servidor.'); })
    .finally(() => { btnSave.disabled = false; btnSave.innerHTML = origHtml; });
}

function showToast() {
    const toast = document.getElementById('gi-toast');
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}
</script>

<div class="gi-toast" id="gi-toast">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    ¡Cambios realizados!
</div>

</x-app-layout>