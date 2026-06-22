@php
    $isAdminArea = request()->is('employees/*');
    $logo = \App\Models\Imagen::where('seccion', 'logo')->first();
    $ruta = $logo->imagen_url ?? null;

    if ($ruta) {
        $ruta = str_replace('\\', '/', $ruta);
        $ruta = ltrim($ruta, '/');
    }

    $logoUrl = $ruta ? asset($ruta) : asset('imagenes/logo.jpeg');

    // Festividad activa (CSS festivo)
    $festividad = \App\Models\Festividad::getActiva();
@endphp

{{-- CLASE zx-hidden-mode POR DEFECTO PARA INICIAR CON EL MENÚ COLAPSADO --}}
<header class="zx-header zx-hidden-mode" id="zxMainHeader">
    <div class="zx-bar">

        {{-- 1. LOGO INTERACTIVO Y MARCA (IMAGEN O TEXTO ORIGINAL) --}}
        <div class="zx-brand-wrapper">
            <button type="button" class="zx-logo-toggle-btn zx-pulse-waves" id="zxLogoToggle" title="Ocultar/Mostrar menú">
                <div class="zx-logo-circle">
                    <img src="{{ $logoUrl }}" alt="Zarmex" onerror="this.style.display='none';">
                    
                    <div class="zx-logo-badge" id="zxLogoBadge">
                        <i class="fas fa-arrow-right" id="zxBadgeIcon"></i>
                    </div>
                </div>
            </button>
            
            <a class="zx-brand-text-link" href="{{ url('/') }}">
                <div class="zx-brand-festivo-wrap">

                    {{-- Decoraciones animadas --}}
                    @if($festividad && $festividad->decoraciones)
                        @php $decos = $festividad->decoraciones; @endphp
                        <div class="zx-deco-container" aria-hidden="true">

                            @if(in_array('nieve', $decos))
                                <span class="zxd zxd-snow" style="left:5%;top:-18px;animation-delay:0s;">❄</span>
                                <span class="zxd zxd-snow" style="left:25%;top:-22px;animation-delay:.5s;font-size:9px;">❅</span>
                                <span class="zxd zxd-snow" style="left:50%;top:-16px;animation-delay:1s;">❄</span>
                                <span class="zxd zxd-snow" style="left:75%;top:-20px;animation-delay:1.5s;font-size:9px;">❅</span>
                                <span class="zxd zxd-snow" style="left:90%;top:-18px;animation-delay:.8s;">❄</span>
                            @endif

                            @if(in_array('flores', $decos))
                                <span class="zxd zxd-float" style="left:-18px;top:-14px;animation-delay:0s;">🌸</span>
                                <span class="zxd zxd-float" style="right:-18px;top:-14px;animation-delay:.2s;">🌼</span>
                                <span class="zxd zxd-float" style="left:35%;top:-18px;animation-delay:.4s;font-size:11px;">🌸</span>
                                <span class="zxd zxd-float" style="left:65%;bottom:-16px;animation-delay:.1s;font-size:10px;">🌼</span>
                            @endif

                            @if(in_array('velas', $decos))
                                <span class="zxd zxd-blink" style="left:8%;bottom:-18px;animation-delay:0s;">🕯️</span>
                                <span class="zxd zxd-blink" style="left:48%;bottom:-18px;animation-delay:.4s;">🕯️</span>
                                <span class="zxd zxd-blink" style="right:8%;bottom:-18px;animation-delay:.8s;">🕯️</span>
                            @endif

                            @if(in_array('murcielagos', $decos))
                                <span class="zxd zxd-fly" style="left:-20px;top:-12px;animation-delay:0s;">🦇</span>
                                <span class="zxd zxd-fly" style="right:-20px;top:-10px;animation-delay:.6s;">🦇</span>
                            @endif

                            @if(in_array('fantasmas', $decos))
                                <span class="zxd zxd-float" style="left:-20px;top:50%;transform:translateY(-50%);animation-delay:0s;">👻</span>
                                <span class="zxd zxd-float" style="right:-20px;top:50%;transform:translateY(-50%);animation-delay:.5s;">👻</span>
                            @endif

                            @if(in_array('calabazas', $decos))
                                <span class="zxd" style="left:10%;bottom:-18px;">🎃</span>
                                <span class="zxd" style="right:10%;bottom:-18px;">🎃</span>
                            @endif

                            @if(in_array('corazones', $decos))
                                <span class="zxd zxd-rise" style="left:10%;bottom:0;animation-delay:0s;">❤️</span>
                                <span class="zxd zxd-rise" style="left:30%;bottom:0;animation-delay:.5s;font-size:10px;">💕</span>
                                <span class="zxd zxd-rise" style="left:55%;bottom:0;animation-delay:1s;">❤️</span>
                                <span class="zxd zxd-rise" style="left:75%;bottom:0;animation-delay:.3s;font-size:10px;">💕</span>
                                <span class="zxd zxd-rise" style="left:90%;bottom:0;animation-delay:.7s;">❤️</span>
                            @endif

                            @if(in_array('confetti', $decos))
                                <span class="zxd zxd-snow" style="left:10%;top:-16px;animation-delay:0s;">🎊</span>
                                <span class="zxd zxd-snow" style="left:40%;top:-18px;animation-delay:.6s;">🎉</span>
                                <span class="zxd zxd-snow" style="left:70%;top:-14px;animation-delay:1.1s;">🎊</span>
                            @endif

                            @if(in_array('estrellas', $decos))
                                <span class="zxd zxd-spin" style="left:-18px;top:50%;transform:translateY(-50%);">⭐</span>
                                <span class="zxd zxd-spin" style="right:-18px;top:50%;transform:translateY(-50%);animation-delay:.5s;">✨</span>
                                <span class="zxd zxd-float" style="left:45%;top:-16px;animation-delay:.3s;font-size:10px;">⭐</span>
                            @endif

                            @if(in_array('rosas', $decos))
                                <span class="zxd" style="left:-20px;top:50%;transform:translateY(-50%);">🌹</span>
                                <span class="zxd" style="right:-20px;top:50%;transform:translateY(-50%);">🌹</span>
                            @endif

                            @if(in_array('acebo', $decos))
                                <span class="zxd" style="left:-20px;top:50%;transform:translateY(-50%);">🍃</span>
                                <span class="zxd" style="right:-20px;top:50%;transform:translateY(-50%);">🍃</span>
                            @endif

                            @if(in_array('banderas', $decos))
                                <span class="zxd" style="left:-20px;top:50%;transform:translateY(-50%);">🇲🇽</span>
                                <span class="zxd" style="right:-20px;top:50%;transform:translateY(-50%);">🇲🇽</span>
                            @endif
                            @if(in_array('fuegos', $decos))
                                <span class="zxd zxd-rise" style="left:15%;bottom:0;animation-delay:0s;">🎆</span>
                                <span class="zxd zxd-rise" style="left:50%;bottom:0;animation-delay:.7s;">🎇</span>
                                <span class="zxd zxd-rise" style="left:80%;bottom:0;animation-delay:1.2s;">🎆</span>
                            @endif

                            @if(in_array('arboles', $decos))
                                <span class="zxd zxd-blink" style="left:-18px;top:50%;transform:translateY(-50%);animation-delay:0s;">🎄</span>
                                <span class="zxd zxd-blink" style="right:-18px;top:50%;transform:translateY(-50%);animation-delay:.6s;">🎄</span>
                            @endif

                            @if(in_array('regalos', $decos))
                                <span class="zxd" style="left:10%;bottom:-18px;">🎁</span>
                                <span class="zxd" style="left:50%;bottom:-18px;">🎀</span>
                                <span class="zxd" style="right:10%;bottom:-18px;">🎁</span>
                            @endif

                            @if(in_array('campanas', $decos))
                                <span class="zxd zxd-float" style="left:-18px;top:-14px;animation-delay:0s;">🔔</span>
                                <span class="zxd zxd-float" style="right:-18px;top:-14px;animation-delay:.4s;">🔔</span>
                            @endif

                            @if(in_array('globos', $decos))
                                <span class="zxd zxd-float" style="left:5%;top:-18px;animation-delay:0s;">🎈</span>
                                <span class="zxd zxd-float" style="left:40%;top:-20px;animation-delay:.5s;">🎈</span>
                                <span class="zxd zxd-float" style="right:5%;top:-16px;animation-delay:1s;">🎈</span>
                            @endif

                            @if(in_array('soles', $decos))
                                <span class="zxd zxd-spin" style="left:-18px;top:50%;font-size:14px;animation-delay:0s;">☀️</span>
                                <span class="zxd zxd-spin" style="right:-18px;top:50%;font-size:12px;animation-delay:.8s;">🌟</span>
                                <span class="zxd zxd-float" style="left:45%;top:-16px;animation-delay:.3s;font-size:11px;">✨</span>
                            @endif

                            @if(in_array('lunas', $decos))
                                <span class="zxd zxd-float" style="left:-18px;top:50%;transform:translateY(-50%);animation-delay:0s;">🌙</span>
                                <span class="zxd zxd-float" style="right:-18px;top:50%;transform:translateY(-50%);animation-delay:.6s;">⭐</span>
                            @endif

                            @if(in_array('arcoiris', $decos))
                                <span class="zxd zxd-float" style="left:30%;top:-20px;animation-delay:0s;">🌈</span>
                            @endif

                            @if(in_array('mariposas', $decos))
                                <span class="zxd zxd-fly" style="left:-20px;top:-12px;animation-delay:0s;">🦋</span>
                                <span class="zxd zxd-fly" style="right:-20px;top:-10px;animation-delay:.4s;">🦋</span>
                                <span class="zxd zxd-fly" style="left:40%;top:-18px;animation-delay:.8s;font-size:10px;">🦋</span>
                            @endif

                            @if(in_array('diamantes', $decos))
                                <span class="zxd zxd-spin" style="left:-18px;top:50%;font-size:12px;">💎</span>
                                <span class="zxd zxd-spin" style="right:-18px;top:50%;font-size:12px;animation-delay:.5s;">💎</span>
                            @endif

                            @if(in_array('coronas', $decos))
                                <span class="zxd zxd-float" style="left:35%;top:-22px;animation-delay:0s;">👑</span>
                            @endif

                            @if(in_array('notas', $decos))
                                <span class="zxd zxd-rise" style="left:10%;bottom:0;animation-delay:0s;">🎵</span>
                                <span class="zxd zxd-rise" style="left:35%;bottom:0;animation-delay:.5s;">🎶</span>
                                <span class="zxd zxd-rise" style="left:60%;bottom:0;animation-delay:1s;">🎵</span>
                                <span class="zxd zxd-rise" style="left:85%;bottom:0;animation-delay:.3s;">🎶</span>
                            @endif

                            @if(in_array('serpentinas', $decos))
                                <span class="zxd zxd-snow" style="left:20%;top:-18px;animation-delay:0s;">🎊</span>
                                <span class="zxd zxd-snow" style="left:50%;top:-22px;animation-delay:.4s;">🎉</span>
                                <span class="zxd zxd-snow" style="left:75%;top:-16px;animation-delay:.9s;">🎊</span>
                                <span class="zxd zxd-snow" style="left:5%;top:-20px;animation-delay:1.3s;font-size:10px;">🎉</span>
                            @endif

                            @if(in_array('brujitas', $decos))
                                <span class="zxd zxd-fly" style="left:-20px;top:50%;transform:translateY(-50%);animation-delay:0s;">🧙</span>
                                <span class="zxd zxd-fly" style="right:-20px;top:50%;transform:translateY(-50%);animation-delay:.5s;">🧙</span>
                            @endif

                        </div>

                    @endif

                    {{-- Texto principal --}}
                    @if($festividad)
                        @php
                            $efecto = $festividad->efecto;
                            $color  = $festividad->color_texto;

                            // Efectos que se aplican con clase CSS (no inline)
                            $clasesCSS = ['tricolor','outline','rainbow','fire','ice','neon','vintage',
                                          'pulse','shimmer','retro','matrix','pirate','carnival','coral','aurora','lava'];

                            if (in_array($efecto, $clasesCSS)) {
                                $estiloTexto  = "color:{$color};";
                                $claseEfecto  = "zx-brand-{$efecto}";
                            } else {
                                $claseEfecto = '';
                                $estiloTexto = "color:{$color};";
                                if ($efecto === 'glow')
                                    $estiloTexto .= "text-shadow:0 0 10px {$color}99,0 0 25px {$color}66;";
                                elseif ($efecto === 'shadow')
                                    $estiloTexto .= "text-shadow:2px 2px 6px rgba(0,0,0,.8);";
                            }
                        @endphp

                        <span class="zx-brand-name {{ $claseEfecto }}" style="{{ $estiloTexto }}">{{ $festividad->texto_header }}</span>
                    @else
                        <span class="zx-brand-name">ZARMEX</span>
                    @endif

                </div>
            </a>
        </div>

        {{-- BOTÓN HAMBURGUESA PRINCIPAL (MÓVIL)--}}
        <button class="zx-ham" id="zxHam" type="button" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>

        {{-- 2. MENÚ PRINCIPAL ADAPTATIVO --}}
        <div class="zx-menu" id="zxMenu">
            <ul class="zx-menu-root">
                <li class="zx-item zx-has-sub">
                    <a href="#" class="zx-item-link">
                        <span style="display:none;"></span>
                        <span>Productos</span>
                        <i class="fas fa-chevron-down zx-chevron"></i>
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
                        <i class="fas fa-chevron-down zx-chevron"></i>
                    </a>
                    <ul class="zx-sub">
                        <li><a href="{{ url('mantenimiento') }}">Mantenimiento</a></li>
                        <li><a href="{{ url('submit_reparacion') }}">Reparación</a></li>
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

        {{-- 3. BUSCADOR EN TIEMPO REAL --}}
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

        {{-- 4. ACCESO ADMINISTRATIVO / LOGIN --}}
        <div class="zx-user-actions">
            @if($isAdminArea)
                @auth('employee')
                    <form method="POST" action="{{ route('employee.logout') }}" class="zx-inline-form">
                        @csrf
                        <button class="zx-user-btn zx-logout" type="submit" title="Salir"><i class="fas fa-power-off"></i></button>
                    </form>
                @else
                    <a class="zx-user-profile" href="{{ route('employee.login') }}" title="Mi Cuenta">
                        <div class="zx-avatar-icon">
                            <i class="fas fa-user-tie"></i>
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
    
    transition: width 0.4s cubic-bezier(0.25, 1, 0.5, 1), 
                left 0.4s cubic-bezier(0.25, 1, 0.5, 1),
                transform 0.4s cubic-bezier(0.25, 1, 0.5, 1),
                background-color 0.4s ease, 
                border-color 0.4s ease;
}   

