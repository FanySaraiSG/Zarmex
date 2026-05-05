<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zarmex') }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --zx-dark: #234d50;
            --zx-whatsapp: #59b568;
        }

        /* Espacio superior para que no lo tape el header */
        main { padding-top: 10px; padding-bottom: 10px; }

        /* GRID RESPONSIVO: Muestra todos los productos en una sola página */
        .products-grid {
            display: grid;
            /* Se ajusta al ancho de la página automáticamente */
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            padding: 20px 4%; /* Margen lateral elegante */
            width: 80%; /* Para centrar el grid dentro del main */
            max-width: 1400px;/* Para que en pantallas gigantes no se estire infinito */
            margin: 0 auto;       /* Centra el bloque completo dejando márgenes iguales a los lados */
            padding: 20px 0;      /* Padding arriba y abajo, 0 a los lados porque el margin auto ya lo hace */
            box-sizing: border-box;
        }

        .card2 {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #eee;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .card2:hover { 
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }

        .card2 img {
            width: 100%;
            height: 280px;
            object-fit: contain;
            padding: 20px;
            background: #def7ed;
        }

        .card-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        /* Botón estilo original */
        .vermas-btn {
            background: var(--zx-dark);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            width: 100%;
            text-transform: uppercase;
            transition: 0.3s;
        }
        .vermas-btn:hover { background: #1a3a3c; }

        /* MODAL (AJUSTADO PARA LAPTOP) */
        .modal-content {
            border-radius: 25px !important;
            border: none;
            max-height: 70vh; /* Evita que se corte en laptops */
            overflow-y: auto;
        }
        
        .info-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .thumb-img {
            width: 60px; height: 60px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #ddd;
        }

        .btn-zx-whatsapp {
            background-color: var(--zx-whatsapp) !important;
            color: white !important;
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 700;
            border: none;
        }

        .btn-zx-close {
            background-color: #f1f3f5 !important;
            color: #555 !important;
            border-radius: 12px;
            padding: 10px 30px;
            font-weight: 700;
            border: none;
        }
    </style>
</head>

<body class="antialiased">
    @include('.header')

    <main>
        <!-- No hay título ni buscador aquí para limpieza total -->

        <div class="products-grid">
            @foreach($productos as $producto)
                <div class="card2">
                    <img src="{{ asset($producto->imagen_url ?? 'images/productos/default.png') }}" alt="{{ $producto->nombre }}">
                    <div class="card-content">
                        <div>
                            <h3 style="color: var(--zx-dark); font-weight: 800; font-size: 1.3rem; margin-bottom: 10px;">{{ $producto->nombre }}</h3>
                        
                        </div>
                        <button type="button" class="vermas-btn" data-bs-toggle="modal" data-bs-target="#modalProd{{ $producto->id }}">
                            Ver Detalles
                        </button>
                    </div>
                </div>

                <!-- MODAL FIDELIDAD ORIGINAL -->
                <div class="modal fade" id="modalProd{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header border-0">
                                <h5 class="fw-bold m-0" style="color: #333;">{{ $producto->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <!-- IMAGEN Y MINIATURAS -->
                                    <div class="col-md-6 text-center">
                                        <div class="bg-light rounded p-3 mb-3">
                                            <img src="{{ asset($producto->imagen_url) }}" class="img-fluid" style="height: 280px; object-fit: contain;">
                                        </div>
                                        <div class="text-start">
                                            <p class="info-label">Miniaturas</p>
                                            <div class="d-flex gap-2">
                                                <img src="{{ asset($producto->imagen_url) }}" class="thumb-img">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- INFO Y BOTONES -->
                                    <div class="col-md-6 d-flex flex-column justify-content-between">
                                        <div>
                                            <p class="info-label">Descripción del Equipo</p>
                                            <p style="font-size: 0.9rem; color: #555; text-align: justify; line-height: 1.6;">
                                                {{ $producto->descripcion }}
                                            </p>
                                            <p class="info-label mt-4">Disponibilidad</p>
                                            <p class="small text-success fw-bold"><i class="fas fa-check-circle"></i> Entrega Inmediata</p>
                                        </div>

                                        <!-- Botones posicionados como el original -->
                                        <div class="d-flex justify-content-between align-items-center mt-5">
                                            <a href="https://wa.me/TUNUMERO" target="_blank" class="btn btn-zx-whatsapp">
                                                <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                            </a>
                                            <button type="button" class="btn btn-zx-close" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación eliminada: Ahora todos los productos cargan de corrido -->
    </main>

    @include('footer')
</body>
</html>