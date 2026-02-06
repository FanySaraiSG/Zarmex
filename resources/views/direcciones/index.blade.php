<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dirección.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body>
        <main>
            <div class="container">
                <br>
                <h2 class="text-center mb-4" style="color: white;">Direcciones de Envío</h2>
                <div class="form-group d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{route('dashboard')}}">Regresar</a>
                </div>
                <div class="card2-container">
                    @foreach ($direcciones as $direccion)
                                        <div class="card2">
                                            @php
                                                $icono = $direccion->tipo === 'casa' ? 'images/home.png' : ($direccion->tipo === 'oficina' ? 'images/office.png' : 'images/work.png');
                                            @endphp
                                            <img src="{{ asset($icono) }}" alt="{{ ucfirst($direccion->tipo) }}">

                                            <div class="card-content">
                                                <h3>{{ ucfirst($direccion->tipo) }}</h3>
                                                <p>
                                                    {{ $direccion->calle }}
                                                    {{ $direccion->numero_exterior }}{{ $direccion->numero_interior ? ', Int. ' . $direccion->numero_interior : '' }}
                                                </p>
                                                <p>
                                                    {{ $direccion->ciudad }}, {{ $direccion->estado }},
                                                    {{ $direccion->pais }}, CP {{ $direccion->codigo_postal }}
                                                </p>
                                                <p>Tel: {{ $direccion->telefono }}</p>
                                                <div class="add-to-cart">
                                                    <a href="{{ route('direcciones.edit', $direccion->id_direccion) }}"
                                                        class="add-to-cart-btn">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('direcciones.destroy', $direccion->id_direccion) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="add-to-cart-btn"
                                                            onclick="return confirm('¿Seguro que deseas eliminar esta dirección?')">
                                                            <i class="fas fa-trash-alt"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('direcciones.create') }}" class="buy-btn">
                        <i class="fas fa-plus-circle"></i> Agregar Dirección
                    </a>
                </div>
            </div>
        </main>

        <br>
        @include('footer')
    </body>
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>