/* ESTADO COLAPSADO (SÓLO MUESTRA EL LOGO CIRCULAR) */
.zx-header.zx-hidden-mode {
    left: 4%; 
    transform: translateX(0); 
    width: 95px !important; 
    background: rgba(14, 43, 36, 0.65) !important; 
    border-top-color: transparent !important;
    border-bottom-color: transparent !important;
    box-shadow: 0 6px 22px rgba(184, 161, 32, 0.45) !important; 
}

/* Ocultar elementos en modo colapsado */
.zx-header.zx-hidden-mode .zx-brand-text-link,
.zx-header.zx-hidden-mode .zx-ham,
.zx-header.zx-hidden-mode .zx-menu,
.zx-header.zx-hidden-mode .zx-search-wrap,
.zx-header.zx-hidden-mode .zx-user-actions {
    display: none !important;
}

/* CONTENEDOR DE LA IMAGEN/TEXTO DE MARCA */
.zx-brand-text-link {
    text-decoration: none;
    display: flex;
    align-items: center;
    height: 100%; /* Permite usar todo el espacio vertical disponible */
}

/* ✅ CORREGIDO: Forzado de escala e impacto visual para igualar al texto original */
.zx-brand-img {
    height: 58px;          /* Escala aumentada para expandir las letras reales dentro de la barra */
    width: auto;           /* Mantiene las proporciones correctas sin deformaciones */
    flex-shrink: 0;        /* Evita que los elementos contiguos compriman el logo */
    object-fit: contain;   
    display: block;
    padding: 0 15px;       /* Mismo espacio de separación interno */
    border-right: 3px dotted rgba(184, 161, 32, 0.55); /* Recupera la línea punteada divisoria */
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

.zx-header.zx-hidden-mode .zx-bar {
    padding: 0 10px;
    justify-content: center;
}

/* CONTENEDOR DE LOGO */
.zx-brand-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    height: 100%;
}

