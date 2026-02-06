<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }} / detalle producto</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/vermas.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .quantity-input-container {
            display: flex;
            align-items: center;
        }

        .quantity-label {
            margin-right: 10px;
            font-weight: bold;
        }

        .quantity-input {
            width: 70px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        .color-box {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            margin-right: 5px;
            border: 1px solid #ccc;
        }

        .color-palette {
            display: flex;
            align-items: center;
        }

        .selected-color {
            border: 2px solid #000 !important;
        }
    </style>
</head>

<body class="antialiased">
    @include('header')
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        </div>
    @endif

    <main>
        <section class="products">
            <div class="back-to-catalog">
                <a href="/catalogo/{{ $producto->categoria_id }}" class="back-btn"
                    style="padding: 10px 20px; background-color: #234d50; color: white; text-decoration: none; border-radius: 5px;">
                    Regresar al catálogo
                </a>
            </div>
            <br>
            <div class="card-container">
                <div class="card3 product-card">
                    <div class="card-content">
                        <div class="product-layout">
                            <div class="product-image">
                                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel"
                                    data-bs-interval="3000" style="width: 100%; height: 70%; margin: 0 auto;">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset($producto->imagen_url) }}" class="d-block w-100"
                                                alt="{{ $producto->nombre }}">
                                        </div>
                                        @foreach($imagenes as $imagen)
                                            <div class="carousel-item">
                                                <img src="{{ asset($imagen->ruta) }}" class="d-block w-100"
                                                    alt="{{ $producto->nombre }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <h1 style="color: #234d50; text-align:center; font-size: 40px;">
                                    {{ $producto->id }}
                                </h1>

                                <div class="product-id">
                                    <p><strong>Nombre del Equipo:</strong> {{ $producto->nombre }} </p>
                                </div>

                                <div class="product-description">
                                    <p style="text-align: justify;"><strong>Descripción:</strong>
                                        {{ $producto->descripcion }}</p>
                                </div>

                                <div class="product-price">
                                    <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }} MXN</p>
                                </div>

                                <div class="product-stock">
                                    <p><strong>Stock disponible:</strong> {{ $producto->stock }}</p>
                                </div>

                                <div class="product-category">
                                    <p><strong>Categoría:</strong> {{ $nombreCategoria }}</p>
                                </div>

                                <h3>Medidas del Producto</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Medida</th>
                                            <th>Valor (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Largo</td>
                                            <td>{{ $medidas->largo ?? 'No disponible' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ancho</td>
                                            <td>{{ $medidas->ancho ?? 'No disponible' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Altura</td>
                                            <td>{{ $medidas->altura ?? 'No disponible' }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <form action="{{ route('carrito.agregar') }}" method="POST" id="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="id_usuario" value="{{ auth()->id() }}">
                                    <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                                    <input type="hidden" name="id_color" id="selected-color" value="">

                                    <div class="quantity-input-container">
                                        <label for="cantidad" class="quantity-label">Cantidad:</label>
                                        <input type="number" name="cantidad" id="cantidad" class="quantity-input"
                                            value="1" min="1" required>
                                    </div>

                                    <div class="color-options">
                                        <h3>Colores disponibles:</h3>
                                        <div class="color-palette">
                                            @foreach ($colors as $color)
                                                <div class="color-box" style="background-color: #{{ $color->id_color }};"
                                                    title="{{ $color->nombre }}"
                                                    onclick="selectColor('{{ $color->id_color }}', '{{ $color->nombre }}', this)">
                                                </div>
                                            @endforeach
                                        </div>
                                        <p id="selected-color-name" style="font-weight: bold; margin-top: 10px;"></p>
                                    </div>

                                    <button type="submit" class="add-to-cart-btn"><i class="fas fa-shopping-cart"></i>
                                        Agregar al carrito</button>
                                </form>

                                <script>
                                    let selectedColorElement = null;

                                    function selectColor(colorId, colorName, element) {
                                        document.getElementById('selected-color').value = colorId; // Asignar el color seleccionado
                                        document.getElementById('selected-color-name').innerText = 'Color seleccionado: ' + colorName; // Mostrar el nombre del color seleccionado

                                        // Desmarcar el color previamente seleccionado
                                        if (selectedColorElement) {
                                            selectedColorElement.classList.remove('selected-color');
                                        }

                                        // Marcar el color actualmente seleccionado
                                        element.classList.add('selected-color');
                                        selectedColorElement = element;
                                    }

                                    document.getElementById('add-to-cart-form').addEventListener('submit', function (event) {
                                        const selectedColor = document.getElementById('selected-color').value;
                                        if (!selectedColor) {
                                            event.preventDefault(); // Evitar que se envíe el formulario
                                            alert('Elija un color primero');
                                        }
                                    });
                                </script>

                                <div class="shipping-info">
                                    <i class="fas fa-truck-moving"></i> Envíos a todo México
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <script>
            function selectColor(colorId, colorName, element) {
                document.getElementById('selected-color').value = colorId; // Asignar el color seleccionado al campo oculto
                document.getElementById('selected-color-name').textContent = 'Color seleccionado: ' + colorName; // Mostrar el nombre del color seleccionado
                // Resaltar el color seleccionado
                const colorBoxes = document.querySelectorAll('.color-box');
                colorBoxes.forEach(box => {
                    box.style.border = '1px solid #ccc'; // Reiniciar el borde de todos los colores
                    box.classList.remove('selected-color');
                });
                element.style.border = '2px solid #000'; // Resaltar el color seleccionado
                element.classList.add('selected-color');
            }
        </script>

        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="review-section">
                        <h3>Deja tu Comentario del producto</h3>
                        <form class="review-form" action="{{ url('/comentarios/' . $producto->id) }}" method="POST">
                            @csrf
                            <label for="rating">Calificación:</label>
                            <div class="rating-stars">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="calificacion" value="{{ $i }}">
                                    <label for="star{{ $i }}">&#9733;</label>
                                @endfor
                            </div>

                            <label for="comment">Comentario:</label>
                            <textarea id="comment" name="comentario" rows="4"
                                placeholder="Escribe tu opinión aquí..."></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Enviar comentario</button>
                        </form>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Comentarios</h3>
                        <select id="filtro-orden" class="form-select w-auto">
                            <option value="recientes">Más recientes</option>
                            <option value="antiguos">Más antiguos</option>
                            <option value="mejor_calificacion">Mejor calificados</option>
                            <option value="peor_calificacion">Peor calificados</option>
                        </select>
                    </div>

                    <div id="comentarios-container" class="mt-4"></div>
                    <div class="text-center mt-3">
                        <button id="ver-mas" class="btn btn-secondary d-none">Ver más</button>
                    </div>
                    <br>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let offset = 0;
                const productoId = "{{ $producto->id }}";
                const comentariosContainer = document.getElementById('comentarios-container');
                const verMasBtn = document.getElementById('ver-mas');
                const filtroOrden = document.getElementById('filtro-orden');
                let ordenActual = 'recientes';

                function cargarComentarios(reset = false) {
                    if (reset) {
                        offset = 0; // Reiniciar el desplazamiento
                        comentariosContainer.innerHTML = ''; // Limpiar comentarios anteriores
                        verMasBtn.classList.add('d-none'); // Ocultar el botón temporalmente
                    }

                    fetch(`/comentarios/${productoId}/${offset}?orden=${ordenActual}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(comentario => {
                                    const comentarioHTML = `
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>${comentario.usuario.name}</strong>
                                            </div>
                                                <div class="card-body">
                                                    <div class="stars mb-2">
                                                        ${Array(5).fill(0).map((_, i) => `
                                                        ${i < comentario.calificacion ? `
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" class="star-icon">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                        ` : `
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" class="star-icon">
                                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                            `}
                                                            `).join('')}
                                                    </div>
                                                    <p class="card-text">${comentario.comentario}</p>
                                                    </div>
                                                    <div class="card-footer text-body-secondary">
                                                        ${new Date(comentario.created_at).toLocaleString()}
                                                    </div>
                                                </div><br>
                                            `;
                                    comentariosContainer.innerHTML += comentarioHTML;
                                });

                                offset += data.length;
                                verMasBtn.classList.toggle('d-none', data.length < 3);
                            }
                        });
                }

                verMasBtn.addEventListener('click', function () {
                    cargarComentarios();
                });

                filtroOrden.addEventListener('change', function () {
                    ordenActual = this.value;
                    cargarComentarios(true); // Se reinician los comentarios al cambiar el filtro
                });

                // Cargar el primer comentario automáticamente
                cargarComentarios();
            });
        </script>

        @include('footer')
    </main>
</body>

</html>