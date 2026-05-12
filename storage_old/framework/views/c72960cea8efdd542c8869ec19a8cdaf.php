

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #2F5F63; min-height: 100vh;">
    <div class="container bg-white p-4 rounded shadow">

    <h2 class="mb-4 fw-bold text-center titulo-reseñas">Gestión de Reseñas</h2>

    <?php if(session('ok')): ?>
        <div class="alert alert-success">
            <?php echo e(session('ok')); ?>

        </div>
    <?php endif; ?>

    
   <div class="mb-3">
    <a href="<?php echo e(route('admin.dashboard')); ?>" 
   class="btn btn-regresar">
    <i class="fas fa-arrow-left me-2"></i> Volver al Panel
</a>
</div>
    <div class="card mb-5">
        <div class="card-header encabezado-azul">
            <strong>Reseñas Pendientes</strong>
        </div>

        <div class="card-body">
            <?php if($pendientes->isEmpty()): ?>
                <p>No hay reseñas pendientes.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Calificación</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($r->id); ?></td>
                                    <td><?php echo e($r->producto_id); ?></td>
                                    <td><?php echo e($r->guest_nombre ?? 'Anónimo'); ?></td>
                                    <td><?php echo e($r->guest_email ?? '-'); ?></td>
                                    <td><?php echo e($r->calificacion); ?>/5</td>
                                    <td><?php echo e($r->descripcion); ?></td>
                                    <td><?php echo e($r->created_at); ?></td>
                                    <td class="d-flex gap-2">

                                        
                                        <form method="POST" action="<?php echo e(route('admin.reviews.estado', $r->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="estatus" value="activo">
                                            <button class="btn btn-success btn-sm">
                                                Aprobar
                                            </button>
                                        </form>

                                        
                                        <form method="POST" action="<?php echo e(route('admin.reviews.destroy', $r->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Eliminar reseña?')">
                                                Eliminar
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>


    
    <div class="card">
        <div class="card-header encabezado-azul">
            <strong>Reseñas Activas</strong>
        </div>

        <div class="card-body">
            <?php if($activos->isEmpty()): ?>
                <p>No hay reseñas activas.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Calificación</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $activos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($r->id); ?></td>
                                    <td><?php echo e($r->producto_id); ?></td>
                                    <td><?php echo e($r->guest_nombre ?? 'Anónimo'); ?></td>
                                    <td><?php echo e($r->guest_email ?? '-'); ?></td>
                                    <td><?php echo e($r->calificacion); ?>/5</td>
                                    <td><?php echo e($r->descripcion); ?></td>
                                    <td><?php echo e($r->created_at); ?></td>
                                    <td class="d-flex gap-2">

                                        
                                        <form method="POST" action="<?php echo e(route('admin.reviews.estado', $r->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="estatus" value="pendiente">
                                            <button class="btn btn-secondary btn-sm">
                                                Desactivar
                                            </button>
                                        </form>

                                        
                                        <form method="POST" action="<?php echo e(route('admin.reviews.destroy', $r->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Eliminar reseña?')">
                                                Eliminar
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>
<style>
.titulo-reseñas{
    font-size: 2rem;
    font-weight: 800;
    color: #1f3f42;
}
.btn-regresar{
    background-color: #2F5F63;
    background-color: #2F5F63;

    font-weight: 600;
    border: none;
}

.btn-regresar:hover{
    background-color: #244b4f;
}.encabezado-azul{
    background-color: #2F5F63 !important;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
}
</style>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>