.zx-logo-toggle-btn {
    background: none;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
    outline: none;
    display: block;
    position: relative;
    border-radius: 50%;
    flex-shrink: 0;
}

.zx-logo-circle {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    border: 2px solid var(--gold);
    overflow: visible; 
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(14, 43, 36, 0.8); 
    position: relative;
    flex-shrink: 0;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), border-color 0.3s ease;
}

.zx-logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

/* INDICADOR DE ESTADO EN LA ESQUINA DEL LOGO */
.zx-logo-badge {
    position: absolute;
    bottom: -1px;
    right: -1px;
    background: var(--gold);
    color: #0e2b24;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    border: 2px solid #ffffff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.4);
    z-index: 2;
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
}

/* ONDAS EXPANSIVAS DINÁMICAS */
.zx-pulse-waves::before,
.zx-pulse-waves::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    border-radius: 50%;
    border: 3.5px solid var(--gold); 
    opacity: 0;
    z-index: -1;
    pointer-events: none;
    animation: zxWaveEffectPotent 2.4s infinite cubic-bezier(0.25, 0, 0, 1);
}

.zx-pulse-waves::after {
    animation-delay: 1.2s;
}

@keyframes zxWaveEffectPotent {
    0% {
        transform: scale(0.98);
        opacity: 0.85; 
    }
    50% {
        opacity: 0.55;
    }
    100% {
        transform: scale(1.45); 
        opacity: 0;
    }
}

