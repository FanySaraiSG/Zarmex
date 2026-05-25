<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<title>Control de Productos - Destacados Claros</title>

<style>
:root {
    /* Paleta de Verdes Claros Armoniosos */
    --bg-light-green: #f2f9f6;    /* Fondo general */
    --panel-white: #ffffff;        /* Fondo del contenedor principal */
    --table-header-green: #e1f2eb;/* Fondo del encabezado */
    --table-hover-green: #f0f7f4; /* Fondo al pasar el cursor*/
    --mint-accent: #22c55e;       /* Color de éxito y acento */
    --forest-text: #164e35;       /* Texto principal  */
    --muted-green: #60a582;       /* Texto secundario y bordes suaves */
    --border-light: #d1e7dd;      /* Líneas divisorias de la tabla */
}

body {
    background-color: var(--bg-light-green);
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: var(--forest-text);
}

/* Contenedor del Panel */
.panel-box {
    background: var(--panel-white);
    border: 1px solid var(--border-light);
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(22, 78, 53, 0.05);
}

.panel-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--forest-text);
    letter-spacing: -0.01em;
}

/* TABLA EN LÍNEA VERDE CLARA */
.green-table-responsive {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--border-light);
}

.table-green {
    margin-bottom: 0;
    background-color: var(--panel-white);
    color: var(--forest-text);
    vertical-align: middle;
}

/* Encabezado de la tabla */
.table-green thead th {
    background-color: var(--table-header-green);
    color: var(--forest-text);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    padding: 14px 16px;
    border-bottom: 2px solid var(--border-light);
}

/* Filas de la tabla */
.table-green tbody tr {
    border-bottom: 1px solid var(--border-light);
    background-color: var(--panel-white);
    transition: background-color 0.2s ease;
}

/* Efecto hover interactivo en verde suave */
.table-green tbody tr:hover {
    background-color: var(--table-hover-green) !important;
}

.table-green tbody td {
    padding: 12px 16px;
    color: var(--forest-text);
    background-color: transparent !important;
}

/* Inputs / Selectores Claros */
.table-select {
    background-color: #ffffff;
    color: var(--forest-text);
    border: 1px solid var(--muted-green);
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    width: 100%;
    cursor: pointer;
    transition: all 0.2s ease;
}

.table-select:focus {
    border-color: var(--mint-accent);
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
    outline: none;
}

/* Botones en tonos Verdes */
.btn-mint {
    background-color: #25a266;
    color: #ffffff;
    font-weight: 600;
    border-radius: 6px;
    padding: 8px 18px;
    border: none;
    transition: all 0.2s ease;
}

.btn-mint:hover {
    background-color: #1b744a;
    color: white;
}

.btn-outline-green {
    background-color: transparent;
    color: var(--forest-text);
    border: 1px solid var(--muted-green);
    border-radius: 6px;
    font-weight: 600;
}

.btn-outline-green:hover {
    background-color: var(--table-header-green);
    color: var(--forest-text);
}

.btn-table-delete {
    background-color: transparent;
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
    padding: 6px 10px;
    border-radius: 6px;
    transition: all 0.2s;
}

.btn-table-delete:hover {
    background-color: #dc2626;
    color: white;
    border-color: #dc2626;
}

header, footer, .whatsapp, #whatsapp {
    display: none !important;
}

/* Toast Notificación Flotante Clara */
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
    box-shadow: 0 8px 24px rgba(22, 78, 53, 0.1);
    z-index: 9999;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
}

.toast-green-sync.show {
    opacity: 1;
    transform: translateY(0);
}
</style>
</head>

<body>

