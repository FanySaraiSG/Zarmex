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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Administrador
        </h2>
     <?php $__env->endSlot(); ?>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div class="admin-page">
        <div class="admin-shell">
            <h1 class="admin-title">Panel de Administrador</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-users fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Empleados</h3>
                        <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-light mt-2">Gestionar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-tags fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Categorías</h3>
                        <a href="<?php echo e(route('categorias.index')); ?>" class="btn btn-light mt-2">Ver categorías</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-stethoscope fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Equipos Médicos</h3>
                        <a href="<?php echo e(route('productos.index')); ?>" class="btn btn-light mt-2">Administrar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-palette fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Colores</h3>
                        <a href="<?php echo e(route('colors.index')); ?>" class="btn btn-light mt-2">Gestionar Colores</a>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-tools fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Mantenimiento y Reparación</h3>
                        <a href="/mantenimientos" class="btn btn-light mt-2">Gestionar servicios</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-chart-line fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Productos más vendidos</h3>
                        <a href="<?php echo e(route('top-products.index')); ?>" class="btn btn-light mt-2">Gestionar productos</a>
                    </div>
                </div>
                <div class="col">
    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
        <i class="fas fa-star fa-4x icon-accent"></i>
        <h3 class="text-light mt-3">Reseñas</h3>
        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-light mt-2">
            Gestionar Reseñas
        </a>
    </div>
</div>

                <div class="col">
                    <div class="card p-5 bg-custom shadow-lg text-center w-100 admin-card">
                        <i class="fas fa-images fa-4x icon-accent"></i>
                        <h3 class="text-light mt-3">Imágenes Sitio</h3>
                        <a href="<?php echo e(route('imagenes.index')); ?>" class="btn btn-light mt-2">Gestionar Imágenes</a>
                    </div>
                </div>

            </div>
       </div>
    </div>

    <style>
        .admin-page{
            min-height: calc(100vh - 160px);
            padding: 28px 15px;
            background: #f3f5f6;
            position: relative;
            z-index: 50;
        }
        .admin-shell{
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,.12);
        }
        .admin-title{
            text-align: center;
            font-weight: 900;
            color: #234d50;
            margin: 5px 0 18px;
        }

        .bg-custom { background-color: #28666e; border-radius: 15px; border: 0; }
        .text-light { color: #fedc97 !important; }

        .btn.btn-light {
            background-color: #fedc97;
            color: #28666e;
            border: none;
            font-size: 1.05em;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 800;
        }
        .btn.btn-light:hover { background-color: #ffffff; color: #234d50; }

        .admin-card{ transition: transform .2s ease, box-shadow .2s ease; }
        .admin-card:hover{
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(0,0,0,.18);
        }

        .icon-accent{
            color: #fedc97 !important;
            transition: transform 0.2s ease-in-out;
        }
        .admin-card:hover .icon-accent{ transform: scale(1.08); }
    </style>

    <?php if(session('success')): ?>
        <script>alert(<?php echo json_encode(session('success'), 15, 512) ?>);</script>
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
<?php /**PATH C:\xampp\htdocs\zarmex\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>