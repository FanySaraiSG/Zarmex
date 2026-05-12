<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if(auth()->guard('employee')->check()): ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <title>Productos</title>
        <style>
            nav {
                background-color: inherit !important;
            }

            .table {
                background-color: white !important;
            }

            .color-box {
                width: 50px;
                /* Ancho del cuadro de color */
                height: 50px;
                /* Altura del cuadro de color */
                border-radius: 5px;
                /* Bordes redondeados */
                border: 1px solid #ddd;
                /* Borde gris claro */
                display: inline-block;
                /* Asegura que se muestre en línea con otros cuadros */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                /* Sombra para dar profundidad */
            }
        </style>
    </head>

    <body>
        <?php $__env->startSection('content'); ?>
        <div class="container mt-5">
        <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Colores</h1>
            <div class="d-flex justify-content-between mb-3">
                <a class="btn btn-secondary btn-sm" href="<?php echo e(route('admin.dashboard')); ?>">Regresar</a>
                <a class="btn btn-success btn-sm" href="<?php echo e(route('colors.create')); ?>">Añadir Color</a>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID Color</th>
                            <th>Nombre</th>
                            <th>Vista Previa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($color->id_color); ?></td>
                                <td><?php echo e($color->nombre); ?></td>
                                <td>
                                    <div class="color-box" style="background-color: #<?php echo e($color->id_color); ?>;"></div>
                                </td>

                                <td>
                                    <a href="<?php echo e(route('colors.edit', $color->id_color)); ?>"
                                        class="btn btn-primary btn-sm">Editar</a>
                                    <form action="<?php echo e(route('colors.destroy', ltrim($color->id_color, '#'))); ?>" method="post"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar este color?')">Eliminar</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <script>
            alert("<?php echo e(session('success')); ?>");
        </script>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/colors/index.blade.php ENDPATH**/ ?>