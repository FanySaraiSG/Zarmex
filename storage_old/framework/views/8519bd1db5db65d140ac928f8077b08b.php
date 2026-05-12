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

<div class="container mt-4">
    <div class="crud-box">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <a class="btn btn-back" href="<?php echo e(route('admin.dashboard')); ?>">← Regresar</a>
            <a class="btn btn-add" href="<?php echo e(route('productos.create')); ?>">+ Añadir Producto</a>
        </div>

        <h2 class="crud-title">
            <?php echo e($categoriaNombre); ?>

        </h2>

        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
                        <th>Fecha</th>
                        <th>Garantía</th>
                        <th>Manual</th>
                        <th>Ficha Técnica</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($productos->currentPage() - 1) * $productos->perPage() + $loop->iteration); ?></td>

                        <td><?php echo e($producto->id); ?></td>

                        <td style="max-width: 220px;">
                            <?php echo e(Str::limit($producto->descripcion, 80)); ?>

                        </td>

                        <td>$<?php echo e(number_format($producto->precio, 2)); ?></td>

                        <td><?php echo e($producto->stock); ?></td>

                        <td>
                            <?php echo e($producto->categoria->nombre ?? 'Sin categoría'); ?>

                        </td>

                        <td>
                            <?php if($producto->imagen_url): ?>
                                <img src="<?php echo e(asset($producto->imagen_url)); ?>"
                                     width="56"
                                     style="border-radius:10px; border:1px solid #c7cdcf; background:#fff; padding:3px;">
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php echo e($producto->created_at ? $producto->created_at->format('Y-m-d H:i') : '—'); ?>

                        </td>

                        <td>
                            <?php if($producto->doc1_url): ?>
                                <a class="btn btn-doc btn-sm"
                                   href="<?php echo e(asset($producto->doc1_url)); ?>"
                                   target="_blank">
                                   Ver
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($producto->doc2_url): ?>
                                <a class="btn btn-doc btn-sm"
                                   href="<?php echo e(asset($producto->doc2_url)); ?>"
                                   target="_blank">
                                   Ver
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($producto->doc3_url): ?>
                                <a class="btn btn-doc btn-sm"
                                   href="<?php echo e(asset($producto->doc3_url)); ?>"
                                   target="_blank">
                                   Ver
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="acciones-btns">
                                <a href="<?php echo e(route('productos.edit', $producto->id)); ?>"
                                   class="btn btn-edit btn-sm">
                                   Editar
                                </a>

                                <form action="<?php echo e(route('productos.destroy', $producto->id)); ?>"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="btn btn-delete btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <?php echo e($productos->links()); ?>

        </div>

    </div>
</div>

<style>
:root{
    --zx-dark: #234d50;
    --zx-mid: #3f6f76;
    --zx-soft: #d9d9d9;
    --zx-border: #c7cdcf;
    --zx-white: #ffffff;
    --zx-blue: #3d6ee8;
    --zx-red: #d84c4c;
}

body{
    background: #0f1720;
}

nav{
    background-color: inherit !important;
}

header,
footer,
.whatsapp,
#whatsapp,
.btn-whatsapp{
    display: none !important;
}

.crud-box{
    background: var(--zx-soft);
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,.12);
    margin-top: 20px;
}

.crud-title{
    text-align: center;
    color: var(--zx-dark);
    font-weight: 800;
    margin-bottom: 22px;
}

.table{
    background-color: white !important;
    overflow: hidden;
    border-radius: 14px;
    margin-bottom: 0;
}

.table thead th{
    background: var(--zx-mid) !important;
    color: white !important;
    border-color: var(--zx-mid) !important;
    text-align: center;
    vertical-align: middle;
}

.table tbody td{
    vertical-align: middle;
    text-align: center;
    border-color: var(--zx-border) !important;
    background: #efefef;
}

.table-responsive{
    border-radius: 14px;
    overflow: hidden;
}

.btn-back{
    background: #2f555b;
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 12px 22px;
    font-weight: 700;
    font-size: 16px;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0,0,0,.10);
    transition: .2s ease;
}

.btn-back:hover{
    background: #24464b;
    color: #fff;
    transform: translateY(-1px);
}

.btn-add{
    background: #d5d9da;
    color: var(--zx-dark);
    border: 1px solid #b5bbbd;
    border-radius: 16px;
    padding: 12px 22px;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,.08);
    transition: .2s ease;
    text-decoration: none;
}

.btn-add:hover{
    background: #c8cdcf;
    color: var(--zx-dark);
    transform: translateY(-1px);
}

.btn-edit{
    background: var(--zx-blue);
    color: white;
    border: none;
    border-radius: 14px;
    padding: 10px 18px;
    font-weight: 700;
    box-shadow: 0 4px 10px rgba(0,0,0,.10);
    transition: .2s ease;
}

.btn-edit:hover{
    background: #2f5fd3;
    color: white;
    transform: translateY(-1px);
}

.btn-delete{
    background: var(--zx-red);
    color: white;
    border: none;
    border-radius: 14px;
    padding: 10px 18px;
    font-weight: 700;
    box-shadow: 0 4px 10px rgba(0,0,0,.10);
    transition: .2s ease;
}

.btn-delete:hover{
    background: #bf3f3f;
    color: white;
    transform: translateY(-1px);
}

.btn-doc{
    background: var(--zx-dark);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 8px 14px;
    font-weight: 700;
}

.btn-doc:hover{
    background: #1c3f42;
    color: #fff;
}

.acciones-btns{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
    flex-wrap: wrap;
}

.acciones-btns form{
    margin:0;
}

td, th{
    vertical-align: middle !important;
}
</style>

<?php if(session('success')): ?>
<script>
    alert("<?php echo e(session('success')); ?>");
</script>
<?php endif; ?>

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
<?php endif; ?><?php /**PATH C:\Users\Dhust\Desktop\AlaEstadia\Zarmex 2\Zarmex original\zarmex\resources\views/productos/index.blade.php ENDPATH**/ ?>