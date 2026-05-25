<style>
    .zx-footer {
        background-color: rgba(20, 85, 85, 0.94);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        font-family: 'Figtree', sans-serif;
        color: #FFFFFF;
        clear: both;
        position: relative;
        width: 100%;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 25px 0 15px 0; 
    }

    .zx-container {
        max-width: 95%; /* Ocupa casi todo el ancho de la pantalla como en la imagen */
        margin: 0 auto;
        padding: 0 10px;
    }

    .zx-main-grid {
        display: flex;
        align-items: center; 
        justify-content: space-between;
        gap: 15px;
    }

    .zx-sections-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .zx-divider {
        width: 1px;
        background-color: rgba(254, 220, 151, 0.4); /* Línea dorada sutil */
        height: 55px;
        flex: 0 0 auto;
    }

    .zx-footer h4 {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 0;
        margin-bottom: 12px;
        color: #fedc97; 
        letter-spacing: 0.5px;
    }

    .zx-list-item {
        display: inline-flex;
        align-items: center;
        font-size: 12px;
        text-decoration: none;
        color: #FFFFFF;
    }

    .zx-list-item i {
        width: 22px;
        height: 22px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fedc97; /* Fondo dorado uniforme para los contactos */
        color: #145555;
        margin-right: 8px;
        flex-shrink: 0;
    }

    /* Redes Sociales en Grid Horizontal Alternado */
    .zx-follow-flex {
        display: grid;
        grid-template-columns: auto auto;
        gap: 12px 20px;
        align-items: center;
    }

    /* Ajuste específico para los círculos de las redes sociales */
    .zx-social-item i {
        background: #FFFFFF !important; /* Círculo blanco para redes sociales */
    }

    .zx-social-item span {
        color: #FFFFFF;
    }

    /* Bloque de contacto en dos columnas perfectas */
    .zx-double-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
        gap: 10px 30px; 
    }

    .zx-footer-bottom {
        margin-top: 20px; 
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        font-size: 10px;
        color: rgba(164, 194, 188, 0.7);
    }

    .zx-line-gold {
        height: 1px;
        background-color: rgba(254, 220, 151, 0.3);
        flex: 0 0 120px;
    }

    /* Contenedor del Mapa - Fijo y Limpio a la derecha */
    .map-container {
        width: 220px; 
        height: 95px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    /* Responsivo básico para pantallas medianas/pequeñas */
    @media (max-width: 1100px) {
        .zx-main-grid {
            flex-direction: column;
            text-align: center;
            gap: 25px;
        }
        .zx-sections-wrapper {
            flex-direction: column;
            gap: 20px;
            width: 100%;
        }
        .zx-divider { display: none; }
        .zx-follow-flex, .zx-double-list {
            grid-template-columns: 1fr;
            justify-items: center;
        }
        .map-container { margin: 0 auto; }
    }
</style>

<footer class="zx-footer">
    <div class="zx-container">
        <div class="zx-main-grid">
            
            <div class="zx-sections-wrapper">
                <div> 
                    <h4>Síguenos</h4>
                    <div class="zx-follow-flex">
                        <a href="https://www.facebook.com/share/1KgteSrEB2/" class="zx-social-item zx-list-item" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f" style="color:#1877F2;"></i>
                            <span>Equipos Médicos Zarmex</span>
                        </a>
                        <div style="display:none;"></div> <a href="https://www.instagram.com/zarmex_oficialmx/" class="zx-social-item zx-list-item" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-instagram" style="color:#E4405F;"></i>
                            <span>Zarmex_oficialmx</span>
                        </a>
                        <a href="https://www.tiktok.com/@zarmex_oficial" class="zx-social-item zx-list-item" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-tiktok" style="color:#000000;"></i>
                            <span>Zarmex_oficial</span>
                        </a>
                    </div>
                </div>

                <div class="zx-divider"></div>

                <div>
                    <h4>Contacto</h4>
                    <div class="zx-double-list">
                        <a href="tel:+525581366555" class="zx-list-item"><i class="fas fa-phone-alt"></i> +52 55 8136 6555</a>
                        <a href="mailto:zarmex.mexico@gmail.com" class="zx-list-item"><i class="fas fa-envelope"></i> zarmex.mexico@gmail.com</a>
                        <a href="mailto:contacto@zarmex.com" class="zx-list-item"><i class="fas fa-envelope"></i> contacto@zarmex.com</a>
                        <a href="mailto:soporte.zarmex@gmail.com" class="zx-list-item"><i class="fas fa-life-ring"></i> soporte.zarmex@gmail.com</a>
                    </div>
                </div>

                <div class="zx-divider"></div>

                <div>
                    <h4>Ubicación</h4>
                    <div class="zx-list-item">
                        <i class="fas fa-map-marker-alt" style="background: transparent; color: #fedc97; font-size: 16px; width: auto; margin-right: 10px;"></i> 
                        Plaza Neza · Local B03
                    </div>
                </div>
            </div>

            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps?q=Equipos%20Médicos%20ZARMEX&output=embed"
                    width="100%"
                    height="100%" 
                    style="border:0; display:block;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
        </div>

        <div class="zx-footer-bottom">
            <div class="zx-line-gold"></div>
            <span>© 2026 Zarmex. Todos los derechos reservados.</span>
            <div class="zx-line-gold"></div>
        </div>
    </div>
</footer>