<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Administrador
        </h2>
    </x-slot>

    {{-- Bootstrap (mejor en layout, pero aquí funciona) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="py-4">
        <div class="container mt-4">
            <h1 class="text-2xl font-bold" style="color: white; text-align:center;">Administrador</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-users fa-4x text-light"></i>
                        <h3 class="text-light mt-3">Empleados</h3>
                        <a href="{{ route('employees.index') }}" class="btn btn-light mt-2">Gestionar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-tags fa-4x text-warning"></i>
                        <h3 class="text-light mt-3">Categorías</h3>
                        <a href="{{ route('categorias.index') }}" class="btn btn-light mt-2">Ver categorías</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-stethoscope fa-4x text-danger"></i>
                        <h3 class="text-light mt-3">Equipos Médicos</h3>
                        <a href="{{ route('productos.index') }}" class="btn btn-light mt-2">Administrar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-palette fa-4x text-success"></i>
                        <h3 class="text-light mt-3">Colores</h3>
                        <a href="{{ route('colors.index') }}" class="btn btn-light mt-2">Gestionar Colores</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-headset fa-4x text-info"></i>
                        <h3 class="text-light mt-3">Soporte y Quejas</h3>
                        <a href="{{ route('reportes.index') }}" class="btn btn-light mt-2">Atender</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-shopping-cart fa-4x text-warning"></i>
                        <h3 class="text-light mt-3">Pedidos</h3>
                        <a href="/gestion-pedidos" class="btn btn-light mt-2">Ver pedidos</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-tools fa-4x text-light"></i>
                        <h3 class="text-light mt-3">Mantenimiento y Reparación</h3>
                        <a href="/mantenimientos" class="btn btn-light mt-2">Gestionar servicios</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-star fa-4x text-warning"></i>
                        <h3 class="text-light mt-3">Reseñas</h3>
                        <a href="/reseñas" class="btn btn-light mt-2">Gestionar Reseñas</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-chart-line fa-4x text-primary"></i>
                        <h3 class="text-light mt-3">Productos más vendidos</h3>
                        <a href="{{ route('top-products.index') }}" class="btn btn-light mt-2">Gestionar productos</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-comments fa-4x text-info"></i>
                        <h3 class="text-light mt-3">Comentarios</h3>
                        <a href="{{ route('comentarios.index') }}" class="btn btn-light mt-2">Gestionar Comentarios</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-images fa-4x text-success"></i>
                        <h3 class="text-light mt-3">Imagenes Sitio</h3>
                        <a href="{{ route('imagenes.index') }}" class="btn btn-light mt-2">Gestionar Imagenes</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .bg-custom { background-color: #28666e; border-radius: 15px; }
        .text-light { color: #fedc97 !important; }
        .btn-light { background-color: #fedc97; color: #28666e; border: none; font-size: 1.2em; padding: 10px 20px; border-radius: 8px; }
        .btn-light:hover { background-color: #ffffff; color: #234d50; }
        .card i { transition: transform 0.3s ease-in-out; }
        .card:hover i { transform: scale(1.1); }
    </style>

    @if(session('success'))
        <script>alert(@json(session('success')));</script>
    @endif
</x-app-layout>

main, .container, .py-4 {
  position: relative;
  z-index: 50;
}
