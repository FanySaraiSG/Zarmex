<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <br>
    <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Soporte</h1>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">

            {{-- Soporte y Quejas --}}
            <div class="col">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-headset fa-4x text-info"></i>
                    <h3 class="text-light mt-3">Soporte y Quejas</h3>
                    <a href="{{ route('reportes.index') }}" class="btn btn-light mt-2">Atender</a>
                </div>
            </div>

            {{-- Pedidos --}}
            <div class="col">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-shopping-cart fa-4x text-warning"></i>
                    <h3 class="text-light mt-3">Pedidos</h3>
                    <a href="/gestion-pedidos" class="btn btn-light mt-2">Ver pedidos</a>
                </div>
            </div>

            {{-- Soporte: Reseñas --}}
            <div class="col">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-tools fa-4x text-success"></i>
                    <h3 class="text-light mt-3">Reseñas</h3>
                    <a href="/reseñas" class="btn btn-light mt-2">Gestionar Reseñas</a>
                </div>
            </div>

            {{-- Comentarios --}}
            <div class="col">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-comments fa-4x text-info"></i>
                    <h3 class="text-light mt-3">Comentarios</h3>
                    <a href="{{ route('comentarios.index') }}" class="btn btn-light mt-2">Gestionar Comentarios</a>
                </div>
            </div>

        </div>
    </div>

    <style>
        .bg-custom {
            background-color: #28666e;
            border-radius: 15px;
        }

        .text-light {
            color: #fedc97 !important;
        }

        .btn-light {
            background-color: #fedc97;
            color: #28666e;
            border: none;
            font-size: 1.2em;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-light:hover {
            background-color: #ffffff;
            color: #234d50;
        }

        .card i {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover i {
            transform: scale(1.1);
        }
    </style>
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>