.zx-logo-toggle-btn:hover .zx-logo-circle {
    transform: scale(1.06);
    border-color: #ffffff;
    box-shadow: 0 0 15px rgba(184, 161, 32, 0.6);
}

.zx-logo-toggle-btn:hover .zx-logo-badge {
    background: #ffffff;
    color: var(--bg);
    transform: scale(1.15);
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
    transition: color 0.3s ease, text-shadow 0.3s ease, letter-spacing 0.3s ease;
}

.zx-brand-text-link:hover .zx-brand-name {
    color: var(--gold);
    text-shadow:
        0 0 8px rgba(184, 161, 32, 0.9),
        0 0 20px rgba(184, 161, 32, 0.6),
        0 0 40px rgba(184, 161, 32, 0.3);
    letter-spacing: 7px;
}

/* ESTILOS DEL MENÚ GRANDE */
.zx-menu {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1 1 auto;
    min-width: 0;
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
    margin-left: 5px;
}

/* BARRA DE BÚSQUEDA */
.zx-search-wrap {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1 1 300px;
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

/* DESPLEGABLE DE SUGERENCIAS AJAX */
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

/* ACCIONES DE PERFIL Y BOTONES */
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

/* SUBMENÚS DESPLEGABLES DROPDOWN */
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

/* MENÚ HAMBURGUESA MÓVIL */
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

/* ── SISTEMA FESTIVO ── */
.zx-brand-festivo-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
    isolation: isolate;
}

