<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
</head>
<body>

@auth('employee')
@if(auth('employee')->user()->rol === 'admin')

<div class="edit-container">

    <div class="edit-card">

        <h2 class="edit-title">EDITAR PRODUCTO</h2>

        <form action="{{ route('productos.update', $producto->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="field">
                <label>ID:</label>
                <input type="text" name="id" class="form-control" value="{{ $producto->id }}">
            </div>

            <div class="field">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
            </div>

            <div class="field">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto->precio }}">
            </div>

            <div class="field">
                <label>Stock:</label>
                <input type="number" name="stock" class="form-control" value="{{ $producto->stock }}">
            </div>

            <div class="field">
                <label>Categoría:</label>
                <select name="categoria_id" class="form-select">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}"
                            {{ $producto->categoria_id == $categoria->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Imagen Principal Actual:</label>
                @if($producto->imagen_url)
                    <div class="current-img">
                        <img src="{{ asset($producto->imagen_url) }}?v={{ time() }}" style="max-width:140px;border-radius:12px;">
                    </div>
                @endif
            </div>

            {{-- (Opcional) cambiar imagen principal --}}
            <div class="field">
                <label>Cambiar imagen principal (opcional):</label>
                <input type="file" name="imagen_url" class="form-control" accept="image/*">
            </div>

            {{--  SUBIR MUCHAS IMÁGENES EXTRA --}}
            <div class="field">
                <label>Imagen Extra:</label>
                <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                <small style="opacity:.7;">Esta imágen se agregan al carrusel del producto.</small>
            </div>

            {{-- (Opcional) mostrar extras ya guardadas --}}
            @if(isset($imagenesExtra) && $imagenesExtra->count())
                <div class="field">
                    <label>Imágenes extra guardadas:</label>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        @foreach($imagenesExtra as $img)
                            <img src="{{ asset($img->ruta) }}?v={{ time() }}"
                                 style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:1px solid #ddd;">
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- DOCUMENTOS -->
            <!-- DOCUMENTOS -->
<div class="docs-box">
    <h6>Documentos del producto</h6>

    <div class="mb-3">
        <label>Garantía</label>

        @if($producto->doc1_url)
            <div class="mb-2">
                <a href="{{ asset($producto->doc1_url) }}" target="_blank">Ver documento actual</a>
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="eliminar_doc1" value="1" id="eliminar_doc1">
                <label class="form-check-label" for="eliminar_doc1">
                    Eliminar garantía actual
                </label>
            </div>
        @endif

        <input type="file" name="doc1" class="form-control">
    </div>

    <div class="mb-3">
        <label>Manual</label>

        @if($producto->doc2_url)
            <div class="mb-2">
                <a href="{{ asset($producto->doc2_url) }}" target="_blank">Ver documento actual</a>
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="eliminar_doc2" value="1" id="eliminar_doc2">
                <label class="form-check-label" for="eliminar_doc2">
                    Eliminar manual actual
                </label>
            </div>
        @endif

        <input type="file" name="doc2" class="form-control">
    </div>

    <div class="mb-3">
        <label>Ficha Técnica</label>

        @if($producto->doc3_url)
            <div class="mb-2">
                <a href="{{ asset($producto->doc3_url) }}" target="_blank">Ver documento actual</a>
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="eliminar_doc3" value="1" id="eliminar_doc3">
                <label class="form-check-label" for="eliminar_doc3">
                    Eliminar ficha técnica actual
                </label>
            </div>
        @endif

        <input type="file" name="doc3" class="form-control">
    </div>
</div>

            <!-- BOTONES -->
            <div class="button-group">

                <a href="{{ route('productos.imagenes.show', $producto->id) }}"
                   class="btn btn-main btn-small">
                    Mostrar Imágenes
                </a>

                <button type="submit" class="btn btn-main btn-small">
                    Actualizar Producto
                </button>

                <a href="{{ route('productos.index') }}"
                   class="btn btn-grey btn-small">
                    Regresar
                </a>

            </div>

        </form>

    </div>

</div>

@endif
@endauth

</body>
</html>
