<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <br>
    <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Tecnico</h1>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">

            {{-- Servicios: Mantenimiento y Reparación --}}
            <div class="col">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-tools fa-4x text-success"></i>
                    <h3 class="text-light mt-3">Mantenimiento y Reparación</h3>
                    <a href="/mantenimientos" class="btn btn-light mt-2">Gestionar servicios</a>
                </div>
            </div>

            {{-- Tarjetas vacías para rellenar la fila --}}
            <div class="col"></div>
            <div class="col"></div>

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