.zx-deco-container {
    position: absolute;
    left: 8px;
    right: 8px;
    top: 0;
    bottom: 0;
    pointer-events: none;
    overflow: visible;
}

.zxd {
    position: absolute;
    font-size: 16px;
    pointer-events: none;
    line-height: 1;
}

/* Animaciones decorativas */
@keyframes zxSnow  { 0%{transform:translateY(0);opacity:.9} 100%{transform:translateY(55px);opacity:0} }
@keyframes zxFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }
@keyframes zxRise  { 0%{transform:translateY(0);opacity:.9} 100%{transform:translateY(-48px);opacity:0} }
@keyframes zxSpin  { from{transform:translateY(-50%) rotate(0deg)} to{transform:translateY(-50%) rotate(360deg)} }
@keyframes zxFly   { 0%,100%{transform:translateX(0)} 50%{transform:translateX(5px)} }
@keyframes zxBlink { 0%,100%{opacity:.6} 50%{opacity:1} }

.zxd-snow  { animation: zxSnow  3s linear   infinite; }
.zxd-float { animation: zxFloat 2s ease-in-out infinite alternate; }
.zxd-rise  { animation: zxRise  2.5s ease-in-out infinite; opacity:0; }
.zxd-spin  { animation: zxSpin  4s linear   infinite; }
.zxd-fly   { animation: zxFly   1.8s ease-in-out infinite alternate; }
.zxd-blink { animation: zxBlink 1.2s ease-in-out infinite alternate; }