<div class="container my-5">
    <div class="panel-box">

        <!-- ENCABEZADO DE HERRAMIENTAS -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-4 order-2 order-sm-1">
                <a class="btn btn-outline-green" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-arrow-left-short"></i> Volver al Menú
                </a>
            </div>
            <div class="col-sm-4 text-sm-center order-1 order-sm-2">
                <h2 class="panel-title mb-0">Productos Destacados</h2>
            </div>
            <div class="col-sm-4 text-sm-end order-3 order-sm-3">
                <div class="d-inline-flex gap-2 justify-content-sm-end w-100">
                    
                    <!-- Filtro maestro integrado -->
                    <select class="table-select" id="newBestSection" style="max-width: 170px;">
                        <option value="todos"> Ver Todo</option>
                        <option value="novedades"> Novedades</option>
                        <option value="populares"> Populares</option>
                    </select>

                    <button type="button" class="btn btn-mint" id="btnAddTopProduct">
                        <i class="bi bi-plus-lg"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 mb-4" style="background-color: var(--table-header-green); color: var(--forest-text);">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLA COMPACTA CLARA -->
        <div class="green-table-responsive table-responsive">
            <table class="table table-green">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">Posición</th>
                        <th>Producto</th>
                        <th style="width: 240px;">Sección del Sitio</th>
                        <th style="width: 90px;" class="text-center">Remover</th>
                    </tr>
                </thead>

                <tbody id="topProductsTbody">
                    @foreach ($topProducts as $topProduct)
                    <tr data-top-product-id="{{ $topProduct->id }}" class="table-row-item">
                        
                        <!-- Posición secuencial -->
                        <td class="text-center fw-bold" style="color: #1b744a;">
                            #{{ $loop->iteration }}
                        </td>

                        <!-- Selector Producto -->
                        <td>
                            <select class="table-select auto-submit" data-id="{{ $topProduct->id }}">
                                <option value="">— Ningún producto seleccionado —</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $topProduct->product_id == $product->id ? 'selected' : '' }}>
                                    ID: {{ $product->id }} — {{ $product->name ?? 'Producto ' }}
                                </option>
                                @endforeach
                            </select>
                        </td>

                        <!-- Selector Sección -->
                        <td>
                            <select class="table-select auto-submit auto-submit-section" data-id="{{ $topProduct->id }}">
                                <option value="todos" {{ ($topProduct->section ?? 'todos') === 'todos' ? 'selected' : '' }}> Todos</option>
                                <option value="novedades" {{ ($topProduct->section ?? 'todos') === 'novedades' ? 'selected' : '' }}> Novedades</option>
                                <option value="populares" {{ ($topProduct->section ?? 'todos') === 'populares' ? 'selected' : '' }}> Populares</option>
                            </select>
                        </td>

                        <!-- Botón Eliminar Fila -->
                        <td class="text-center">
                            <button type="button" class="btn btn-table-delete btn-delete" title="Quitar fila">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // Sincronización automática con Toast claro
    function lanzarToastGuardado(mensaje) {
        let toast = document.createElement('div');
        toast.className = 'toast-green-sync';
        toast.innerHTML = `<i class="bi bi-check-circle-fill" style="color:var(--mint-accent); font-size:1.2rem;"></i> ${mensaje}`;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 50);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 1800);
    }
    
    // ==========================================
    // Guardado Automático (Fetch / AJAX)
    // ==========================================
    document.querySelectorAll('.auto-submit').forEach(select => {
        select.addEventListener('change', function() {
            let fila = this.closest('.table-row-item');
            let topProductId = this.dataset.id;
            
            let productSelect = fila.querySelector('.table-select:not(.auto-submit-section)');
            let sectionSelect = fila.querySelector('.auto-submit-section');

            let productId = productSelect ? productSelect.value : null;
            let sectionValue = sectionSelect ? sectionSelect.value : 'todos';

            fetch(`/employees/top-products/${topProductId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    section: sectionValue
                })
            })
            .then(res => res.json())
            .then(data => {
                lanzarToastGuardado('Cambio guardado automáticamente');
            })
            .catch(err => {
                console.error(err);
                alert('No se pudo guardar la información');
            });
        });
    });

    // ==========================================
    // Filtro en Tiempo Real por Sección
    // ==========================================
    const filterSection = document.getElementById('newBestSection');
    filterSection?.addEventListener('change', function() {
        let seccionSeleccionada = this.value;
        
        document.querySelectorAll('#topProductsTbody .table-row-item').forEach(fila => {
            let selectSeccionFila = fila.querySelector('.auto-submit-section');
            let seccionFila = selectSeccionFila ? selectSeccionFila.value : 'todos';

            if (seccionSeleccionada === 'todos' || seccionFila === seccionSeleccionada) {
                fila.style.display = ''; 
            } else {
                fila.style.display = 'none'; 
            }
        });
    });

    // Eliminación asíncrona de fila con efecto visual limpio
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', async function() {
            const fila = btn.closest('.table-row-item');
            const topProductId = fila?.dataset.topProductId;
            if (!topProductId) return;

            if (!confirm('¿Seguro que deseas eliminar esta fila de destacados?')) return;

            try {
                await fetch(`/employees/top-products/${topProductId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                fila.style.opacity = '0';
                fila.style.backgroundColor = '#fde8e8';
                fila.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    fila.remove();
                    lanzarToastGuardado('Fila eliminada correctamente');
                }, 300);

            } catch (e) {
                console.error(e);
                alert('Ocurrió un problema técnico al eliminar');
            }
        });
    });

    // Agregar nueva fila vacía
    const btnAdd = document.getElementById('btnAddTopProduct');
    const newSection = document.getElementById('newBestSection');

    btnAdd?.addEventListener('click', async function() {
        const section = newSection?.value || 'todos';

        try {
            await fetch(`/employees/top-products`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: null,
                    section
                })
            });
            window.location.reload();
        } catch (e) {
            console.error(e);
            alert('Error al agregar un nuevo espacio en la lista');
        }
    });
});
</script>

</body>
</html>
@endauth
</x-app-layout>