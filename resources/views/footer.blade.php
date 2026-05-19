<style>
    .zx-footer {
        background-color: rgba(20, 85, 85, 0.94);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 10px 0;
        font-family: 'Figtree', sans-serif;
        color: #FFFFFF;
        clear: both;
        position: relative;
        width: 100%;
        border-top: 1px solid #eee;
    }

    .zx-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 70px;
    }

    .zx-main-grid {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    /* Columna del Logo */
    .zx-logo-col {
        flex: 0 0 130px;
        display: flex;
        justify-content: flex-start;
        padding-top: 10px;
    }

    .zx-circle-img {
        background-color: #b89152;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 40px;
    }

    /* Contenedor de las Secciones */
    .zx-sections-wrapper {
        flex: 1;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

.zx-divider {
        width: 1px;
        background-color: #fedc97;
        height: 90px;
        margin: 0 35px; /* AJUSTE sep. dividers: cambia 15px / 26px / 35px / 45px */
    }


    .zx-footer h4 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 15px;
        padding-bottom: 5px;
        width: 180px;
        color: #FFFFFF;
    }

    .zx-list-item {
        display: flex;
        align-items: center;
        font-size: 13px;
        margin-bottom: 10px;
        text-decoration: none;
        color: #FFFFFF;
    }

.zx-list-item i {
        width: 28px;
        margin-right: 2px;
        height: 28px;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        /* Nuevo: círculo blanco para que resalten */
        background: rgba(255, 255, 255, 0.95);
        color: #FFFFFF;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

.zx-list-item:hover i {
        background: #145555;
        color: #FFFFFF;
    }

    .contacto-item i{
        color: #145555 !important;
        background: rgba(255, 255, 255, 0.1);
    }

    .contacto-item:hover i{
        color: #FFFFFF !important;
        background: rgba(255, 255, 255, 0.1);
    }

    .zx-list-item:hover {
        color: #FFFFFF;
    }

    /* Bloque de Contacto */
    .zx-contact-grid {
        display: grid;
        grid-template-columns: 220px 300px;
        gap: 10px 40px;
    }

    .zx-map-btn {
        background-color: #f8f8f8;
        border: 1px solid #eee;
        border-radius: 25px;
        padding: 10px 25px;
        color: #b89152;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .zx-footer-bottom {
        margin-top: 50px;
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

    @media (max-width: 900px) {
        .zx-sections-wrapper, .zx-contact-section {
            padding-left: 0;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .zx-divider { display: none; }
        .zx-contact-grid { grid-template-columns: 1fr; }
    }
</style>

<footer class="zx-footer">
    <div class="zx-container">
        <div class="zx-main-grid">
            <!-- 1. Logo -->
            <div class="zx-logo-col">
                <div class="zx-circle-img">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <!-- 2. Contenido Superior -->
            <div class="zx-sections-wrapper" style="position:relative; left: 0px;">
                <div class="zx-divider"></div>

                <div style="flex: 1;">
                    <h4 style="position:relative; left: 45px;">Síguenos</h4>

                    <a href="#" class="zx-list-item">
                        <i class="fab fa-facebook-f" style="color:#1877F2;"></i>
                          Equipos Médicos Zarmex
                    </a>
                    <a href="#" class="zx-list-item">
                        <i class="fab fa-instagram" style="color:#E4405F;"></i>
                          Zarmex_oficialmx
                    </a>
                    <a href="#" class="zx-list-item">
                        <i class="fab fa-tiktok" style="color:#000000;"></i>
                          Zarmex_oficial
                    </a>
                </div>

                <div class="zx-divider"></div>

                <div style="flex: 1; text-align: center;">
                    <h4 style="text-align: left; margin: 0 auto 15px;">Ubicación</h4>
                    <i class="fas fa-map-marker-alt" style="color: #b89152; font-size: 30px;"></i>
                    <p style="color: #fedc97; font-size: 12px; margin-top: 10px;">Plaza Neza · Local B03</p>
                </div>

                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps?q=Equipos%20Médicos%20ZARMEX&output=embed"
                        width="100%"
                        height="160"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="zx-divider"></div>
            </div>

            <!-- 3. Contenido Inferior (Contacto) -->
            <div class="zx-contact-section" style="position: relative; left: 25px;">
                <h4>Contacto</h4>
                <div class="zx-contact-grid">
<div class="zx-list-item contacto-item"><i class="fas fa-phone-alt" style="color:#145555;"></i>&nbsp;+52 55 8136 6555</div>
<div class="zx-list-item contacto-item"><i class="fas fa-envelope" style="color:#145555;"></i>&nbsp;zarmex.mexico@gmail.com</div>
<div class="zx-list-item contacto-item"><i class="fas fa-envelope"></i>&nbsp;contacto@zarmex.com</div>
                    <div class="zx-list-item contacto-item"><i class="fas fa-life-ring"></i>&nbsp;soporte.zarmex@gmail.com</div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="zx-footer-bottom">
            <div class="zx-line-gold"></div>
            <span>© 2026 Zarmex. Todos los derechos reservados.</span>
            <div class="zx-line-gold"></div>
        </div>
    </div>
</footer>

