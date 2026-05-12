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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Top Productos</title>

<style>
:root{
    --zx-dark: #234d50;
    --zx-mid: #3f6f76;
    --zx-soft: #d9d9d9;
    --zx-border: #c7cdcf;
    --zx-white: #ffffff;
    --zx-blue: #3d6ee8;
}

/* fondo */
body{
    background: #0f1720;
}

/* contenedor */
.crud-box{
    background: var(--zx-soft);
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,.12);
}

/* título */
.crud-title{
    text-align: center;
    color: var(--zx-dark);
    font-weight: 800;
    margin-bottom: 20px;
}

/* tabla */
.table{
    background: white;
    border-radius: 14px;
    overflow: hidden;
}

.table thead th{
    background: var(--zx-mid);
    color: white;
    text-align: center;
}

.table tbody td{
    text-align: center;
    background: #efefef;
}

/* botón */
.btn-back{
    background: #2f555b;
    color: white;
    border-radius: 16px;
    padding: 10px 20px;
    font-weight: 700;
    border: none;
}

.btn-back:hover{
    background: #24464b;
}

/* select bonito */
.select-product{
    border: none;
    outline: none;
    border-radius: 20px;
    padding: 8px 14px;
    font-weight: 600;
    cursor: pointer;
    background: #e0e0e0;
}

/* hover */
.select-product:hover{
    background: #d4d4d4;
}

header, footer, .whatsapp, #whatsapp{
    display:none !important;
}
</style>
</head>

<body>

<div class="container mt-4">
    <div class="crud-box">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a class="btn btn-back" href="<?php echo e(route('admin.dashboard')); ?>">
                ← Regresar
            </a>
        </div>

        <h2 class="crud-title">Top 5 Productos Más Vendidos</h2>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>

                        <td>
                            <select class="select-product auto-submit"
                                data-id="<?php echo e($topProduct->id); ?>">

                                <option value="">Ninguno</option>

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"
                                    <?php echo e($topProduct->product_id == $product->id ? 'selected' : ''); ?>>
                                    <?php echo e($product->id); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.auto-submit').forEach(select => {

        select.addEventListener('change', function() {

            let productId = this.value;
            let topProductId = this.dataset.id;

            fetch(`/employees/top-products/${topProductId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
            })
            .catch(err => {
                console.error(err);
                alert('Error al actualizar');
            });

        });

    });
});
</script>

</body>
</html>
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
<?php endif; ?><?php /**PATH C:\Users\Dhust\Desktop\AlaEstadia\Zarmex 2\Zarmex original\zarmex\resources\views/top_products/index.blade.php ENDPATH**/ ?>