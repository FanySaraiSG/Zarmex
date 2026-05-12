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
    </head>
    <br>
    <h1 class="text-2xl font-bold" style="color: white; text-align: center;">Soporte</h1>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">

            
            <div class="col">
                <div class="card p-5 bg-custom shadow-lg text-center w-100">
                    <i class="fas fa-headset fa-4x text-info"></i>
                    <h3 class="text-light mt-3">Soporte y Quejas</h3>
                    <a href="<?php echo e(route('reportes.index')); ?>" class="btn btn-light mt-2">Atender</a>
                </div>
            </div>

    <style>
        .bg-custom {
            background-color: #28666e;
            border-radius: 15px;
        }

        .text-light {
            color: #fedc97 !important;
        }

        .btn-light {
            background-color: #fedc97;
            color: #28666e;
            border: none;
            font-size: 1.2em;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-light:hover {
            background-color: #ffffff;
            color: #234d50;
        }

        .card i {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover i {
            transform: scale(1.1);
        }
    </style>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/dashboard/soporte.blade.php ENDPATH**/ ?>