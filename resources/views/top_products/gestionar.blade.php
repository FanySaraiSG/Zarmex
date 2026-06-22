<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<title>Gestionar Secciones</title>

<style>
:root {
    --bg-light-green:    #a7f3d0;
    --panel-white:       #ffffff;
    --table-header-green:#e6f4ea;
    --table-hover-green: #f1f9f5;
    --mint-accent:       #198754;
    --forest-text:       #0f4c3a;
    --border-light:      #dee2e6;
}

body {
    background: linear-gradient(135deg, #a7f3d0 0%, #86efac 100%);
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: var(--forest-text);
    min-height: 100vh;
}

header, footer, .whatsapp, #whatsapp { display: none !important; }

/* Panel principal */
.panel-box {
    background: var(--panel-white);
    border: 1px solid var(--border-light);
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.panel-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--forest-text);
}

/* Tabla */
.green-table-responsive {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--border-light);
}

.table-green {
    margin-bottom: 0;
    background-color: var(--panel-white) !important;
    color: var(--forest-text);
    vertical-align: middle;
}

.table-green thead th {
    background-color: var(--table-header-green) !important;
    color: var(--forest-text);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    padding: 16px;
    border-bottom: 1px solid var(--border-light);
}

.table-green tbody tr {
    border-bottom: 1px solid var(--border-light);
    background-color: var(--panel-white) !important;
    transition: background-color 0.2s ease;
}

.table-green tbody tr:hover {
    background-color: var(--table-hover-green) !important;
}

.table-green tbody td {
    padding: 14px 16px;
    color: var(--forest-text);
    background-color: transparent !important;
}

