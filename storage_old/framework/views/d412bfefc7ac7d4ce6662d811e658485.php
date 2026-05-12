<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarmex</title>

    <!-- CSS ORIGINAL -->
    <link rel="stylesheet" href="<?php echo e(asset('css/formularios.css')); ?>">

    <!-- CSS SOLO PARA FORMULARIOS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/formularios-pro.css')); ?>">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<!-- CLAVE: SOLO AQUÍ SE ACTIVA EL DEGRADADO -->
<body class="form-pro">

<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<main>
    <section class="cardform">
        <div class="form-container">

            <h2>MANTENIMIENTO</h2>

            <!-- IMPORTANTE: action correcto -->
            <form action="/submit_mantenimiento" method="POST">
                <?php echo csrf_field(); ?>

                <!-- NOMBRE -->
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <?php if(auth()->guard()->check()): ?>
                        <input type="text" id="nombre" name="nombre" value="<?php echo e(auth()->user()->name); ?>" required>
                    <?php else: ?>
                        <input type="text" id="nombre" name="nombre" required>
                    <?php endif; ?>
                </div>

                <!-- OCUPACIÓN -->
                <div class="form-group">
                    <label for="ocupacion">Ocupación</label>
                    <input type="text" id="ocupacion" name="ocupacion" required>
                </div>

                <!-- CATEGORÍA -->
                <div class="form-group">
                    <label for="tipo_maquina">Tipo de máquina</label>
                    <select id="tipo_maquina" name="tipo_maquina" required>
                        <option value="" disabled selected>Seleccione una categoría</option>
                        <?php $__currentLoopData = App\Models\Categoria::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categoria->id_categoria); ?>"><?php echo e($categoria->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- PRODUCTO -->
                <div class="form-group">
                    <label for="codigo_equipo">Código del equipo</label>
                    <select id="codigo_equipo" name="codigo_equipo" required>
                        <option value="" disabled selected>Seleccione un producto</option>
                        <?php $__currentLoopData = App\Models\Producto::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($producto->id); ?>" data-categoria="<?php echo e($producto->categoria_id); ?>">
                                <?php echo e($producto->id); ?> - <?php echo e($producto->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- SCRIPT FILTRO -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const categoriaSelect = document.getElementById('tipo_maquina');
                        const productoSelect = document.getElementById('codigo_equipo');
                        const productosOriginales = Array.from(productoSelect.options);

                        categoriaSelect.addEventListener('change', function () {
                            const categoriaId = this.value;

                            productoSelect.innerHTML = '<option value="" disabled selected>Seleccione un producto</option>';

                            productosOriginales.forEach(option => {
                                if (option.dataset.categoria === categoriaId) {
                                    productoSelect.appendChild(option.cloneNode(true));
                                }
                            });
                        });
                    });
                </script>

                <!-- DESCRIPCIÓN -->
                <div class="form-group">
                    <label for="descripcion">Descripción del problema</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                </div>

                <!-- DIRECCIÓN -->
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" required>
                </div>

                <!-- ESTADO -->
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado" required>
                </div>

                <!-- CP -->
                <div class="form-group">
                    <label for="codigo_postal">Código postal</label>
                    <input type="text" id="codigo_postal" name="codigo_postal" required>
                </div>

                <!-- CORREO -->
                <div class="form-group">
                    <label for="correo_electronico">Correo electrónico</label>
                    <?php if(auth()->guard()->check()): ?>
                        <input type="email" id="correo_electronico" name="correo_electronico"
                               value="<?php echo e(auth()->user()->email); ?>" required>
                    <?php else: ?>
                        <input type="email" id="correo_electronico" name="correo_electronico"
                               placeholder="Inicia sesión para llenar automáticamente" required>
                    <?php endif; ?>
                </div>

                <!-- TEL -->
                <div class="form-group">
                    <label for="numero_celular">Número de celular</label>
                    <input type="tel" id="numero_celular" name="numero_celular" required>
                </div>

                <!-- BOTÓN -->
                <div class="form-group">
                    <button type="submit" class="submit-btn">Enviar</button>
                </div>

            </form>

        </div>
    </section>
</main>

<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/mantenimiento.blade.php ENDPATH**/ ?>