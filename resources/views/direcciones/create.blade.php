<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Zarmex') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="antialiased">
    @include('header')
    <main>
        <section class="cardform">
            <div class="form-container">
                <h2>Registrar Dirección</h2>
                <div class="form-group d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{route('direcciones.index')}}">Regresar</a>
                </div>
                <form action="{{ route('direcciones.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="tipo">Tipo de Dirección:</label>
                        <select id="tipo" name="tipo" required>
                            <option value="casa">Casa</option>
                            <option value="trabajo">Trabajo</option>
                            <option value="oficina">Oficina</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pais">País:</label>
                        <select id="pais" name="pais" required>
                            <option value="">Seleccione un país</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select id="estado" name="estado" required>
                            <option value="">Seleccione un estado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad:</label>
                        <select id="ciudad" name="ciudad" required>
                            <option value="">Seleccione una ciudad</option>
                        </select>
                        @error('ciudad')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo_postal">Código Postal:</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" required>
                        @error('codigo_postal')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="calle">Calle:</label>
                        <input type="text" id="calle" name="calle" required>
                    </div>

                    <div class="form-group">
                        <label for="numero_exterior">Número Exterior:</label>
                        <input type="text" id="numero_exterior" name="numero_exterior" required>
                    </div>

                    <div class="form-group">
                        <label for="numero_interior">Número Interior:</label>
                        <input type="text" id="numero_interior" name="numero_interior">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="submit-btn">Guardar Dirección</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    @include('footer')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const paisSelect = document.getElementById("pais");
            const estadoSelect = document.getElementById("estado");
            const ciudadSelect = document.getElementById("ciudad");
            const telefonoInput = document.getElementById("telefono");
            const codigoPostalInput = document.getElementById("codigo_postal");

            const usuarioGeoNames = "coral220422"; // Usuario de GeoNames

            let nombreEstado = "";
            let nombreCiudad = "";

            // Función para cargar estados
            function cargarEstados(paisNombre) {
                estadoSelect.innerHTML = '<option value="">Cargando...</option>';
                ciudadSelect.innerHTML = '<option value="">Selecciona un estado primero</option>';

                fetch(`https://secure.geonames.org/searchJSON?name=${paisNombre}&featureClass=A&username=${usuarioGeoNames}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.geonames && data.geonames.length > 0) {
                            let paisId = data.geonames[0].geonameId;
                            return fetch(`https://secure.geonames.org/childrenJSON?geonameId=${paisId}&username=${usuarioGeoNames}`);
                        } else {
                            throw new Error("País no encontrado en GeoNames");
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        estadoSelect.innerHTML = '<option value="">Seleccionar estado</option>';
                        data.geonames.forEach(estado => {
                            let option = new Option(estado.name, estado.geonameId);
                            estadoSelect.add(option);
                        });
                    })
                    .catch(error => console.error("Error al cargar estados:", error));
            }

            // Función para cargar ciudades
            function cargarCiudades(estadoId) {
                ciudadSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`https://secure.geonames.org/childrenJSON?geonameId=${estadoId}&username=${usuarioGeoNames}`)
                    .then(response => response.json())
                    .then(data => {
                        ciudadSelect.innerHTML = '<option value="">Seleccionar ciudad</option>';
                        data.geonames.forEach(ciudad => {
                            let option = new Option(ciudad.name, ciudad.geonameId);
                            ciudadSelect.add(option);
                        });
                    })
                    .catch(error => console.error("Error al cargar ciudades:", error));
            }

            // Cargar países desde REST Countries
            fetch("https://restcountries.com/v3.1/all")
                .then(response => response.json())
                .then(data => {
                    data.forEach(pais => {
                        let nombrePais = pais.name.common;
                        let lada = pais.idd && pais.idd.root ? `${pais.idd.root}${pais.idd.suffixes ? pais.idd.suffixes[0] : ""}` : "";
                        let option = new Option(`${nombrePais} ${lada}`, nombrePais);
                        option.dataset.lada = lada;
                        paisSelect.add(option);
                    });
                })
                .catch(error => console.error("Error al cargar países:", error));

            // Agregar lada al teléfono y cargar estados al seleccionar un país
            paisSelect.addEventListener("change", function () {
                let selectedOption = this.options[this.selectedIndex];
                let lada = selectedOption.dataset.lada.trim();
                telefonoInput.value = lada ? `${lada} ` : "";

                cargarEstados(this.value);
            });

            // Cargar ciudades y capturar nombre del estado al seleccionar un estado
            estadoSelect.addEventListener("change", function () {
                let estadoId = this.value;
                nombreEstado = this.options[this.selectedIndex].text;
                cargarCiudades(estadoId);
            });

            // Capturar nombre de la ciudad al seleccionar una ciudad
            ciudadSelect.addEventListener("change", function () {
                nombreCiudad = this.options[this.selectedIndex].text;
            });

            // Agregar un evento submit al formulario para guardar los nombres de ciudad y estado
            document.querySelector('form').addEventListener('submit', function () {
                let estadoNombreInput = document.createElement('input');
                estadoNombreInput.type = 'hidden';
                estadoNombreInput.name = 'estado_nombre';
                estadoNombreInput.value = nombreEstado;

                let ciudadNombreInput = document.createElement('input');
                ciudadNombreInput.type = 'hidden';
                ciudadNombreInput.name = 'ciudad_nombre';
                ciudadNombreInput.value = nombreCiudad;

                this.appendChild(estadoNombreInput);
                this.appendChild(ciudadNombreInput);
            });
        });
    </script>
</body>


</html>