/* Inputs */
.table-input {
    background-color: #ffffff;
    color: var(--forest-text);
    border: 1px solid #ced4da;
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.table-input:focus {
    border-color: var(--mint-accent);
    box-shadow: 0 0 0 3px rgba(25,135,84,0.15);
    outline: none;
}

/* Botones */
.btn-mint {
    background-color: #198754;
    color: #ffffff;
    font-weight: 500;
    border-radius: 6px;
    padding: 8px 16px;
    border: none;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.btn-mint:hover { background-color: #146c43; color: white; }

.btn-outline-green {
    background-color: transparent;
    color: var(--forest-text);
    border: 1px solid #198754;
    border-radius: 6px;
    font-weight: 500;
    padding: 8px 16px;
    transition: all 0.2s;
}
.btn-outline-green:hover {
    background-color: #e6f4ea;
    color: var(--forest-text);
    border-color: #198754;
}

.btn-table-edit {
    background-color: transparent;
    color: #198754;
    border: 1px solid #dee2e6;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s;
}
.btn-table-edit:hover { background-color: #e6f4ea; color: #146c43; }

.btn-table-delete {
    background-color: transparent;
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s;
}
.btn-table-delete:hover { background-color: #dc2626; color: white; }

/* Toast flotante */
.toast-green-sync {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background-color: #ffffff;
    color: var(--forest-text);
    border: 1px solid var(--mint-accent);
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    z-index: 9999;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    pointer-events: none;
}
.toast-green-sync.show { opacity: 1; transform: translateY(0); }

/* Estado vacío */
.empty-state {
    text-align: center;
    padding: 40px 16px;
    color: #6c757d;
    font-size: 0.95rem;
}
</style>
</head>

<body>

<div class="container my-5">
    <div class="panel-box">

        {{-- Cabecera --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">

            <a class="btn btn-outline-green" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>

            <h2 class="panel-title mb-0">Gestionar Secciones</h2>

            <div class="d-flex gap-2">
                <input type="text"
                       class="table-input"
                       id="newSectionName"
                       placeholder="Nombre de la nueva sección..."
                       style="min-width: 220px;">
                <button type="button" class="btn btn-mint" id="btnCreateSection">
                    <i class="bi bi-plus-lg"></i> Agregar sección
                </button>
            </div>

        </div>

        {{-- Contador --}}
        <p class="text-muted small mb-2" id="contadorSecciones"></p>

        {{-- Tabla --}}
        <div class="green-table-responsive table-responsive">
            <table class="table table-green">
                <thead>
                    <tr>
                        <th style="width: 12%;">#</th>
                        <th style="width: 63%;">Nombre de la Sección</th>
                        <th style="width: 25%;" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sectionsTbody"></tbody>
            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Estado inicial desde Blade ──────────────────────────────────────────
    let secciones = @json(
        $topProducts->pluck('section')->unique()->filter()->values()
    );

    const tbody     = document.getElementById('sectionsTbody');
    const contador  = document.getElementById('contadorSecciones');
    const inputNueva = document.getElementById('newSectionName');
    const btnCreate  = document.getElementById('btnCreateSection');

    // ── Toast ───────────────────────────────────────────────────────────────
    function toast(mensaje, error = false) {
        const t = document.createElement('div');
        t.className = 'toast-green-sync';
        const icon  = error ? 'bi-x-circle-fill" style="color:#dc2626' : 'bi-check-circle-fill" style="color:var(--mint-accent)';
        t.innerHTML = `<i class="bi ${icon}; font-size:1.2rem;"></i> ${mensaje}`;
        document.body.appendChild(t);
        setTimeout(() => t.classList.add('show'), 50);
        setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 2200);
    }

    // ── Renderizado dinámico ────────────────────────────────────────────────
    function renderTabla() {
        tbody.innerHTML = '';
        contador.textContent = `${secciones.length} sección${secciones.length !== 1 ? 'es' : ''}`;

        if (secciones.length === 0) {
            tbody.innerHTML = `<tr><td colspan="3"><div class="empty-state">
                <i class="bi bi-folder2-open" style="font-size:2rem; display:block; margin-bottom:8px; color:#adb5bd;"></i>
                No hay secciones registradas.
            </div></td></tr>`;
            return;
        }

        secciones.forEach((seccion, index) => {
            const tr = document.createElement('tr');
            tr.dataset.sectionName = seccion;
            tr.className = 'table-row-item';

            tr.innerHTML = `
                <td class="fw-bold" style="color:#198754;">#${index + 1}</td>
                <td>
                    <span class="section-text-label fw-semibold">${ucfirst(seccion)}</span>
                    <input type="text"
                           class="table-input edit-section-input d-none"
                           value="${seccion}"
                           style="max-width: 320px;">
                </td>
                <td class="text-center">
                    <div class="d-inline-flex gap-2">
                        <button type="button" class="btn btn-table-edit btn-edit-section" title="Editar nombre">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="button" class="btn btn-mint btn-save-section d-none" title="Guardar cambios">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button type="button" class="btn btn-table-delete btn-delete-section" title="Eliminar sección">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </td>
            `;

            // Editar
            tr.querySelector('.btn-edit-section').addEventListener('click', function () {
                const label  = tr.querySelector('.section-text-label');
                const input  = tr.querySelector('.edit-section-input');
                const btnSave = tr.querySelector('.btn-save-section');

                label.classList.add('d-none');
                input.classList.remove('d-none');
                input.focus();
                input.select();
                this.classList.add('d-none');
                btnSave.classList.remove('d-none');
            });

            // Guardar con botón
            tr.querySelector('.btn-save-section').addEventListener('click', () => {
                const input = tr.querySelector('.edit-section-input');
                guardarRename(seccion, input.value);
            });

            // Guardar con Enter
            tr.querySelector('.edit-section-input').addEventListener('keyup', (e) => {
                if (e.key === 'Enter') guardarRename(seccion, e.target.value);
                if (e.key === 'Escape') renderTabla(); // cancelar con Escape
            });

            // Eliminar
            tr.querySelector('.btn-delete-section').addEventListener('click', () => {
                eliminarSeccion(seccion, tr);
            });

            tbody.appendChild(tr);
        });
    }

    // ── Helpers ─────────────────────────────────────────────────────────────
    function ucfirst(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    }

    // ── Renombrar sección ───────────────────────────────────────────────────
    async function guardarRename(nombreViejo, nombreNuevo) {
        nombreNuevo = nombreNuevo.trim().toLowerCase();

        if (!nombreNuevo) { renderTabla(); return; }
        if (nombreViejo === nombreNuevo) { renderTabla(); return; }

        if (secciones.includes(nombreNuevo)) {
            toast('Ya existe una sección con ese nombre.', true);
            return;
        }

        try {
            const res  = await fetch('/employees/top-products/rename-section', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ old_section: nombreViejo, new_section: nombreNuevo })
            });
            const data = await res.json();

            if (data.success) {
                const i = secciones.indexOf(nombreViejo);
                if (i !== -1) secciones[i] = nombreNuevo;
                renderTabla();
                toast(`Sección renombrada a "${ucfirst(nombreNuevo)}"`);
            } else {
                toast('No se pudo renombrar la sección.', true);
                renderTabla();
            }
        } catch (e) {
            console.error(e);
            toast('Error de conexión al renombrar.', true);
            renderTabla();
        }
    }

    // ── Eliminar sección ────────────────────────────────────────────────────
    async function eliminarSeccion(nombre, tr) {
        try {
            const checkRes  = await fetch(`/employees/top-products/check-section/${nombre}`);
            const checkData = await checkRes.json();
            const cantidad  = checkData.count ?? 0;

            const msg = cantidad > 0
                ? `La sección "${nombre}" tiene ${cantidad} producto${cantidad !== 1 ? 's' : ''} asociado${cantidad !== 1 ? 's' : ''}. Si la eliminas, se removerán todos esos registros. ¿Proceder de todas formas?`
                : `¿Seguro que deseas eliminar la sección "${nombre}"?`;

            if (!confirm(msg)) return;

            const delRes  = await fetch(`/employees/top-products/section/${nombre}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept':       'application/json'
                }
            });
            const delData = await delRes.json();

            if (delData.success) {
                // Animación de salida antes de quitar del array
                tr.style.transition  = 'all 0.3s ease';
                tr.style.opacity     = '0';
                tr.style.backgroundColor = '#fde8e8';
                setTimeout(() => {
                    secciones = secciones.filter(s => s !== nombre);
                    renderTabla();
                    toast('Sección eliminada correctamente.');
                }, 300);
            } else {
                toast('No se pudo eliminar la sección.', true);
            }
        } catch (e) {
            console.error(e);
            toast('Error de conexión al eliminar.', true);
        }
    }

    // ── Crear sección ───────────────────────────────────────────────────────
    btnCreate.addEventListener('click', crearSeccion);
    inputNueva.addEventListener('keyup', (e) => { if (e.key === 'Enter') crearSeccion(); });

    async function crearSeccion() {
        const nueva = inputNueva.value.trim().toLowerCase();

        if (!nueva) {
            toast('Por favor escribe un nombre de sección válido.', true);
            return;
        }
        if (secciones.includes(nueva)) {
            toast('Esta sección ya existe.', true);
            return;
        }

        try {
            const res  = await fetch('/employees/top-products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ section: nueva })
            });
            const data = await res.json();

            if (data.success) {
                secciones.push(nueva);
                inputNueva.value = '';
                renderTabla();
                toast(`Sección "${ucfirst(nueva)}" creada correctamente.`);
            } else {
                toast(data.message ?? 'No se pudo crear la sección.', true);
            }
        } catch (e) {
            console.error(e);
            toast('Error de conexión al crear la sección.', true);
        }
    }

    // ── Arranque ────────────────────────────────────────────────────────────
    renderTabla();
});
</script>

</body>
</html>
@endauth
</x-app-layout>