@php
    $isAdminArea = request()->is('employees/*');
    $logo = \App\Models\Imagen::where('seccion', 'Logo')->first();
    $ruta = $logo->ruta ?? null;

    if ($ruta) {
        $ruta = str_replace('\\', '/', $ruta);
        $ruta = ltrim($ruta, '/');
    }

    $logoUrl = $ruta ? asset($ruta) : asset('imagenes/Captura de pantalla 2025-01-19 134751.png');
@endphp

<header class="zx-header">
    <div class="zx-bar">

        {{-- 1. LOGO --}}
        <a class="zx-brand" href="{{ url('/') }}">
            <div class="zx-logo-circle">
                <img src="{{ $logoUrl }}" alt="Zarmex"
                     onerror="this.style.display='none';">
            </div>
            <span class="zx-brand-name">ZARMEX</span>
        </a>

        {{-- 2. MENÚ (DESKTOP) --}}
        <button class="zx-ham" id="zxHam" type="button" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>
        <div class="zx-menu" id="zxMenu">
            <ul class="zx-menu-root">
                <li class="zx-item zx-has-sub">
                    <a href="#" class="zx-item-link">
                        Productos
                        <i class="fa-solid fa-chevron-down zx-chevron zx-chevron--productos"></i>
                    </a>
                    <ul class="zx-sub">
                        @foreach(App\Models\Categoria::all() as $categoria)
                            <li><a href="{{ route('categoria.productos', $categoria->id_categoria) }}">{{ $categoria->nombre }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="zx-item zx-has-sub">
                    <a href="#" class="zx-item-link">
                        Servicios
                        <i class="fa-solid fa-chevron-down zx-chevron"></i>
                    </a>
                    <ul class="zx-sub">
                        <li><a href="{{ url('mantenimiento') }}">Mantenimiento</a></li>
                        <li><a href="{{ url('reparación') }}">Reparación</a></li>
                    </ul>
                </li>

                <li class="zx-item">
                    <a href="{{ url('/nosotros') }}" class="zx-item-link">Nosotros</a>
                </li>
            </ul>
        </div>

        {{-- 3. BUSCADOR --}}
        <div class="zx-search-wrap" id="zxSearchWrap">
           <form class="zx-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="zxSearchInput" type="text" name="q" placeholder="¿Qué estás buscando hoy?">
           </form>

            <div class="zx-results" id="zxResults" hidden>
                <div class="zx-results-title">Resultados de búsqueda</div>
                <div class="zx-results-list" id="zxResultsList"></div>
            </div>
        </div>

        {{-- 4. ACCESO ADMIN / LOGIN --}}
        <div class="zx-user-actions">
            @if($isAdminArea)
                @auth('employee')
                    <form method="POST" action="{{ route('admin.logo.update') }}" enctype="multipart/form-data" class="zx-inline-form">
                        @csrf @method('PUT')
                        <label class="zx-user-btn" title="Subir Logo"><i class="fa-solid fa-camera-retro"></i><input type="file" name="logo" onchange="this.form.submit()" hidden></label>
                    </form>
                    <form method="POST" action="{{ route('admin.logo.reset') }}" class="zx-inline-form">
                        @csrf @method('DELETE')
                        <button class="zx-user-btn" type="submit" title="Resetear"><i class="fa-solid fa-arrow-rotate-left"></i></button>
                    </form>
                    <form method="POST" action="{{ route('employee.logout') }}" class="zx-inline-form">
                        @csrf
                        <button class="zx-user-btn zx-logout" type="submit" title="Salir"><i class="fa-solid fa-power-off"></i></button>
                    </form>
                @else
                    <a class="zx-user-profile" href="{{ route('employee.login') }}" title="Mi Cuenta">
                        <div class="zx-avatar-icon">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                    </a>
                @endauth
            @else
                <a class="zx-user-profile" href="{{ route('employee.login') }}" title="Ingresar">
                    <div class="zx-avatar-icon">
                        <i class="ri-user-settings-line"></i>
                    </div>
                </a>
            @endif
        </div>

    </div>
</header>

<style>
:root {
    --bg: #145555;
    --bg-dark: #58776f;
    --gold: #b8a120;
    --text-menu: #ffffff;
}

.zx-header {
    background: rgba(6, 43, 33, 0.9);
    position: sticky;
    top: 0;
    z-index: 9999;
    width: 90%;
    margin: auto;
    display: flex;
    align-items: center;
    border-top: 3px solid var(--gold);
    border-bottom: 3px solid var(--gold);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    border-radius: 50px;
    backdrop-filter: blur(10px);
}

.zx-bar {
    width: clamp(95%, 1200px, 98%);
    margin: auto;
    display: flex;
    justify-content: space-between; 
    align-items: center;
    align-items: center;
    gap: clamp(12px, 3vw, 32px);
    height: clamp(65px, 10vw, 80px);
    padding: 0 clamp(8px, 2vw, 16px);
    padding-right: clamp(8px, 2vw, 24px);
}

/* LOGO - LAPTOP */
.zx-brand {
    display: flex;
    align-items: center;
    gap: clamp(8px, 2vw, 16px);
    text-decoration: none;
    flex-shrink: 0;
    padding-right: clamp(8px, 2vw, 24px);
    border-right: 1px dotted rgba(201,168,76,0.4);
    padding-right: clamp(8px, 2vw, 24px);
}

.zx-logo-circle {
    width: clamp(40px, 6vw, 50px);
    height: clamp(40px, 6vw, 50px);
    border-radius: 50%;
    border: 2px solid var(--gold);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.2);
    flex-shrink: 0;
}

