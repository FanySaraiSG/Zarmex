@php
    $isAdminArea = request()->is('employees/*');
    $logo = \App\Models\Imagen::where('seccion', 'Logo')->first();
    $ruta = $logo->ruta ?? null;

    if ($ruta) {
        $ruta = str_replace('\\', '/', $ruta);
        $ruta = ltrim($ruta, '/');
    }

    $logoUrl = $ruta ? asset($ruta) : asset('imagenes/logo.jpeg');
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

        {{-- BOTÓN HAMBURGUESA--}}
        <button class="zx-ham" id="zxHam" type="button" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>

        {{-- 2. MENÚ (DESKTOP / MOBILE ADAPTATIVO) --}}
        <div class="zx-menu" id="zxMenu">
            <ul class="zx-menu-root">
                <li class="zx-item zx-has-sub">
                    <a href="#" class="zx-item-link">
<span style="display:none;"></span>
                        <span>Productos</span>
                        <i class="fa-solid zx-chevron"></i>
                    </a>
                    <ul class="zx-sub">
                        @foreach(App\Models\Categoria::all() as $categoria)
                            <li><a href="{{ route('categoria.productos', $categoria->id_categoria) }}">{{ $categoria->nombre }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="zx-item zx-has-sub">
                    <a href="#" class="zx-item-link">
<span style="display:none;"></span>
                        <span>Servicios</span>
                        <i class="fa-solid zx-chevron"></i>
                    </a>
                    <ul class="zx-sub">
                        <li><a href="{{ url('mantenimiento') }}">Mantenimiento</a></li>
                        <li><a href="{{ url('reparación') }}">Reparación</a></li>
                    </ul>
                </li>

                <li class="zx-item">
                    <a href="{{ route('nosotros') }}" class="zx-item-link">
<span style="display:none;"></span>
                        <span>Nosotros</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- 3. BUSCADOR --}}
        <div class="zx-search-wrap" id="zxSearchWrap">
          <form class="zx-search" action="{{ route('buscar.resultados') }}" method="GET" autocomplete="off">
           <img src="{{ asset('iconos/buscador.png') }}" class="zx-search-icon" alt="Buscar">
           <input id="zxSearchInput" type="text" name="q" placeholder="¿Qué estás buscando hoy?" value="{{ request('q','') }}">
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
                        <img src="{{ asset('iconos/admin.png') }}" alt="Administrador" style="width:30px; height:30px; object-fit:contain;">
                    </div>
                </a>
            @endif
        </div>

    </div>
</header>

<style>
:root {
    --bg-header-dark: rgba(20, 85, 85, 0.94);
    --bg: #145555;
    --bg-dark: #58776f;
    --gold: #b8a120;
    --text-menu: #ffffff;
}

.zx-header {
    background: var(--bg-header-dark); 
    position: absolute;
    top: 14px;
    left: 50%;
    transform: translateX(-50%); 
    z-index: 9999;
    width: 92%;
    margin: 0 auto; 
    
    display: flex;
    align-items: center;
    justify-content: center;
    border-top: 3px solid var(--gold);
    border-bottom: 3px solid var(--gold);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border-radius: 25px;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}   

.zx-bar {
    width: 100%;
    max-width: 1400px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    height: 75px;
    padding: 0 20px;
}

/* LOGO */
.zx-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    flex-shrink: 0;
}

.zx-logo-circle {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    border: 2px solid var(--gold);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(14, 43, 36, 0.4); 
    flex-shrink: 0;
}

.zx-logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.zx-brand-name {
    color: #ffffff;
    font-size: 30px;
    font-family: Georgia;
    letter-spacing: 5px;
    font-weight: bold;
    white-space: nowrap;
    padding: 0 15px;
    border-right: 3px dotted rgba(184, 161, 32, 0.55);
}

/* MENÚ OPTIMIZADO PARA EVITAR DESBORDES */
.zx-menu {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1 1 auto; /* Permite que el menú use el espacio intermedio flexiblemente */
    min-width: 0;   /* Evita bugs de desborde flex */
}

.zx-menu-root {
    display: flex;
    gap: 4px;
    margin: 0;
    padding: 0;
    list-style: none;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width:500px;
}

.zx-item {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
    min-width:140px;
}

.zx-item-link {
    font-weight: 600;
    color: var(--text-menu);
    text-decoration: none;
    padding: 10px 0px;
    width: 100%;
    font-size: 16px;
    white-space: nowrap;
    border-radius: 10px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0;
    justify-content: center;
    position: relative;
}

/* iconos removidos: se deja estilo vacío para no romper CSS */
.zx-item-icon { display: none; }

.zx-item:not(:last-child) {
    border-right: 3px dotted rgba(184, 161, 32, 0.55);
    padding-right: 14px;
}

.zx-item-link:hover {
    color: var(--gold);
    background: rgba(184, 161, 32, 0.15); 
}

