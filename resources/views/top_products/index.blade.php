<x-app-layout>
@auth('employee')
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Top Productos</title>

<style>
:root{
    --zx-dark: #234d50;
    --zx-mid: #3f6f76;
    --zx-soft: #d9d9d9;
    --zx-border: #c7cdcf;
    --zx-white: #ffffff;
    --zx-blue: #3d6ee8;
}

/* fondo */
body{
    background: #0f1720;
}

/* contenedor */
.crud-box{
    background: var(--zx-soft);
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0 10px 30px rgba(77, 19, 19, 0.12);
}

/* título */
.crud-title{
    text-align: center;
    color: var(--zx-dark);
    font-weight: 800;
    margin-bottom: 20px;
}

/* tabla */
.table{
    background: white;
    border-radius: 14px;
    overflow: hidden;
}

.table thead th{
    background: var(--zx-mid);
    color: white;
    text-align: center;
}

.table tbody td{
    text-align: center;
    background: #efefef;
}

/* botón */
.btn-back{
    background: #2f555b;
    color: white;
    border-radius: 16px;
    padding: 10px 20px;
    font-weight: 700;
    border: none;
}

.btn-back:hover{
    background: #24464b;
}

/* select bonito */
.select-product{
    border: none;
    outline: none;
    border-radius: 20px;
    padding: 8px 14px;
    font-weight: 600;
    cursor: pointer;
    background: #e0e0e0;
}

/* hover */
.select-product:hover{
    background: #d4d4d4;
}

header, footer, .whatsapp, #whatsapp{
    display:none !important;
}
</style>
</head>

<body>

<div class="container mt-4">
    <div class="crud-box">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
            <a class="btn btn-back" href="{{ route('admin.dashboard') }}">
                ← Regresar
            </a>

            <div class="d-flex align-items-center gap-2">
                <select class="select-product" id="newBestSection" style="min-width: 180px;">
                    <option value="todos">Todos</option>
                    <option value="novedades">Novedades</option>
                    <option value="populares">Populares</option>
                </select>

                <button type="button" class="btn btn-back" id="btnAddTopProduct" style="background:#1b5a61;">+ Agregar</button>
            </div>
        </div>

        <h2 class="crud-title">Top Productos Destacados</h2>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Sección</th>
                        <th>Acciones</th>
                    </tr>

                </thead>


                <tbody id="topProductsTbody">
                    @foreach ($topProducts as $topProduct)
                    <tr data-top-product-id="{{ $topProduct->id }}">
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <select class="select-product auto-submit"
                                data-id="{{ $topProduct->id }}">

                                <option value="">Ninguno</option>

                                @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ $topProduct->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->id }}
                                </option>
                                @endforeach

                            </select>
                        </td>

                        <td>
                            <select class="select-product auto-submit auto-submit-section"
                                data-id="{{ $topProduct->id }}"
                                data-section-current="{{ $topProduct->section ?? 'todos' }}">

                                <option value="todos" {{ ($topProduct->section ?? 'todos') === 'todos' ? 'selected' : '' }}>Todos</option>
                                <option value="novedades" {{ ($topProduct->section ?? 'todos') === 'novedades' ? 'selected' : '' }}>Novedades</option>
                                <option value="populares" {{ ($topProduct->section ?? 'todos') === 'populares' ? 'selected' : '' }}>Populares</option>

                            </select>
                        </td>

                        <td>
                            <button type="button" class="btn btn-back btn-delete" style="background:#7a2b2b; padding: 10px 14px;" title="Eliminar">
                                Eliminar
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
    // Actualizar (PUT) al cambiar selects
    document.querySelectorAll('.auto-submit').forEach(select => {
        select.addEventListener('change', function() {
            let productId = this.value;
            let topProductId = this.dataset.id;

            fetch(`/employees/top-products/${topProductId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    section: select.closest('tr').querySelector('.auto-submit-section')?.value || 'todos'
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
            })
            .catch(err => {
                console.error(err);
                alert('Error al actualizar');
            });
        });
    });

    // Eliminar
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', async function() {
            const tr = btn.closest('tr');
            const topProductId = tr?.dataset.topProductId;
            if (!topProductId) return;

            if (!confirm('¿Eliminar este registro de TopProduct?')) return;

            try {
                const res = await fetch(`/employees/top-products/${topProductId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json().catch(() => ({}));

                tr?.remove();
            } catch (e) {
                console.error(e);
                alert('Error al eliminar');
            }
        });
    });

    // Agregar (CREATE)
    const btnAdd = document.getElementById('btnAddTopProduct');
    const newSection = document.getElementById('newBestSection');

    btnAdd?.addEventListener('click', async function() {
        const section = newSection?.value || 'todos';

        try {
            const res = await fetch(`/employees/top-products`, {
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
            const data = await res.json();

            // Recargar para evitar lógica de pintar fila
            window.location.reload();
        } catch (e) {
            console.error(e);
            alert('Error al agregar');
        }
    });
});
</script>


</body>
</html>
@endauth
</x-app-layout>