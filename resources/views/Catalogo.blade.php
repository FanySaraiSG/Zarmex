<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zarmex') }} / Productos / </title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="antialiased">
    @include('.header')
    <main>
        <section class="products">
            <h2>{{ $categoriaNombre }}</h2>
            <div class="search-container2">
                <input type="text" placeholder="Buscar..." id="category-search-input">
                <button id="search-button2">Buscar</button>
                <div class="filter-icon">
                    <i class="fas fa-filter"></i>
                    <div class="filter-dropdown">
                        <ul>
                            <li><a href="#" id="filter-az">Ordenar por A-Z</a></li>
                            <li><a href="#" id="filter-za">Ordenar por Z-A</a></li>
                            <li><a href="#" id="filter-price-asc"><i class="fas fa-arrow-up"></i> Ordenar por precio</a>
                            </li>
                            <li><a href="#" id="filter-price-desc"><i class="fas fa-arrow-down"></i> Ordenar por
                                    precio</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-container">
                @foreach($productos as $producto)
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
                            <p class\="price" \></span>{{ number_format($producto->precio, 2) }} MXN</p>
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
            </div>
            <div id="no-results" style="display: none;">No se encontraron productos que coincidan con su búsqueda.</div>
        </section>
        <div class="pagination justify-content-center mt-4">
            {{ $productos->links() }}
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('category-search-input');
                const searchButton = document.getElementById('search-button2');
                const filterIcon = document.querySelector('.filter-icon');
                const filterDropdown = document.querySelector('.filter-dropdown');
                const filterLinks = document.querySelectorAll('.filter-dropdown a');
                const productContainer = document.querySelector('.card-container');
                const noResults = document.getElementById('no-results');
                let productCards = Array.from(document.querySelectorAll('.card2'));

                function sortProducts(sortType) {
                    productCards.sort((a, b) => {
                        let valueA, valueB;
                        if (sortType.startsWith('price')) {
                            valueA = parseFloat(a.dataset.price);
                            valueB = parseFloat(b.dataset.price);
                        } else {
                            valueA = a.dataset.name;
                            valueB = b.dataset.name;
                        }

                        if (sortType.endsWith('asc')) {
                            return valueA < valueB ? -1 : (valueA > valueB ? 1 : 0);
                        } else {
                            return valueA < valueB ? 1 : (valueA > valueB ? -1 : 0);
                        }
                    });

                    productCards.forEach(card => productContainer.appendChild(card));
                }

                function filterProducts(searchTerm) {
                    let found = false;

                    productCards.forEach(card => {
                        const productID = card.querySelector('h1')?.textContent.trim().toLowerCase() || "";
                        const productName = card.dataset.name.toLowerCase();
                        const productDescription = card.querySelector('.card-content p:not(.price)')?.textContent.toLowerCase() || "";

                        if (productID.includes(searchTerm) || productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                            card.style.display = 'block';
                            found = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (found) {
                        noResults.style.display = 'none';
                    } else {
                        noResults.innerText = 'No se encontraron productos que coincidan con su búsqueda.';
                    }
                }

                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase();
                    noResults.style.display = 'none';  // Ocultamos el mensaje de "No se encontraron productos"

                    // Mostramos el mensaje de "Cargando resultados..." mientras se procesa la búsqueda
                    noResults.innerText = 'Cargando resultados...';
                    noResults.style.display = 'block';

                    setTimeout(() => {
                        filterProducts(searchTerm);
                    }, 100);
                }

                searchButton.addEventListener('click', performSearch);
                searchInput.addEventListener('keypress', function (event) {
                    if (event.key === 'Enter') {
                        performSearch();
                    }
                });

                filterIcon.addEventListener('click', function () {
                    filterDropdown.classList.toggle('show');
                });

                filterLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const sortType = event.target.id.replace('filter-', '');
                        sortProducts(sortType);
                        filterDropdown.classList.remove('show');
                    });
                });

                // Funcionalidad para "Agregar al carrito"
                document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const productCard = this.closest('.card2'); // Encuentra el producto correspondiente
                        const productId = productCard.querySelector('h1').textContent.trim(); // Obtiene el ID del producto
                        const verMasUrl = productCard.querySelector('.buy-btn').href; // Obtiene la URL de "Ver más"

                        alert("Tienes que elegir un color antes");
                        window.location.href = verMasUrl; // Redirige al usuario a la página "Ver más"
                    });
                });

            });
        </script>

    </main>
    @include('footer')
</body>

</html>