.zx-chevron {
    font-size: 0.7em;
    margin-left: 2px;
}

/* BUSCADOR ADAPTATIVO */
.zx-search-wrap {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1 1 300px; /* Crece y se encoge dinámicamente */
    max-width: 400px;
}

.zx-search {
    background: #32746b; 
    border-radius: 50px;
    height: 44px;
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1.5px solid rgba(184, 161, 32, 0.25); 
    padding: 0 16px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.zx-search:hover {
    border-color: var(--gold);
    box-shadow: 0 4px 15px rgba(184, 161, 32, 0.2);
}

.zx-search i {
    color: rgba(255, 255, 255, 0.5); 
    font-size: 16px;
    flex-shrink: 0;
}

.zx-search input {
    border: none;
    outline: none;
    flex: 1;
    font-size: 14px;
    background: transparent;
    height: 100%;
    color: #ffffff; 
    min-width: 0;
}

.zx-search input::placeholder {
    color: rgba(255, 255, 255, 0.55);

}

.zx-search-icon {
    width: 20px;          
    height: 20px;         
    object-fit: contain;  
    flex-shrink: 0;       
    opacity: 0.7;         
}

/* SUGERENCIAS */
.zx-results {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    z-index: 10000;
    padding: 12px 0;
}

.zx-results-title {
    padding: 0 14px 6px;
    font-size: 12px;
    color: #58776f; 
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* BOTONES DE USUARIO */
.zx-user-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}

.zx-avatar-icon,
.zx-user-btn {
    width: 42px;
    height: 42px;
    background: rgba(14, 43, 36, 0.6);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 18px;
    border: 2px solid var(--gold);
    transition: all 0.3s ease;
}

.zx-user-btn { cursor: pointer; }

.zx-avatar-icon:hover,
.zx-user-btn:hover {
    background: var(--gold);
    color: #0e2b24; 
    transform: scale(1.05);
}

/* SUBMENÚS */
.zx-has-sub { position: relative; }

.zx-sub {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(10, 31, 26, 0.98); 
    min-width: 200px;
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
    display: none;
    list-style: none;
    padding: 10px 0;
    border-radius: 12px;
    z-index: 10001;
    border-top: 3px solid var(--gold);
}

.zx-sub li a {
    color: #ffffff; 
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.zx-sub li a:hover { 
    background: linear-gradient(90deg, var(--gold), #145555); 
    color: #ffffff;
}

.zx-has-sub:hover .zx-sub { display: block; }

/* MENÚ HAMBURGUESA (MECANISMO MOBILE) */
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

/* ==========================================================================
   MEDIA QUERIES MEJORADAS: CONTROL TOTAL DE DESBORDES POR TAMAÑO DE PANTALLA
   ========================================================================== */

@media (max-width: 1150px) {
    .zx-brand-name {
        display: inline-block;
    }
}

@media (max-width: 991px) {
    .zx-bar {
        height: 75px;
    }
    .zx-ham {
        display: block; /* Activamos la hamburguesa */
    }

    /* Transformación del menú tradicional a caja lateral/desplegable limpia */
    .zx-menu {
        position: absolute;
        top: 100%;
        right: 0;
        left: 0;
        width: 100%;
        background: rgba(14, 43, 36, 0.98);
        border-radius: 20px;
        border: 2px solid var(--gold);
        box-shadow: 0 12px 30px rgba(0,0,0,0.4);
        padding: 15px;
        display: none; /* JS lo controla */
        z-index: 10002;
        margin-left: 0;
        margin-top: 8px;
    }
    .zx-menu.is-open {
        display: flex;
    }
    .zx-menu-root {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    .zx-item:not(:last-child) {
        border-right: none;
        padding-right: 0;
        border-bottom: 1px dashed rgba(184, 161, 32, 0.2);
        padding-bottom: 8px;
    }
    .zx-item-link {
        width: 100%;
        padding: 10px;
        justify-content: space-between;
    }
    .zx-sub {
        position: static;
        transform: none;
        width: 100%;
        box-shadow: none;
        background: rgba(20, 85, 85, 0.4);
        margin-top: 6px;
        display: none;
    }
    .zx-has-sub:hover .zx-sub {
        display: none;
    }
    .zx-has-sub.is-open .zx-sub {
        display: block;
    }
}

/* Teléfonos móviles: Mantiene todo alineado horizontalmente */
@media (max-width: 650px) {
    .zx-bar {
        display: flex; /* Mantiene la fila única original */
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        height: 75px;
        padding: 0 12px;
    }

    .zx-brand-name {
        display: none; /* Esconde el texto ZARMEX en móviles para dar espacio al buscador */
    }

    .zx-brand {
        padding-right: 0;
    }

    .zx-search-wrap {
        flex: 1 1 auto; /* El buscador ocupa el centro dinámicamente sin bajarse */
        max-width: 100%;
    }

    .zx-search {
        height: 40px;
        padding: 0 10px;
    }
    
    .zx-search input {
        font-size: 12px;
    }

    .zx-menu {
        top: 100%;
        max-height: calc(100vh - 120px);
        overflow: auto;
        -webkit-overflow-scrolling: touch;
    }
}

</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ham = document.getElementById('zxHam');
    const menu = document.getElementById('zxMenu');

    if (ham && menu) {
      ham.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.toggle('is-open');
      });

      const items = menu.querySelectorAll('.zx-item.zx-has-sub');
      items.forEach(item => {
        const link = item.querySelector('.zx-item-link');
        if (!link) return;

        link.addEventListener('click', (e) => {
          const href = (link.getAttribute('href') || '').trim();
          const isNosotros = href.includes('/nosotros') || href.includes("route('nosotros')") || href.includes('nosotros');

          if (isNosotros) {
            menu.classList.remove('is-open');
            return;
          }

          e.preventDefault();
          e.stopPropagation();

          const alreadyOpen = item.classList.contains('is-open');
          items.forEach(i => i.classList.remove('is-open'));
          if (!alreadyOpen) item.classList.add('is-open');
        });
      });

      document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !ham.contains(e.target)) {
          menu.classList.remove('is-open');
        }
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') menu.classList.remove('is-open');
      });
    }

    const input = document.getElementById('zxSearchInput');
    const resultsWrap = document.getElementById('zxResults');
    const resultsList = document.getElementById('zxResultsList');

    if (!input || !resultsWrap || !resultsList) return;

    const debounce = (fn, ms = 250) => {
      let t;
      return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), ms);
      };
    };

    const renderItems = (items) => {
      resultsList.innerHTML = '';

      if (!items || items.length === 0) {
        resultsList.innerHTML = '<div style="padding: 10px; color:#58776f;">Sin resultados</div>';
        resultsWrap.hidden = false;
        return;
      }

      const frag = document.createDocumentFragment();

      items.forEach((it) => {
        const a = document.createElement('a');
        a.href = it.url || '#';
        a.className = 'zx-search-item';
        a.setAttribute('data-url', it.url || '');
        a.innerHTML = `
          <div style="font-weight:700; color:#145555;">${it.titulo || ''}</div>
          <div style="font-size: 12px; color:#58776f; margin-top:2px;">${it.descripcion || ''}</div>
        `;
        a.addEventListener('click', (e) => { if (!it.url) e.preventDefault(); });
        frag.appendChild(a);
      });

      resultsList.appendChild(frag);
      resultsWrap.hidden = false;
    };

    const hideResults = () => { resultsWrap.hidden = true; resultsList.innerHTML = ''; };

    const buscarSugerencias = async (q) => {
      const query = (q || '').trim();
      if (query.length < 2) { hideResults(); return; }
      try {
        const res = await fetch(`/buscar-sugerencias?q=${encodeURIComponent(query)}`, { headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        renderItems(data.items || []);
      } catch (err) { hideResults(); }
    };

    const onInput = debounce((e) => { buscarSugerencias(e.target.value); }, 150);
    input.addEventListener('focus', () => { buscarSugerencias(input.value); });

    let activeIndex = -1;
    const getItems = () => Array.from(resultsList.querySelectorAll('.zx-search-item'));

    const setActive = (idx) => {
      const items = getItems();
      items.forEach((el) => el.style.background = '');
      if (idx >= 0 && idx < items.length) {
        items[idx].style.background = 'rgba(184, 161, 32, 0.15)';
        activeIndex = idx;
      }
    };

    input.addEventListener('keydown', (e) => {
      const items = getItems();
      if (!items.length) return;
      if (e.key === 'ArrowDown') { e.preventDefault(); setActive(Math.min(activeIndex + 1, items.length - 1)); }
      else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(Math.max(activeIndex - 1, 0)); }
      else if (e.key === 'Enter') { if (activeIndex >= 0 && activeIndex < items.length) { e.preventDefault(); items[activeIndex].click(); } hideResults(); }
      else if (e.key === 'Escape') { e.preventDefault(); hideResults(); }
    });

    input.addEventListener('input', onInput);
    document.addEventListener('click', (e) => { if (!e.target.closest('#zxSearchWrap')) hideResults(); });
  });
</script>

<style>
  .zx-results-list .zx-search-item {
    display: block;
    padding: 10px 14px;
    text-decoration: none;
    border-radius: 10px;
    margin: 6px;
    border: 1px solid rgba(6, 43, 33, 0.08);
    background: rgba(255, 255, 255, 0.96);
  }
  .zx-results-list .zx-search-item:hover {
    border-color: rgba(184, 161, 32, 0.6);
    box-shadow: 0 6px 15px rgba(20, 85, 85, 0.12);
  }
</style>