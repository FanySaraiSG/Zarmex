@php
    $isAdminArea = request()->is('employees/*');
    $logo = \App\Models\Imagen::where('seccion', 'Logo')->first();
    $ruta = $logo->ruta ?? null;

    // normaliza backslashes a slashes
    if ($ruta) {
        $ruta = str_replace('\\', '/', $ruta);
        $ruta = ltrim($ruta, '/');

    }

    // si no hay ruta, usa default

    $logoUrl = $ruta ? asset($ruta) : asset('imagenes/Captura de pantalla 2025-01-19 134751.png');
@endphp
<header class="zx-header"
    <div class="zx-bar">

        {{-- LOGO (más grande, a inicio) --}}
       <a class="zx-brand" href="{{ url('/') }}">
    <img src="{{ $logoUrl }}" alt="Zarmex"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
    <span class="zx-brand-fallback" style="display:none;">ZARMEX</span>
</a>

        {{-- MENÚ DESPLEGABLE --}}

        <div class="zx-menu" id="zxMenu">

            <ul class="zx-menu-root">



                {{-- PRODUCTOS --}}

                <li class="zx-item zx-has-sub">

                    <a href="#" class="zx-item-link">

                        Productos

                        <i class="fa-solid fa-chevron-right zx-chevron"></i>

                    </a>

                    <ul class="zx-sub">

                        @foreach(App\Models\Categoria::all() as $categoria)

                            <li>

                                <a href="{{ route('categoria.productos', $categoria->id_categoria) }}">

                                    {{ $categoria->nombre }}

                                </a>

                            </li>

                        @endforeach

                    </ul>

                </li>



                {{-- SERVICIOS --}}

                <li class="zx-item zx-has-sub">

                    <a href="#" class="zx-item-link">

                        Servicios

                        <i class="fa-solid fa-chevron-right zx-chevron"></i>

                    </a>

                    <ul class="zx-sub">

                        <li><a href="{{ url('mantenimiento') }}">Mantenimiento</a></li>

                        <li><a href="{{ url('reparación') }}">Reparación</a></li>

                    </ul>

                </li>



                {{-- NOSOTROS --}}

                <li class="zx-item">

                    <a href="{{ url('/nosotros') }}" class="zx-item-link">Nosotros</a>

                </li>
            </ul>
        </div>

        {{-- BUSCADOR EN HEADER --}}

        <div class="zx-search-wrap" id="zxSearchWrap">
            <form class="zx-search" id="zxSearchForm" action="{{ route('buscar.resultados') }}" method="GET" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="zxSearchInput" type="text" name="q" placeholder="Buscar productos o servicios...">
            </form>



            {{-- Panel resultados --}}

            <div class="zx-results" id="zxResults" hidden>
                <div class="zx-results-title">Resultados de búsqueda</div>
                <div class="zx-results-list" id="zxResultsList"></div>
            </div>
        </div>

        {{-- ACCESO ADMIN --}}
@if($isAdminArea)
    {{-- SOLO EN ÁREA ADMIN --}}
    @auth('employee')

        {{-- Cambiar logo --}}
        <form method="POST" action="{{ route('admin.logo.update') }}" enctype="multipart/form-data" class="zx-logo-upload">
            @csrf

            @method('PUT')
            <label class="zx-user zx-user-btn" title="Cambiar logo" aria-label="Cambiar logo">
                <i class="fa-solid fa-image"></i>
                <input type="file"
                       name="logo"
                       accept=".jpg,.jpeg,.png,.bmp,.webp,image/jpeg,image/png,image/bmp,image/webp"
                       onchange="this.form.submit()"
                       hidden>
            </label>
        </form>

        {{-- Reset logo --}}

        <form method="POST" action="{{ route('admin.logo.reset') }}" class="zx-logo-reset">

            @csrf

            @method('DELETE')

            <button class="zx-user zx-user-btn" type="submit" title="Restaurar logo" aria-label="Restaurar logo">

                <i class="fa-solid fa-rotate-left"></i>

            </button>

        </form>



        {{-- Logout --}}

        <form method="POST" action="{{ route('employee.logout') }}" class="zx-logout-form">

            @csrf

            <button class="zx-user zx-user-btn" type="submit" aria-label="Cerrar sesión" title="Cerrar sesión">

                <i class="fa-solid fa-right-from-bracket"></i>

            </button>

        </form>



    @else

        <a class="zx-user" href="{{ route('employee.login') }}" aria-label="Acceso admin" title="Acceso admin">

            <i class="fa-regular fa-circle-user"></i>

        </a>

    @endauth



@else

    <a class="zx-user" href="{{ route('employee.login') }}" aria-label="Acceso admin" title="Acceso admin">

        <i class="fa-regular fa-circle-user"></i>

    </a>

@endif



    </div>

</header>



