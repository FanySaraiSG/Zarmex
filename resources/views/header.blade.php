<header class="zx-header">
    <div class="zx-bar">

        {{-- BOTÓN MENÚ --}}
        <button class="zx-ham" type="button" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>

        {{-- LOGO (redirige a inicio) --}}
        <a class="zx-brand" href="{{ url('/') }}">
            <img src="{{ asset('public/imagenes/logo.png') }}" alt="Zarmex"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
            <span class="zx-brand-fallback" style="display:none;">ZARMEX</span>
        </a>

        {{-- BUSCADOR --}}
        <form class="zx-search" action="{{ url('/buscar') }}" method="GET">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="q" placeholder="Buscar productos o servicios...">
        </form>

        {{-- USUARIO --}}
        <a class="zx-user" href="{{ url('/login') }}">
            <i class="fa-regular fa-circle-user"></i>
        </a>

        {{-- MENÚ DESPLEGABLE --}}
        <div class="zx-menu" id="zxMenu">
            <ul class="zx-menu-root">

                {{-- PRODUCTOS --}}
                <li class="zx-item zx-has-sub">
                    <a href="#" class="zx-item-link">
                        Productos
                        <i class="fa-solid fa-chevron-right"></i>
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
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    <ul class="zx-sub">
                        <li><a href="{{ url('mantenimiento') }}">Mantenimiento</a></li>
                        <li><a href="{{ url('reparación') }}">Reparación</a></li>
                    </ul>
                </li>

                {{-- NOSOTROS --}}
                <li class="zx-item">
                    <a href="{{ url('/nosotros') }}" class="zx-item-link">
                        Nosotros
                    </a>
                </li>

            </ul>
        </div>

    </div>
</header>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
:root{
    --bg:#28666e;
    --bg2:#1f5158;
    --accent:#fedc97;
    --text:#ffffff;
    --shadow:0 12px 28px rgba(0,0,0,.25);
}

*{ margin:0; padding:0; box-sizing:border-box; }
a{ text-decoration:none; color:inherit; }
ul{ list-style:none; }

/* HEADER */
.zx-header{
    background: linear-gradient(180deg,var(--bg),var(--bg2));
    padding: 18px 0;
}

/* BARRA */
.zx-bar{
    width: min(1200px, 92%);
    margin: auto;
    display:flex;
    align-items:center;
    gap:18px;
    position:relative;
}

/* HAMBURGUESA */
.zx-ham{
    background:none;
    border:0;
    cursor:pointer;
    display:flex;
    flex-direction:column;
    gap:6px;
}
.zx-ham span{
    width:34px;
    height:3px;
    background:var(--accent);
    border-radius:2px;
}

/* LOGO */
.zx-brand{
    width:120px;
    display:flex;
    justify-content:center;
}
.zx-brand img{ height:52px; }

/* BUSCADOR */
.zx-search{
    flex:1;
    display:flex;
    align-items:center;
    gap:10px;
    background:rgba(255,255,255,.15);
    border-radius:999px;
    padding:10px 16px;
}
.zx-search i{ color:var(--accent); }
.zx-search input{
    flex:1;
    border:0;
    background:none;
    outline:none;
    color:#fff;
}
.zx-search input::placeholder{ color:rgba(255,255,255,.8); }

/* USUARIO */
/* USUARIO (sin fondo) */
.zx-user{
    background: transparent;   /* ❌ fuera fondo morado */
    width: auto;
    height: auto;
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 6px;
}

.zx-user i{
    color: var(--accent);      /* dorado Zarmex */
    font-size: 28px;
    transition: transform .15s ease, color .15s ease;
}

.zx-user:hover i{
    transform: scale(1.1);
    color: #ffffff;
}


/* MENÚ */
.zx-menu{
    position:absolute;
    top:calc(100% + 10px);
    left:0;
    width:300px;
    background:#173c41;
    border-radius:14px;
    box-shadow:var(--shadow);
    display:none;
}
.zx-menu.is-open{ display:block; }

.zx-menu-root{ padding:10px; }
.zx-item-link{
    padding:12px;
    display:flex;
    justify-content:space-between;
    font-weight:700;
    color:#fff;
    border-radius:10px;
}
.zx-item-link:hover{ background:rgba(255,255,255,.1); }

/* SUBMENÚ */
.zx-sub{
    display:none;
    position:absolute;
    left:100%;
    top:0;
    width:320px;
    background:#173c41;
    border-radius:14px;
    box-shadow:var(--shadow);
    padding:10px;
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

/* MOBILE */
@media(max-width:820px){
    .zx-sub{
        position:static;
        width:100%;
        box-shadow:none;
    }
    .zx-has-sub:hover > .zx-sub{ display:none; }
    .zx-item.is-open > .zx-sub{ display:block; }
}
</style>

<script>
(() => {
    const ham = document.querySelector('.zx-ham');
    const menu = document.getElementById('zxMenu');

    ham.onclick = e => {
        e.stopPropagation();
        menu.classList.toggle('is-open');
    };

    document.onclick = () => menu.classList.remove('is-open');

    menu.querySelectorAll('.zx-has-sub > .zx-item-link').forEach(link=>{
        link.onclick = e=>{
            if(window.innerWidth < 820){
                e.preventDefault();
                link.parentElement.classList.toggle('is-open');
            }
        }
    });
})();
</script>
