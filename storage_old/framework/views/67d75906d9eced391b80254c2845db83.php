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
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="<?php echo e(asset('css/solicitud.css')); ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script>
            function confirmarEliminar(event) {
                if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    event.preventDefault(); // Evita que el formulario se envíe
                }
            }
        </script>
    </head>
    <body class="bg-dark">
        <div class="container mt-5">
            <h1 class="text-center text-light mb-4">Tus Solicitudes</h1>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-light mb-3">Regresar</a>

            
            <h2 class="text-warning mb-3">Reporte de soporte y quejas</h2>
            <?php if($reportes->count()): ?>
                <div class="list-group mb-4">
                    <?php $__currentLoopData = $reportes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reporte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item list-group-item-action bg-secondary text-light mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Asunto:</strong> <?php echo e($reporte->descripcion); ?> <br>
                                <strong>Estado:</strong> <span class="badge bg-info"><?php echo e($reporte->estado); ?></span> <br>
                                <strong>Tipo de reporte:</strong> <?php echo e($reporte->tipo_reporte); ?> <br>
                                <strong>Fecha:</strong> <?php echo e($reporte->creado_en->format('d/m/Y H:i:s')); ?> <br>
                                <strong>Ultima actualizaciòn:</strong> <?php echo e($reporte->actualizado_en->format('d/m/Y H:i:s')); ?>

                            </div>
                            <form action="<?php echo e(route('reportes.eliminar', $reporte->id_reporte)); ?>" method="POST" onsubmit="confirmarEliminar(event)">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-white">No hay reportes registrados.</p>
            <?php endif; ?>

            
            <h2 class="text-info mb-3">Servicios</h2>
            <?php if($mantenimientos->count()): ?>
                <div class="list-group">
                    <?php $__currentLoopData = $mantenimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mantenimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item list-group-item-action bg-secondary text-light mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Descripción:</strong> <?php echo e($mantenimiento->descripcion); ?> <br>
                                <strong>Estado:</strong> <span class="badge bg-warning"><?php echo e($mantenimiento->status); ?></span> <br>
                                <strong>Fecha:</strong> <?php echo e($mantenimiento->created_at->format('d/m/Y H:i:s')); ?> <br>
                                <strong>Ultima actualizaciòn:</strong> <?php echo e($mantenimiento->updated_at->format('d/m/Y H:i:s')); ?>

                            </div>
                            <form action="<?php echo e(route('mantenimientos.eliminar', $mantenimiento->id)); ?>" method="POST" onsubmit="confirmarEliminar(event)">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-white">No hay mantenimientos registrados.</p>
            <?php endif; ?>
        </div>
        <br>
        <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/solicitudes/usuario.blade.php ENDPATH**/ ?>