{{-- Font Awesome --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>



<script>

(() => {

    /* Menú hamburguesa (solo móvil) */

    const menu = document.getElementById('zxMenu');



    /* Submenús táctiles en móvil */

    if(menu){

        menu.querySelectorAll('.zx-has-sub > .zx-item-link').forEach(link=>{

            link.onclick = e=>{

                if(window.innerWidth < 820){

                    e.preventDefault();

                    link.parentElement.classList.toggle('is-open');

                }

            }

        });



        document.addEventListener('click', (e) => {

            if(!menu.contains(e.target)) menu.classList.remove('is-open');

        });

        menu.addEventListener('click', (e) => e.stopPropagation());

    }



    /* Autocomplete */

    const wrap  = document.getElementById('zxSearchWrap');

    const form  = document.getElementById('zxSearchForm');

    const input = document.getElementById('zxSearchInput');

    const panel = document.getElementById('zxResults');

    const list  = document.getElementById('zxResultsList');



    if(!wrap || !form || !input || !panel || !list) return;



    let t = null;

    let lastQ = "";



    const openPanel = () => { panel.hidden = false; form.classList.add('is-active'); };

    const closePanel = () => { panel.hidden = true;  form.classList.remove('is-active'); };



    const render = (items) => {

        if(!items || items.length === 0){

            list.innerHTML = `<div class="zx-result-item"><p>No hay resultados</p></div>`;

            return;

        }

        list.innerHTML = items.map(it => `

            <div class="zx-result-item">

                <a href="${it.url}">${it.titulo}</a>

                ${it.descripcion ? `<p>${it.descripcion}</p>` : ``}

            </div>

        `).join('');

    };



    const fetchResults = async(q) => {

        const url = `/buscar-sugerencias?q=${encodeURIComponent(q)}`;

        const res = await fetch(url, { headers: { 'Accept': 'application/json' }});

        if(!res.ok) throw new Error("HTTP " + res.status);

        return await res.json();

    };



    input.addEventListener('focus', () => {

        form.classList.add('is-active');

        if(input.value.trim().length >= 1) openPanel();

    });



    input.addEventListener('input', () => {

        const q = input.value.trim();



        if(t) clearTimeout(t);

        t = setTimeout(async () => {

            if(q.length < 1){

                list.innerHTML = '';

                closePanel();

                return;

            }



            if(q === lastQ) return;

            lastQ = q;



            try{

                openPanel();

                const data = await fetchResults(q);

                render(data.items || []);

            }catch(e){

                render([]);

            }

        }, 200);

    });



    document.addEventListener('click', (e) => {

        if(!wrap.contains(e.target)) closePanel();

    });



    document.addEventListener('keydown', (e) => {

        if(e.key === 'Escape') closePanel();

    });

})();

</script>



<style>

:root{

    --bg:#28666e;

    --bg2:#1f5158;

    --accent:#fedc97;

    --shadow:0 12px 28px rgba(0,0,0,.25);

}



*{ margin:0; padding:0; box-sizing:border-box; }

a{ text-decoration:none; color:inherit; }

ul{ list-style:none; }



/* HEADER */

.zx-header{

    position: sticky;

    top: 0;

    z-index: 9999;

    background: linear-gradient(180deg,var(--bg),var(--bg2));

}



.zx-bar{

    width: 96%;

    max-width: 1600px;

    margin: auto;

    padding: 4px 0;

    display:flex;

    align-items:center;

    gap:18px;

    position:relative;

}



/* logo */

.zx-brand{

    width:110px;

    display:flex;

    justify-content:center;

    align-items:center;

    flex-shrink: 0;

}

.zx-brand img{ height:70px; width:auto; object-fit:contain; display:block; }



/* ============================================================
   CAMBIO 1: MENÚ HORIZONTAL EN DESKTOP
   ============================================================ */

/* En desktop el menú se muestra inline como fila */

@media(min-width: 820px){

    .zx-menu{

        position: static;

        display: flex !important;

        background: transparent;

        box-shadow: none;

        border-radius: 0;

        width: auto;

        margin-top: 0;

        padding: 0;

        flex-shrink: 0;

    }

    .zx-menu-root{

        display: flex;

        flex-direction: row;

        align-items: center;

        padding: 0;

        gap: 2px;

    }

    .zx-item-link{

        padding: 8px 14px;

        font-size: 13px;

        border-radius: 8px;

        white-space: nowrap;

    }

    /* Chevron apunta hacia abajo en desktop */

    .zx-chevron{

        transform: rotate(90deg);

        font-size: 10px;

        opacity: 0.6;

    }

    /* Submenú cae hacia abajo */

    .zx-sub{

        position: absolute;

        top: calc(100% + 8px);

        left: 0;

        width: 240px;

    }

}



/* En móvil el menú sigue siendo desplegable (se mantiene el comportamiento original) */

@media(max-width: 819px){

    .zx-menu{

        position: absolute;

        top: 100%;

        left: 0;

        margin-top: 10px;

        width: 300px;

        background: #173c41;

        border-radius: 14px;

        box-shadow: var(--shadow);

        display: none;

        z-index: 99999;

    }

    .zx-menu.is-open{ display: block; }



    .zx-menu-root{ padding: 10px; }

    .zx-sub{

        position: static;

        width: 100%;

        box-shadow: none;

        display: none;

    }

    .zx-item.is-open > .zx-sub{ display: block; }

    .zx-chevron{ transform: none; }

}



/* ============================================================
   CAMBIO 2: BUSCADOR MÁS REDUCIDO
   ============================================================ */

.zx-search-wrap{

    flex: 1;

    position: relative;

    display: flex;

    justify-content: flex-start;

    max-width: 400px; /* <-- ÚNICO CAMBIO: limita el ancho máximo */

}



.zx-search{

    width: 100%;

    max-width: none;

    display:flex;

    align-items:center;

    gap:10px;

    padding: 10px 24px;

    min-height: 25px;

    background: rgba(255,255,255,0.10);

    backdrop-filter: blur(6px);

    -webkit-backdrop-filter: blur(6px);

    border-radius: 18px;

    border: 2px solid rgba(255,255,255,0.45);

    box-shadow: 0 8px 20px rgba(0,0,0,0.15);

    box-sizing: border-box;

}



.zx-search.is-active{

    background:#fff;

    border-color:#234d50;

    box-shadow: 0 10px 22px rgba(0,0,0,.18);

}



.zx-search i{

    color: var(--accent);

    position: relative;

    left: 10px;

}

.zx-search.is-active i{ color:#234d50; }



.zx-search input{

    flex:1;

    border:0;

    background:none;

    outline:none;

    color:#fff;

    font-size: 16px;

    width: 100%;

}

.zx-search.is-active input{ color:#111; }

.zx-search input::placeholder{ color:rgba(255,255,255,.85); }

.zx-search.is-active input::placeholder{ color:rgba(0,0,0,.45); }



/* panel resultados */

.zx-results{

    position:absolute;

    top: calc(100% + 10px);

    left: 0;

    width: 100%;

    background:#fff;

    border-radius: 10px;

    box-shadow: 0 14px 30px rgba(0,0,0,.20);

    overflow:hidden;

    border: 1px solid rgba(0,0,0,.10);

    z-index: 99999;

}



.zx-results-title{

    background:#e7e7e7;

    padding: 12px 14px;

    font-weight: 800;

    color:#111;

}

.zx-results-list{

    max-height: 360px;

    overflow:auto;

}

.zx-result-item{

    padding: 14px 14px;

    border-top: 1px solid rgba(0,0,0,.08);

}

.zx-result-item a{

    color:#234d50;

    font-weight: 800;

}

.zx-result-item p{

    margin-top: 8px;

    color:#234d50;

    line-height: 1.35;

}



/* usuario */

.zx-user{

    background: transparent;

    border: 0;

    padding: 10px;

    display:flex;

    align-items:center;

    justify-content:center;

    cursor:pointer;

}

.zx-user i{

    color: var(--accent);

    font-size: 32px;

    transition: transform .15s ease, color .15s ease;

}

.zx-user:hover i{

    transform: scale(1.1);

    color: #fff;

}



.zx-logout-form{

    display:flex;

    align-items:center;

    margin:0;

}



/* menú — estilos compartidos */

.zx-item{ position:relative; }

.zx-item-link{

    padding:12px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap: 6px;

    font-weight:700;

    color:#fff;

    border-radius:10px;

}

.zx-item-link:hover{ background:rgba(255,255,255,.1); }



.zx-sub{

    display:none;

    background:#173c41;

    border-radius:14px;

    box-shadow:var(--shadow);

    padding:10px;

    z-index: 99999;

}

.zx-has-sub:hover > .zx-sub{ display:block; }



.zx-sub a{

    display:block;

    padding:10px;

    border-radius:8px;

}

.zx-sub a:hover{

    background:rgba(255,255,255,.1);

    color:var(--accent);

}



/* ============================================================

   BOTÓN USUARIO/LOGOUT

   ============================================================ */

.zx-logout-form{

    margin: 0 !important;

    padding: 0 !important;

    display: flex;

    align-items: center;

}



.zx-user-btn{

    all: unset !important;

    display: flex !important;

    align-items: center !important;

    justify-content: center !important;

    cursor: pointer !important;

    width: 42px !important;

    height: 42px !important;

}



.zx-user-btn i{

    font-size: 26px !important;

    color: var(--accent) !important;

    transition: transform .2s ease, color .2s ease;

}



.zx-user-btn:hover i{

    transform: scale(1.1);

    color: #ffffff !important;

}



/* responsive móvil */

@media(max-width:820px){

    .zx-brand{ width: 90px; }
    .zx-brand img{ height: 56px; }
    .zx-search-wrap{ justify-content:stretch; max-width: none; }
    .zx-search{ width: 100%; }

}
</style>
