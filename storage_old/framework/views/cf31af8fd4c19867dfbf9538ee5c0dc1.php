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
            <title>Imágenes del Producto</title>
            <style>
                nav { background-color: inherit !important; }
                .table { background-color: white !important; }
            </style>
        </head>

        <body>
            <div class="container mt-5">
                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="<?php echo e(route('productos.edit', $producto->id)); ?>">Regresar</a>
                    <a href="<?php echo e(route('productos.imagenes.create', $producto->id)); ?>" class="btn btn-success btn-sm">
                        Añadir Imagen
                    </a>
                </div>

                <h2 class="mb-4" style="color: white; text-align: center;">
                    Imágenes de <?php echo e($producto->nombre); ?>

                </h2>

                <!-- Tabla de Imágenes -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>ID de Imagen</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>

                                    
                                    <td><?php echo e($imagen->img_id); ?></td>

                                    <td>
                                        <img src="<?php echo e(asset($imagen->ruta)); ?>?v=<?php echo e(time()); ?>"
                                             alt="Imagen <?php echo e($producto->nombre); ?>"
                                             width="50">
                                    </td>

                                    <td>
                                        
                                        <a href="<?php echo e(route('productos.imagenes.edit', $imagen->img_id)); ?>"
                                           class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <form action="<?php echo e(route('productos.imagenes.destroy', $imagen->img_id)); ?>"
                                              method="post" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar esta imagen?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($imagenes->count() === 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay imágenes extra para este producto.</td>
                                </tr>
                            <?php endif; ?>
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
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\zarmex\resources\views/productos/imagen/index.blade.php ENDPATH**/ ?>