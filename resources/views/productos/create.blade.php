<x-app-layout>
    @auth('employee')
        @if(Auth::user()->rol === 'admin')

            <section class="container mt-5">
                <div class="form-container">
                    <h2>Añadir Producto</h2>

                    <div class="form-group d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="{{ route('productos.index') }}">Regresar</a>
                    </div>

                    {{-- ERRORES --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Selección de Categoría -->
                        <div class="form-group">
                            <label for="categoria_id">Categoría:</label>
                            <select id="categoria_id" name="categoria_id" required onchange="generarIdProducto()">
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- ID de la Categoría (Automático) -->
                        <div class="form-group">
                            <label for="id_categoria">ID de Categoría Seleccionado:</label>
                            <input type="text" id="id_categoria" name="id_categoria" readonly>
                        </div>

                        <!-- Identificador Único -->
                        <div class="form-group">
                            <label for="identificador">Identificador Único del Producto:</label>
                            <input type="text" id="identificador" name="identificador" required
                                   oninput="generarIdProducto()" placeholder="Ej: 001">
                        </div>

                        <!-- ID del Producto (Automático) -->
                        <div class="form-group">
                            <label for="id">ID del Producto (Generado Automáticamente):</label>
                            <input type="text" id="id" name="id" readonly required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        OPCIONAL
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" step="0.01" id="precio" name="precio" required>
                        </div>}

                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input type="number" id="stock" name="stock" required>
                        </div>

                        <div class="form-group">
                            <label for="imagen_url">Imagen:</label>
                            <input type="file" id="imagen_url" name="imagen_url" style="color:black;">
                        </div>

                        <h3 style="margin-top:15px;">Documentos del Producto</h3>

                        <div class="form-group">
                            <label for="doc1">Garantía(PDF/Word/Excel):</label>
                            <input type="file" id="doc1" name="doc1" accept=".pdf,.doc,.docx,.xls,.xlsx" style="color:black;">
                        </div>

                        <div class="form-group">
                            <label for="doc2">Manual(PDF/Word/Excel):</label>
                            <input type="file" id="doc2" name="doc2" accept=".pdf,.doc,.docx,.xls,.xlsx" style="color:black;">
                        </div>

                        <div class="form-group">
                            <label for="doc3">Ficha Técnica(PDF/Word/Excel):</label>
                            <input type="file" id="doc3" name="doc3" accept=".pdf,.doc,.docx,.xls,.xlsx" style="color:black;">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="submit-btn">Crear Producto</button>
                        </div>
                    </form>
                </div>
            </section>

            <script>
                function generarIdProducto() {
                    var select = document.getElementById("categoria_id");
                    var idCategoria = select.options[select.selectedIndex].value;
                    document.getElementById("id_categoria").value = idCategoria;

                    var identificador = document.getElementById("identificador").value;

                    if (idCategoria && identificador) {
                        document.getElementById("id").value = idCategoria + "-" + identificador;
                    } else {
                        document.getElementById("id").value = "";
                    }
                }

                document.addEventListener("DOMContentLoaded", function () {
                    const form = document.querySelector("form");
                    form.addEventListener("submit", function (e) {
                        const idField = document.getElementById("id");
                        if (!idField.value) {
                            e.preventDefault();
                            alert("Por favor genera el ID del producto antes de continuar.");
                        }
                    });
                });
            </script>

            {{-- ESTILOS SOLO PARA ESTA VISTA (AL FINAL) --}}
            <style>
                :root{
                    --z-primary:#234d50;
                    --z-primary-2:#2e5f66;
                    --z-bg:#f4f6f8;
                    --z-card:#ffffff;
                    --z-border:#d9dee3;
                    --z-text:#111;
                    --z-radius:12px;
                }

                body{
                    background: var(--z-bg);
                    color: var(--z-text);
                }

                .form-container{
                    width: 100%;
                    max-width: 450px;
                    margin: 0 auto;
                    background: var(--z-card);
                    border: 1px solid var(--z-border);
                    border-radius: var(--z-radius);
                    padding: 24px 24px 14px;
                    box-shadow: 0 10px 30px rgba(0,0,0,.06);
                }

                .form-container h2{
                    text-align: center;
                    font-weight: 900;
                    letter-spacing: .5px;
                    margin-bottom: 18px;
                    color: #000;
                    text-transform: uppercase;
                }

                .form-container h3{
                    margin-top: 18px;
                    margin-bottom: 10px;
                    font-weight: 800;
                    color: #000;
                    font-size: 18px;
                }

                .form-group{
                    margin-bottom: 12px;
                }

                .form-group label{
                    display: block;
                    font-weight: 700;
                    font-size: 13px;
                    margin-bottom: 6px;
                    color: #000;
                }

                .form-container input[type="text"],
                .form-container input[type="number"],
                .form-container input[type="datetime-local"],
                .form-container select,
                .form-container textarea,
                .form-container input[type="file"]{
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid var(--z-border);
                    border-radius: 10px;
                    background: #fff;
                    color: #111;
                    outline: none;
                    transition: border-color .15s ease, box-shadow .15s ease;
                    font-size: 15px;
                }

                .form-container textarea{
                    min-height: 95px;
                    resize: vertical;
                }

                .form-container input:focus,
                .form-container select:focus,
                .form-container textarea:focus{
                    border-color: rgba(35,77,80,.75);
                    box-shadow: 0 0 0 4px rgba(35,77,80,.15);
                }

                .form-container input[readonly]{
                    background: #f8fafc;
                }

                .submit-btn{
                    width: 100%;
                    max-width: 320px;
                    margin: 10px auto 0;
                    display: block;
                    border: none;
                    border-radius: 10px;
                    background: var(--z-primary);
                    color: #fff;
                    font-weight: 900;
                    padding: 12px 16px;
                    cursor: pointer;
                    transition: transform .08s ease, background .15s ease;
                    letter-spacing: .3px;
                }

                .submit-btn:hover{
                    background: var(--z-primary-2);
                }

                .submit-btn:active{
                    transform: scale(.99);
                }

                .medidas-row{
                    display:flex;
                    gap:12px;
                }

                .medida-col{
                    flex:1;
                }

                .btn.btn-secondary.btn-sm{
                    border-radius: 10px;
                }

                @media (max-width: 768px){
                    .form-container{
                        padding: 18px;
                    }
                    .medidas-row{
                        flex-direction: column;
                    }
                }
            </style>

        @else
            <div class="container mt-5">
                <div class="alert alert-danger text-center">
                    <h4>Access Denied</h4>
                    <p>You do not have permission to view this page.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        @endif
    @endauth
</x-app-layout>