/* ── EFECTOS FESTIVOS EXTRA ── */
@keyframes zxPulse   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.7;transform:scale(1.04)} }
@keyframes zxShimmer { 0%{background-position:200% center} 100%{background-position:-200% center} }
@keyframes zxMatrix  { 0%,100%{text-shadow:0 0 4px #00ff41,0 0 10px #00ff41} 50%{text-shadow:0 0 12px #00ff41,0 0 30px #00ff41,0 0 50px #00ff41} }
@keyframes zxLava    { 0%,100%{text-shadow:0 0 8px #ff4500,0 0 20px #ff6600} 50%{text-shadow:0 0 16px #ff0000,0 0 40px #ff4500,0 0 60px #ff8c00} }
@keyframes zxCarnival{ 0%{color:#ff0080} 16%{color:#ff8c00} 33%{color:#ffe600} 50%{color:#00e676} 66%{color:#00bcd4} 83%{color:#9c27b0} 100%{color:#ff0080} }
@keyframes zxAurora  { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }

.zx-brand-outline {
    -webkit-text-stroke: 1.5px currentColor;
    -webkit-text-fill-color: transparent;
}
.zx-brand-rainbow {
    background: linear-gradient(90deg,#ff0080,#ff8c00,#ffe600,#00e676,#00bcd4,#9c27b0,#ff0080);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: zxShimmer 3s linear infinite;
}
.zx-brand-fire {
    animation: zxLava 1.5s ease-in-out infinite;
}
.zx-brand-ice {
    color: #a8e6ff !important;
    text-shadow: 0 0 8px #a8e6ff, 0 0 20px #0ff, 0 0 40px #0ff !important;
}
.zx-brand-neon {
    text-shadow: 0 0 5px currentColor, 0 0 15px currentColor, 0 0 30px currentColor, 0 0 60px currentColor !important;
}
.zx-brand-vintage {
    filter: sepia(60%) contrast(110%);
    letter-spacing: 8px !important;
}
.zx-brand-pulse {
    animation: zxPulse 1.8s ease-in-out infinite;
}
.zx-brand-shimmer {
    background: linear-gradient(90deg, currentColor 20%, #fff 50%, currentColor 80%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: zxShimmer 2s linear infinite;
}
.zx-brand-retro {
    font-family: 'Courier New', monospace !important;
    text-shadow: 3px 3px 0 rgba(0,0,0,.5) !important;
    letter-spacing: 8px !important;
}
.zx-brand-matrix {
    color: #00ff41 !important;
    animation: zxMatrix 1.5s ease-in-out infinite;
}
.zx-brand-pirate {
    font-style: italic !important;
    text-shadow: 3px 3px 6px rgba(0,0,0,.9), -1px -1px 0 #8b0000 !important;
}
.zx-brand-carnival {
    animation: zxCarnival 1s linear infinite;
    font-weight: 900 !important;
}
.zx-brand-coral {
    background: linear-gradient(135deg, #ff6b6b, #ffd93d, #6bcb77, #4d96ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.zx-brand-aurora {
    background: linear-gradient(270deg, #00c9ff, #92fe9d, #f7971e, #a855f7, #00c9ff);
    background-size: 400% 400%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: zxAurora 4s ease infinite;
}
.zx-brand-lava {
    background: linear-gradient(90deg, #ff4500, #ff6600, #ff8c00, #ff4500);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: zxShimmer 2s linear infinite;
}

/* Efecto tricolor */
.zx-brand-tricolor {
    background: linear-gradient(90deg, #006847 33%, #ffffff 33%, #ffffff 66%, #ce1126 66%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800 !important;
}

/* ── RESPONSIVE MEDIA QUERIES ── */
@media (max-width: 1150px) {
    .zx-brand-name { display: inline-block; }
}

@media (max-width: 991px) {
    .zx-bar { height: 75px; }
    .zx-ham { display: block; }
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
        display: none; 
        z-index: 10002;
        margin-left: 0;
        margin-top: 8px;
    }
    .zx-menu.is-open { display: flex; }
    .zx-menu-root { flex-direction: column; align-items: stretch; gap: 8px; }
    .zx-item:not(:last-child) {
        border-right: none;
        padding-right: 0;
        border-bottom: 1px dashed rgba(184, 161, 32, 0.2);
        padding-bottom: 8px;
    }
    .zx-item-link { width: 100%; padding: 10px; justify-content: space-between; }
    .zx-sub { position: static; transform: none; width: 100%; box-shadow: none; background: rgba(20, 85, 85, 0.4); margin-top: 6px; display: none; }
    .zx-has-sub:hover .zx-sub { display: none; }
    .zx-has-sub.is-open .zx-sub { display: block; }
}

@media (max-width: 650px) {
    .zx-bar { display: flex; flex-direction: row; justify-content: space-between; align-items: center; gap: 8px; height: 75px; padding: 0 12px; }
    .zx-brand-name { display: none; }
    .zx-brand { padding-right: 0; }
    .zx-search-wrap { flex: 1 1 auto; max-width: 100%; }
    .zx-search { height: 40px; padding: 0 10px; }
    .zx-search input { font-size: 12px; }
    .zx-menu { top: 100%; max-height: calc(100vh - 120px); overflow: auto; -webkit-overflow-scrolling: touch; }
    
    .zx-header.zx-hidden-mode {
        left: 4%;
    }
}
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Control de colapso inteligente lateral izquierdo (Logo Circular)
    const logoToggle = document.getElementById('zxLogoToggle');
    const mainHeader = document.getElementById('zxMainHeader');
    const badgeIcon = document.getElementById('zxBadgeIcon');

    if (logoToggle && mainHeader) {
      logoToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation(); 
        
        const isHidden = mainHeader.classList.toggle('zx-hidden-mode');
        
        // Cambiar dinámicamente flechas FontAwesome v5
        if (badgeIcon) {
          if (isHidden) {
            badgeIcon.className = 'fas fa-arrow-right';
          } else {
            badgeIcon.className = 'fas fa-arrow-left';
          }
        }
      });
    }

    // Control del Menú Móvil Hamburguesa
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

    // Motor de Búsqueda Predictivo / Sugerencias Ajax
    const input = document.getElementById('zxSearchInput');
    const resultsWrap = document.getElementById('zxResults');
    const GalaList = document.getElementById('zxResultsList');

    if (!input || !resultsWrap || !GalaList) return;

    const debounce = (fn, ms = 250) => {
      let t;
      return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), ms);
      };
    };

    const renderItems = (items) => {
      GalaList.innerHTML = '';

      if (!items || items.length === 0) {
        GalaList.innerHTML = '<div style="padding: 10px; color:#58776f;">Sin resultados</div>';
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

      GalaList.appendChild(frag);
      resultsWrap.hidden = false;
    };

    const hideResults = () => { resultsWrap.hidden = true; GalaList.innerHTML = ''; };

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
    const getItems = () => Array.from(GalaList.querySelectorAll('.zx-search-item'));

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