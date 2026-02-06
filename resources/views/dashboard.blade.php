<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <div class="container mt-5 pt-5 d-flex justify-content-center">
        <div class="row d-flex justify-content-center">
            {{-- Usuario --}}
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-user fa-4x text-light"></i>
                    <h2 class="text-light mt-3">{{ Auth::user()->name }}</h2>
                </div>
            </div>

            {{-- Pedidos --}}
            @auth
                <div class="col-md-4 mb-4 d-flex justify-content-center">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100">
                        <i class="fas fa-shopping-cart fa-4x text-warning"></i>
                        <h3 class="text-light mt-3">Pedidos</h3>
                        <a href="/pedido/{{ Auth::id() }}" class="btn btn-light mt-2">Ver pedidos</a>
                    </div>
                </div>
            @endauth

            {{-- Direcciones --}}
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-map-marker-alt fa-4x text-danger"></i>
                    <h3 class="text-light mt-3">Direcciones</h3>
                    <a href="{{ route('direcciones.index') }}" class="btn btn-light mt-2">Administrar</a>
                </div>
            </div>
            <!-- 

            {{-- Métodos de pago --}}
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-credit-card fa-4x text-success"></i>
                    <h3 class="text-light mt-3">Métodos de pago</h3>
                    <a href="/pagos" class="btn btn-light mt-2">Gestionar</a>
                </div>
            </div> -->

            {{-- Enviar Reseñas --}}
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-star fa-4x text-warning"></i>
                    <h3 class="text-light mt-3">Reseñas</h3>
                    <a href="/reseñas/create" class="btn btn-light mt-2">Enviar</a>
                </div>
            </div>

            {{-- Soporte --}}
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-headset fa-4x text-info"></i>
                    <h3 class="text-light mt-3">Soporte y quejas</h3>
                    <a href="{{ route('reportes.create') }}" class="btn btn-light mt-2">Contactar</a>
                </div>
            </div>

            {{-- Mis solicitudes --}}
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-tools fa-4x text-white"></i>
                    <h3 class="text-light mt-3">Mis solicitudes</h3>
                    <a href="{{ route('solicitudes.usuario', ['id' => Auth::id()]) }}"
                        class="btn btn-light mt-2">Ver</a>
                </div>
            </div>

        </div>
    </div>

    <style>
        .bg-custom {
            background-color: #28666e !important;
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

        nav.bg-white {
            background-color: #28666e !important;
        }
    </style>
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>