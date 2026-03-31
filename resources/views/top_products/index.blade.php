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
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,.12);
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a class="btn btn-back" href="{{ route('admin.dashboard') }}">
                ← Regresar
            </a>
        </div>

        <h2 class="crud-title">Top 5 Productos Más Vendidos</h2>

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
                    </tr>
                </thead>

                <tbody>
                    @foreach ($topProducts as $topProduct)
                    <tr>
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
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
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
                    product_id: productId
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
});
</script>

</body>
</html>
@endauth
</x-app-layout>