<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zarmex') }} / Detalle producto</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    @include('header')

    <main>
        <section class="products">
            <h2>Resultados para: "{{ $query }}"</h2>

            <div class="card-container">
                @if ($resultados->count() > 0)
                    @foreach ($resultados as $producto)
                        <div class="card2" data-name="{{ strtolower($producto->nombre) }}" data-price="{{ $producto->precio }}">
                            @if($producto->imagen_url)
                                <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}">
                            @else
                                <img src="{{ asset('images/productos/default.png') }}" alt="Imagen no disponible" />
                            @endif
                            <div class="card-content">
                                <h1 style="color: #234d50; text-align:center; font-size: 40px;">{{ $producto->id }}</h1>
                                <h3>{{ $producto->nombre }}</h3>
                                <p
                                    style="text-align: justify; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                                    {{ $producto->descripcion }}
                                </p>
                                <p class="price">{{ number_format($producto->precio, 2) }} MXN</p>
                                <div class="add-to-cart">
                                    <a href="{{ route('productos.vermas', ['id' => $producto->id]) }}" class="buy-btn">Ver
                                        más</a>
                                    <button class="add-to-cart-btn"><i class="fas fa-shopping-cart"></i> Agregar al
                                        carrito</button>
                                </div>
                                <div class="shipping-info"><i class="fas fa-truck-moving"></i> Envíos a todo México</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="no-results">No se encontraron productos que coincidan con su búsqueda.</div>
                @endif
            </div>
            <div class="pagination mt-4">
                {{ $resultados->appends(['q' => $query])->links() }}
            </div>
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // "Agregar al carrito" con redirección
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const productCard = this.closest('.card2');
                    const verMasUrl = productCard.querySelector('.buy-btn').href;

                    alert("Tienes que elegir un color antes");
                    window.location.href = verMasUrl;
                });
            });
        });
    </script>

    @include('footer')
</body>

</html>