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
            <title>Mantenimientos</title>

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

                .btn-filter{
                    background: #4b6fe8;
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 11px 22px;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,.10);
    transition: .2s ease;
                }

                .btn-filter:hover{
                   background: #3d60d6;
    color: #fff;
    transform: translateY(-1px);
                }

                .btn-delete{
                     background: #d35a52;
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 14px 26px;
    min-width: 140px;
    font-weight: 800;
    font-size: 18px;
    box-shadow: 0 4px 10px rgba(0,0,0,.10);
    transition: .2s ease;
                }

                .btn-delete:hover{
                     background: #bf4942;
    color: #fff;
    transform: translateY(-1px);
                }

                .table-responsive{
                    border-radius: 14px;
                    overflow: hidden;
                }

                .filter-label{
                    color: var(--zx-dark);
                    font-weight: 700;
                }

                .form-control-sm,
                .form-select-sm{
                    border-radius: 10px;
                }
                select.form-control {
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    outline: none !important;
    appearance: none;
    text-align: center;
}
td select {
    width: 100%;
    cursor: pointer;
}
header,
footer,
.whatsapp,
#whatsapp,
.btn-whatsapp {
    display: none !important;
}
.status-select {
    border: none;
    outline: none;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    appearance: none;
}

/* COLORES POR STATUS */
.status-select option[value="En revisión"] {
    background: #facc15;
}

.status-select option[value="En procedimiento"] {
    background: #60a5fa;
}

.status-select option[value="En camino"] {
    background: #fb923c;
}

.status-select option[value="Finalizado"] {
    background: #4ade80;
}
            </style>
        </head>

        <body>
            <div class="container mt-4">
                <div class="crud-box">
                    <h1 class="crud-title">Servicios</h1>

                    <?php
                        $employee = auth('employee')->user();
                        $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'tecnico.dashboard';
                    ?>

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <a class="btn btn-back" href="<?php echo e(route($dashboard)); ?>">
                            ← Regresar
                        </a>

                        <form action="<?php echo e(route('mantenimientos.index')); ?>" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
                            <label for="status" class="form-label mb-0 filter-label">Filtrar por Estado</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="">Seleccionar Estado</option>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                        <?php echo e($status); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="submit" class="btn btn-filter btn-sm">Filtrar</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Ocupación</th>
                                    <th hidden>Tipo de Máquina</th>
                                    <th>Código de Equipo</th>
                                    <th>Descripción</th>
                                    <th>Dirección</th>
                                    <th>Estado</th>
                                    <th>Código Postal</th>
                                    <th>Correo Electrónico</th>
                                    <th>Número de Celular</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $mantenimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mantenimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($mantenimiento->nombre); ?></td>
                                        <td><?php echo e($mantenimiento->ocupacion); ?></td>
                                        <td hidden><?php echo e($mantenimiento->tipo_maquina); ?></td>
                                        <td><?php echo e($mantenimiento->codigo_equipo); ?></td>
                                        <td><?php echo e($mantenimiento->descripcion); ?></td>
                                        <td><?php echo e($mantenimiento->direccion); ?></td>
                                        <td><?php echo e($mantenimiento->estado); ?></td>
                                        <td><?php echo e($mantenimiento->codigo_postal); ?></td>
                                        <td><?php echo e($mantenimiento->correo_electronico); ?></td>
                                        <td><?php echo e($mantenimiento->numero_celular); ?></td>

                                        <td>
                                            <form action="<?php echo e(route('mantenimientos.updateStatus', $mantenimiento->id)); ?>"
                                                method="post" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <select name="status" class="status-select"
                                                    onchange="this.form.submit()">
                                                    <option value="En revisión" <?php echo e($mantenimiento->status == 'En revisión' ? 'selected' : ''); ?>>
                                                        En revisión
                                                    </option>
                                                    <option value="En procedimiento" <?php echo e($mantenimiento->status == 'En procedimiento' ? 'selected' : ''); ?>>
                                                        En procedimiento
                                                    </option>
                                                    <option value="En camino" <?php echo e($mantenimiento->status == 'En camino' ? 'selected' : ''); ?>>
                                                        En camino
                                                    </option>
                                                    <option value="Finalizado" <?php echo e($mantenimiento->status == 'Finalizado' ? 'selected' : ''); ?>>
                                                        Finalizado
                                                    </option>
                                                </select>
                                            </form>
                                        </td>

                                        <td>
    <form action="<?php echo e(route('mantenimientos.destroy', $mantenimiento->id)); ?>" method="POST" class="d-inline">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-delete"
            onclick="return confirm('¿Estás seguro de eliminar este mantenimiento?')">
            Eliminar
        </button>
    </form>
</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($mantenimientos->appends(request()->query())->links()); ?>

                    </div>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/mantenimientos/index.blade.php ENDPATH**/ ?>