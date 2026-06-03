<x-app-layout>
    @auth('employee')
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <title>Colores</title>
        <style>
            :root {
                --primary-green: #1a7431;
                --medium-green: #2d6a4f;
                --light-green: #d8f3dc;
                --accent-green: #74c69d;
                --bg-gray: #9ddabb;
            }

            nav { background-color: inherit !important; }

            body {
                background-color: var(--bg-gray);
                font-family: 'Segoe UI', sans-serif;
                min-height: 100vh;
            }

            .page-wrap {
                max-width: 1100px;
                margin: 0 auto;
                padding: 40px 24px 60px;
            }

            /* HEADER */
            .top-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 36px;
            }

            .page-title {
                font-size: 1.8rem;
                font-weight: 900;
                color: #fff;
                margin: 0;
                text-shadow: 0 2px 8px rgba(0,0,0,0.15);
                letter-spacing: -0.3px;
            }

            .btn-back {
                background: rgba(255,255,255,0.25);
                color: #fff;
                border: 1.5px solid rgba(255,255,255,0.5);
                border-radius: 12px;
                padding: 9px 20px;
                font-weight: 700;
                font-size: 0.88rem;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 7px;
                backdrop-filter: blur(4px);
                transition: background 0.2s;
            }
            .btn-back:hover { background: rgba(255,255,255,0.38); color: #fff; }

            .btn-add {
                background: #fff;
                color: var(--primary-green);
                border: none;
                border-radius: 12px;
                padding: 10px 22px;
                font-weight: 800;
                font-size: 0.9rem;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.12);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .btn-add:hover {
                color: var(--medium-green);
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            }

            /* ALERT */
            .alert-success-custom {
                background: rgba(255,255,255,0.85);
                border: none;
                border-left: 4px solid var(--primary-green);
                border-radius: 12px;
                color: var(--medium-green);
                font-weight: 600;
                padding: 14px 18px;
                margin-bottom: 28px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            /* GRID DE FILAS — UNA POR FILA, AIREADAS */
            .color-list {
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            .color-row {
                background: #fff;
                border-radius: 18px;
                padding: 18px 24px;
                display: flex;
                align-items: center;
                gap: 24px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.07);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .color-row:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.11);
            }

            /* CIRCULO GRANDE */
            .color-swatch {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                flex-shrink: 0;
                box-shadow: 0 4px 12px rgba(0,0,0,0.18);
                border: 3px solid rgba(255,255,255,0.9);
                outline: 1px solid rgba(0,0,0,0.08);
            }

            /* NÚMERO DE ORDEN */
            .color-num {
                font-size: 0.8rem;
                font-weight: 800;
                color: #bbb;
                min-width: 22px;
                text-align: center;
            }

            /* INFO */
            .color-meta {
                flex: 1;
            }
            .color-name {
                font-size: 1rem;
                font-weight: 800;
                color: #1a1a1a;
                margin-bottom: 3px;
            }
            .color-hex {
                font-size: 0.78rem;
                color: #999;
                font-family: 'Courier New', monospace;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            /* ACCIONES */
            .color-actions {
                display: flex;
                gap: 10px;
                flex-shrink: 0;
            }

            .btn-edit, .btn-delete {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                border: none;
                cursor: pointer;
                transition: transform 0.2s, box-shadow 0.2s;
                flex-shrink: 0;
                text-decoration: none;
            }

            .btn-edit {
                background: var(--primary-green);
                color: #fff;
                box-shadow: 0 4px 10px rgba(26,116,49,0.3);
            }
            .btn-edit:hover {
                transform: scale(1.12);
                box-shadow: 0 6px 16px rgba(26,116,49,0.45);
                color: #fff;
            }

            .btn-delete {
                background: #e74c3c;
                color: #fff;
                box-shadow: 0 4px 10px rgba(231,76,60,0.3);
            }
            .btn-delete:hover {
                transform: scale(1.12);
                box-shadow: 0 6px 16px rgba(231,76,60,0.45);
            }

            /* EMPTY STATE */
            .empty-state {
                text-align: center;
                padding: 70px 20px;
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            }
            .empty-state i { font-size: 3.5rem; color: #ccc; margin-bottom: 14px; display: block; }
            .empty-state p { color: #aaa; font-weight: 600; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        @section('content')
        <div class="page-wrap">

            <div class="top-bar">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                    <h1 class="page-title">Paleta de Colores</h1>
                </div>
                <a href="{{ route('colors.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle-fill"></i> Añadir Color
                </a>
            </div>

            @if(session('success'))
                <div class="alert-success-custom">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($colors->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-palette"></i>
                    <p>No hay colores registrados aún.</p>
                    <a href="{{ route('colors.create') }}" class="btn-add mx-auto">
                        <i class="bi bi-plus-circle-fill"></i> Añadir el primero
                    </a>
                </div>
            @else
                <div class="color-list">
                    @foreach($colors as $color)
                        @php $hex = ltrim($color->id_color, '#'); @endphp
                        <div class="color-row">
                            <span class="color-num">{{ $loop->iteration }}</span>
                            <div class="color-swatch" style="background-color: #{{ $hex }};"></div>
                            <div class="color-meta">
                                <div class="color-name">{{ $color->nombre }}</div>
                                <div class="color-hex">#{{ strtoupper($hex) }}</div>
                            </div>
                            <div class="color-actions">
                                <a href="{{ route('colors.edit', $color->id_color) }}" class="btn-edit" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('colors.destroy', ltrim($color->id_color, '#')) }}" method="post" style="margin:0; padding:0; border:none; background:none; display:inline-flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Eliminar"
                                        onclick="return confirm('¿Eliminar el color {{ $color->nombre }}?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    @endauth
</x-app-layout>