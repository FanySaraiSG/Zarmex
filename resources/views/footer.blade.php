<style>
    .zx-footer {
        background-color: #639075;
        padding: 10px 0 10px 0;
        font-family: 'Figtree', sans-serif;
        color: #555;
        clear: both; /* Evita que elementos flotantes lo empujen hacia arriba */
        position: relative; /* Asegura que no sea absolute ni fixed */
        width: 100%;
        border-top: 1px solid #eee;
    }

    .zx-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 70px;
    }

    /* Estructura Principal */
    .zx-main-grid {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    /* Columna del Logo (La dejamos fija para que no mueva lo demás) */
    .zx-logo-col {
        flex: 0 0 130px; /* Espacio reservado para el círculo */
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

    /* Contenedor de las Secciones (Síguenos, Ubicación, Mapa) */
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
        margin: 0 15px;
    }

    .zx-footer h4 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 15px;
        padding-bottom: 5px;
        width: 180px; /* Línea dorada como en la imagen */
    }

    .zx-list-item {
        display: flex;
        align-items: center;
        font-size: 13px;
        margin-bottom: 10px;
        text-decoration: none;
        color: #555;
    }

    .zx-list-item i {
        color: #715528;
        width: 25px;
        font-size: 16px;
    }

    /* Bloque de Contacto (Alineado debajo de Síguenos) */
   

    .zx-contact-grid {
        display: grid;
        grid-template-columns: 220px 300px; /* Dos columnas para los datos */
        gap: 10px 40px;
    }

    /* Botón Mapa */
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

    /* Copyright */
    .zx-footer-bottom {
        margin-top: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        font-size: 11px;
        color: #999;
    }

    .zx-line-gold {
        height: 1px;
        background-color: #fedc97;
        flex: 0 0 150px;
    }

    @media (max-width: 900px) {
        .zx-sections-wrapper, .zx-contact-section { padding-left: 0; flex-direction: column; align-items: center; text-align: center; }
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
            <div class="zx-sections-wrapper">
                <div class="zx-divider"></div>
                
                <div style="flex: 1;">
                    <h4>Síguenos</h4>
                    <a href="#" class="zx-list-item"><i class="fab fa-facebook-f"></i> Equipos Médicos Zarmex</a>
                    <a href="#" class="zx-list-item"><i class="fab fa-instagram"></i> Zarmex_oficialmx</a>
                    <a href="#" class="zx-list-item"><i class="fab fa-tiktok"></i> Zarmex_oficial</a>
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
            <div class="zx-contact-section">
                <h4>Contacto</h4>
                <div class="zx-contact-grid">
                    <div class="zx-list-item"><i class="fas fa-phone-alt"></i> +52 55 8136 6555</div>
                    <div class="zx-list-item"><i class="fas fa-envelope"></i> zarmex.mexico@gmail.com</div>
                    <div class="zx-list-item"><i class="fas fa-envelope"></i> contacto@zarmex.com</div>
                    <div class="zx-list-item"><i class="fas fa-life-ring"></i> soporte.zarmex@gmail.com</div>
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