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
        border-top: 1px solid #eee;
        margin-top: 60px; 
        padding: 20px 0 10px 0; 
    }

    .zx-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 70px;
    }

    .zx-main-grid {
        display: flex;
        flex-wrap: wrap;
        align-items: center; 
    }

    .zx-sections-wrapper {
        flex: 1;
        display: flex;
        align-items: center; 
        justify-content: space-between;
    }

    .zx-divider {
        width: 1px;
        background-color: #fedc97;
        height: 100px; 
        margin: 0 35px; 
    }

    .zx-footer h4 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 12px;
        color: #fedc97; 
    }

    .zx-list-item {
        display: flex;
        align-items: center;
        font-size: 13px;
        margin-bottom: 8px;
        text-decoration: none;
        color: #FFFFFF;
        white-space: nowrap; /* Evita que el texto largo se rompa en dos renglones */
    }

    .zx-list-item i {
        width: 24px;
        margin-right: 8px;
        height: 24px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        color: #145555;
    }

    /* ========================================================= */
    /* ACOMODO ESTÉTICO: Flexbox para la sección Síguenos       */
    /* ========================================================= */
    .zx-follow-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 30px; /* 10px de espacio arriba/abajo, 30px entre elementos */
        max-width: 400px;
    }

    .zx-double-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
        gap: 0 20px; 
    }

    .contacto-item i {
        background: #fedc97;
        color: #145555 !important;
    }

    .zx-footer-bottom {
        margin-top: 15px; 
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        font-size: 11px;
        color: #A4C2BC;
    }

    .zx-line-gold {
        height: 1px;
        background-color: #fedc97;
        flex: 0 0 150px;
    }

    .map-container {
        width: 250px; 
        border-radius: 8px;
        overflow: hidden;
    }

    @media (max-width: 900px) {
        .zx-sections-wrapper {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .zx-double-list, .zx-follow-flex {
            grid-template-columns: 1fr;
            flex-direction: column;
            align-items: center;
        }
        .zx-divider { display: none; }
        .map-container { margin-top: 15px; }
    }
</style>

<footer class="zx-footer">
    <div class="zx-container">
        <div class="zx-main-grid">
            
            <div class="zx-sections-wrapper">
                <div style="flex: 1.5; margin-left: 25px;"> <h4>Síguenos</h4>
                    <div class="zx-follow-flex">
                        <a href="#" class="zx-list-item">
                            <i class="fab fa-facebook-f" style="color:#1877F2;"></i> Equipos Médicos Zarmex
                        </a>
                        <a href="#" class="zx-list-item">
                            <i class="fab fa-instagram" style="color:#E4405F;"></i> Zarmex_oficialmx
                        </a>
                        <a href="#" class="zx-list-item">
                            <i class="fab fa-tiktok" style="color:#000000;"></i> Zarmex_oficial
                        </a>
                    </div>
                </div>

                <div class="zx-divider"></div>

                <div style="flex: 1.8;">
                    <h4>Contacto</h4>
                    <div class="zx-double-list">
                        <div>
                            <div class="zx-list-item contacto-item"><i class="fas fa-phone-alt"></i> +52 55 8136 6555</div>
                            <div class="zx-list-item contacto-item"><i class="fas fa-envelope"></i> contacto@zarmex.com</div>
                        </div>
                        <div>
                            <div class="zx-list-item contacto-item"><i class="fas fa-envelope"></i> zarmex.mexico@gmail.com</div>
                            <div class="zx-list-item contacto-item"><i class="fas fa-life-ring"></i> soporte.zarmex@gmail.com</div>
                        </div>
                    </div>
                </div>

                <div class="zx-divider"></div>

                <div style="flex: 1;">
                    <h4>Ubicación</h4>
                    <div class="zx-list-item" style="margin-bottom: 15px;">
                        <i class="fas fa-map-marker-alt" style="background: transparent; color: #fedc97; font-size: 18px; width: auto;"></i> 
                        Plaza Neza · Local B03
                    </div>
                </div>

                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps?q=Equipos%20Médicos%20ZARMEX&output=embed"
                        width="100%"
                        height="130" 
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            
        </div>

        <div class="zx-footer-bottom">
            <div class="zx-line-gold"></div>
            <span>© 2026 Zarmex. Todos los derechos reservados.</span>
            <div class="zx-line-gold"></div>
        </div>
    </div>
</footer>