.zx-logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.zx-brand-name {
    color: var(--gold);
    font-size: clamp(14px, 3vw, 20px);
    font-family: serif;
    letter-spacing: clamp(1px, 0.5vw, 4px);
    font-weight: bold;
    white-space: nowrap;
}

/* MENÚ */
.zx-menu {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* hamburguesa (mobile) */
.zx-ham {
    display: none;
    background: none;
    border: 0;
    cursor: pointer;
    padding: 8px;
    flex-shrink: 0;
}

.zx-ham span {
    width: 26px;
    height: 3px;
    background: var(--gold);
    border-radius: 3px;
    display: block;
    margin: 4px 0;
}

.zx-menu-root {
    display: flex;
    gap: clamp(2px, 1vw, 8px);
    margin: 0;
    padding: 0;
    list-style: none;
    flex-wrap: wrap;
    border left: 1px dotted rgba(201,168,76,0.4);
}

.zx-item-link {
    font-weight: 600;
    color: var(--text-menu);
    text-decoration: none;
    padding: clamp(6px, 2vw, 12px) clamp(10px, 2vw, 20px);
    font-size: clamp(13px, 2.5vw, 16px);
    white-space: nowrap;
    border-radius: 6px;
    transition: all 0.3s ease;
    border: none;
}

.zx-item:not(:last-child) {
    border-right: 1px dotted rgba(201, 168, 76, 0.4);
}

.zx-item-link:hover {
    color: var(--gold);
    background: rgba(201,168,76,0.15);
}

.zx-chevron {
    font-size: 0.8em;
    margin-left: 8px;
    transition: transform 0.2s ease;
}

/* icono cambia al abrir (mobile) */
.zx-has-sub.is-open > .zx-item-link .zx-chevron {
    transform: rotate(180deg);
}


/* BUSCADOR */
.zx-search-wrap {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    min-width: clamp(180px, 25vw, 450px);
    max-width: clamp(250px, 35vw, 500px);
}

.zx-search {
    
    background: rgba(65, 99, 99, 0.9);
    border-radius: 50px;
    height: clamp(40px, 6vw, 50px);
    width: 100%;
    display: flex;
    align-items: center;
    gap: clamp(6px, 1.5vw, 10px);
    border: 2px solid rgba(201,168,76,0.3);
    padding: 0 clamp(12px, 3vw, 20px);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}
  ::placeholder {
        color: #999;
    }

.zx-search:hover {
    border-color: var(--gold);
    box-shadow: 0 4px 15px rgba(201,168,76,0.2);
}

.zx-search i {
    color: #666;
    font-size: clamp(14px, 2.5vw, 18px);
    flex-shrink: 0;
}

.zx-search input {
    border: none;
    outline: none;
    flex: 1;
    font-size: clamp(12px, 2.2vw, 15px);
    color: #333;
    background: transparent;
    height: 100%;
    color: white;
}

.zx-search input::placeholder {
    color: #999;
}

/* RESULTADOS */
.zx-results {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    z-index: 10000;
    padding: clamp(8px, 2vw, 16px) 0;
}

/* USUARIO */
.zx-user-actions {
    display: flex;
    gap: clamp(4px, 1vw, 8px);
    flex-shrink: 0;
}

.zx-avatar-icon,
.zx-user-btn {
    width: clamp(38px, 6vw, 46px);
    height: clamp(38px, 6vw, 46px);
    background: var(--bg-dark);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: clamp(16px, 2.5vw, 20px);
    border: 2px solid var(--gold);
    transition: all 0.3s ease;
}

.zx-user-btn {
    background: var(--bg-dark);
    border: none;
    cursor: pointer;
}

.zx-avatar-icon:hover,
.zx-user-btn:hover {
    background: var(--gold);
    transform: scale(1.05);
}

/* SUBMENÚS */
.zx-has-sub { position: relative; }

.zx-sub {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    min-width: clamp(180px, 30vw, 250px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    display: none;
    list-style: none;
    padding: clamp(10px, 3vw, 20px) 0;
    border-radius: 12px;
    z-index: 10001;
    border-top: 3px solid var(--gold);
}

.zx-sub li a {
    color: #333;
    padding: clamp(10px, 3vw, 16px) 24px;
    display: block;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.zx-sub li a:hover { 
    background: linear-gradient(90deg, var(--gold), #2b494b);
    color: white;
}

.zx-menu-icon{
    color: var(--gold);
    margin-right: 8px;
    font-size: 0.95em;
}

.zx-item-link{
    display:flex;
    align-items:center;
}


.zx-has-sub:hover .zx-sub { display: block; }

/* RESPONSIVE BREAKPOINTS */

/* LAPTOP GRANDE (1400px+) */
@media (min-width: 1400px) {
    .zx-bar {
        grid-template-columns: auto auto 1fr auto;
        gap: 40px;
    }
}

/* LAPTOP MEDIANO (1200px - 1399px) */
@media (min-width: 1200px) and (max-width: 1399px) {
    .zx-bar {
        grid-template-columns: auto auto 1fr auto;
        gap: 24px;
    }
}

/* TABLET GRANDE (992px - 1199px) */
@media (min-width: 992px) and (max-width: 1199px) {
    .zx-bar {
        grid-template-columns: auto 1fr auto;
        gap: 20px;
    }
    
    .zx-brand {
        border-right: none;
        padding-right: 0;
    }
}

/* TABLET MEDIANO (768px - 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .zx-bar {
        grid-template-columns: auto 1fr auto;
        gap: 16px;
    }
    
    .zx-brand-name {
        display: none;
    }
    
    .zx-brand {
        border-right: none;
        padding-right: 0;
    }
    
    .zx-menu-root {
        gap: 4px;
    }
    
    .zx-search-wrap {
        max-width: 300px;
    }
}

/* TABLET PEQUEÑA / CELULAR GRANDE (600px - 767px) */
@media (max-width: 767px) {
    .zx-bar {
        grid-template-columns: 1fr auto 1fr;
        gap: 12px;
        height: 65px;
    }
    
    .zx-brand {
        border-right: none;
        padding-right: 0;
        justify-content: center;
    }
    
    .zx-brand-name {
        display: none;
    }
    
    .zx-menu {
        justify-content: flex-end;
    }
    
    .zx-menu-root {
        gap: 2px;
    }
    
    .zx-item-link {
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .zx-search-wrap {
        max-width: none;
        min-width: 200px;
    }
    
    .zx-search input {
        font-size: 13px;
    }
}

/* CELULAR MEDIANO (480px - 599px) */
@media (max-width: 599px) {
    .zx-bar {
        grid-template-columns: auto 1fr auto;
        gap: 8px;
        height: 60px;
        padding: 0 12px;
    }

    /* queremos que el panel hamburguesa siempre pueda abrirse */
    .zx-menu.is-open { display: flex; }

    
    .zx-brand-name {
        display: block;
        font-size: 16px;
    }
    
    .zx-brand {
        flex-direction: column;
        gap: 4px;
        padding-right: 0;
        border-right: none;
        text-align: center;
    }
    
    /* En mobile mostramos hamburguesa y el menú en panel */
    .zx-ham {
        display: block;
        margin-left: 6px;
    }
    
    .zx-menu {
        position: absolute;
        top: 100%;
        right: 12px;
        left: 12px;
        width: auto;
        justify-content: flex-start;
        background: rgba(6, 43, 33, 0.98);
        border-radius: 16px;
        border: 1px solid rgba(184, 161, 32, 0.35);
        backdrop-filter: blur(10px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        padding: 10px 8px;
        display: none;
        z-index: 10002;
    }
    
    .zx-menu.is-open {
        display: flex;
    }
    
    .zx-menu-root {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        gap: 0;
    }
    
    .zx-item:not(:last-child) {
        border-right: none;
    }
    
    .zx-item {
        width: 100%;
    }
    
    .zx-item-link {
        width: 100%;
        padding: 10px 12px;
        justify-content: space-between;
    }
    
.zx-sub {
        position: static;
        transform: none;
        left: auto;
        top: auto;
        margin-top: 0;
        width: 100%;
        min-width: 0;
        box-shadow: none;
        border-radius: 12px;
        border-top: none;
        margin-top: 6px;
        display: none;
        padding: 6px 0;
    }
    
    .zx-has-sub:hover .zx-sub {
        display: none;
    }
    
    .zx-has-sub.is-open .zx-sub {
        display: block;
    }
    
    .zx-search-wrap {
        grid-column: 1 / -1;
        max-width: none;
        min-width: auto;
    }
    
    .zx-search {
        height: 40px;
    }
    
    .zx-user-actions {
        justify-content: flex-end;
    }
}

/* CELULAR PEQUEÑO (<480px) */
@media (max-width: 479px) {
    .zx-bar {
        height: 58px;
        gap: 6px;
    }
    
    .zx-logo-circle {
        width: 38px;
        height: 38px;
    }
    
    .zx-brand-name {
        font-size: 15px;
        letter-spacing: 1px;
    }
    
    .zx-search {
        height: 38px;
        padding: 0 12px;
    }
    
    .zx-search input {
        font-size: 12px;
    }
}
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ham = document.getElementById('zxHam');
    const menu = document.getElementById('zxMenu');
    if (!ham || !menu) return;

    ham.addEventListener('click', (e) => {
      e.stopPropagation();
      menu.classList.toggle('is-open');
    });

    // acordeón para Productos/Servicios en mobile
    const items = menu.querySelectorAll('.zx-item.zx-has-sub');
    items.forEach(item => {
      const link = item.querySelector('.zx-item-link');
      if (!link) return;

      link.addEventListener('click', (e) => {
        // evita que el # haga scroll arriba
        e.preventDefault();
        e.stopPropagation();

        const alreadyOpen = item.classList.contains('is-open');
        items.forEach(i => i.classList.remove('is-open'));
        if (!alreadyOpen) item.classList.add('is-open');
      });
    });

    document.addEventListener('click', (e) => {
      // Cerrar si se hace click fuera del menú o del botón
      if (!menu.contains(e.target) && !ham.contains(e.target)) {
        menu.classList.remove('is-open');
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') menu.classList.remove('is-open');
    });
  });
</script>
