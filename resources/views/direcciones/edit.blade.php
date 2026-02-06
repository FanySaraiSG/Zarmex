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
                <h2>Editar Dirección</h2>
                <div class="form-group d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="{{route('direcciones.index')}}">Regresar</a>
                </div>
                <form action="{{ route('direcciones.update', $direccion->id_direccion) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="tipo">Tipo de Dirección:</label>
                        <select id="tipo" name="tipo" required>
                            <option value="casa" {{ $direccion->tipo == 'casa' ? 'selected' : '' }}>Casa</option>
                            <option value="trabajo" {{ $direccion->tipo == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                            <option value="oficina" {{ $direccion->tipo == 'oficina' ? 'selected' : '' }}>Oficina</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pais">País:</label>
                        <select id="pais" name="pais" required>
                            <option value="{{ $direccion->pais }}" selected>{{ $direccion->pais }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select id="estado" name="estado" required>
                            <option value="{{ $direccion->estado }}" selected>{{ $direccion->estado_nombre }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad:</label>
                        <select id="ciudad" name="ciudad" required>
                            <option value="{{ $direccion->ciudad }}" selected>{{ $direccion->ciudad_nombre }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="codigo_postal">Código Postal:</label>
                        <input type="text" id="codigo_postal" name="codigo_postal"
                            value="{{ $direccion->codigo_postal }}" required>
                    </div>

                    <div class="form-group">
                        <label for="calle">Calle:</label>
                        <input type="text" id="calle" name="calle" value="{{ $direccion->calle }}" required>
                    </div>

                    <div class="form-group">
                        <label for="numero_exterior">Número Exterior:</label>
                        <input type="text" id="numero_exterior" name="numero_exterior"
                            value="{{ $direccion->numero_exterior }}" required>
                    </div>

                    <div class="form-group">
                        <label for="numero_interior">Número Interior:</label>
                        <input type="text" id="numero_interior" name="numero_interior"
                            value="{{ $direccion->numero_interior }}">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="{{ $direccion->telefono }}" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="submit-btn">Actualizar Dirección</button>
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
            const paisActual = "{{ $direccion->pais }}";
            const estadoActual = "{{ $direccion->estado }}";
            const ciudadActual = "{{ $direccion->ciudad }}";

            let nombreEstado = "{{ $direccion->estado_nombre }}"; // Inicializar con el nombre actual
            let nombreCiudad = "{{ $direccion->ciudad_nombre }}"; // Inicializar con el nombre actual

            // Cargar países desde REST Countries
            fetch("https://restcountries.com/v3.1/all")
                .then(response => response.json())
                .then(data => {
                    data.forEach(pais => {
                        let nombrePais = pais.name.common;
                        let lada = pais.idd && pais.idd.root ? `${pais.idd.root}${pais.idd.suffixes ? pais.idd.suffixes[0] : ""}` : "";
                        let option = new Option(`${nombrePais} ${lada}`, pais.cca2); // Usar el código de país como valor
                        option.dataset.lada = lada;
                        paisSelect.add(option);
                    });

                    paisSelect.value = paisActual; // Seleccionar el país actual
                    cargarEstados(paisActual); // Cargar estados para el país seleccionado
                })
                .catch(error => console.error("Error al cargar países:", error));

            // Cargar estados al cambiar el país
            paisSelect.addEventListener("change", function () {
                cargarEstados(this.value);
            });

            function cargarEstados(paisNombre) {
                estadoSelect.innerHTML = '<option value="">Cargando...</option>';
                ciudadSelect.innerHTML = '<option value="">Selecciona un estado primero</option>';

                fetch(`https://secure.geonames.org/searchJSON?name=${paisNombre}&featureClass=A&username=${usuarioGeoNames}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.geonames.length > 0) {
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

                        estadoSelect.value = estadoActual; // Seleccionar el estado actual
                        cargarCiudades(estadoActual); // Cargar ciudades para el estado seleccionado
                    })
                    .catch(error => console.error("Error al cargar estados:", error));
            }

            // Cargar ciudades al cambiar el estado
            estadoSelect.addEventListener("change", function () {
                cargarCiudades(this.value);
                nombreEstado = this.options[this.selectedIndex].text; // Capturar el nombre del estado
            });

            function cargarCiudades(estadoNombre) {
                ciudadSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`https://secure.geonames.org/childrenJSON?geonameId=${estadoNombre}&username=${usuarioGeoNames}`)
                    .then(response => response.json())
                    .then(data => {
                        ciudadSelect.innerHTML = '<option value="">Seleccionar ciudad</option>';
                        data.geonames.forEach(ciudad => {
                            let option = new Option(ciudad.name, ciudad.geonameId);
                            ciudadSelect.add(option);
                        });

                        ciudadSelect.value = ciudadActual; // Seleccionar la ciudad actual
                    })
                    .catch(error => console.error("Error al cargar ciudades:", error));
            }

            ciudadSelect.addEventListener("change", function () {
                nombreCiudad = this.options[this.selectedIndex].text; // Capturar el nombre de la ciudad
            });

            // Agregar un evento submit al formulario para guardar los nombres de ciudad y estado
            document.querySelector('form').addEventListener('submit', function () {
                let estadoNombreInput = document.createElement('input');
                estadoNombreInput.type = 'hidden';
                estadoNombreInput.name = 'estado_nombre'; // Cambiado a 'estado_nombre'
                estadoNombreInput.value = nombreEstado;

                let ciudadNombreInput = document.createElement('input');
                ciudadNombreInput.type = 'hidden';
                ciudadNombreInput.name = 'ciudad_nombre'; // Cambiado a 'ciudad_nombre'
                ciudadNombreInput.value = nombreCiudad;

                this.appendChild(estadoNombreInput);
                this.appendChild(ciudadNombreInput);

            });
        });
    </script>
</body>

</html>