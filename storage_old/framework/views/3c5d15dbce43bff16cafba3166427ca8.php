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
    <title>Reportes</title>
    <style>
      nav {
      background-color: inherit !important;
      }

      .table {
      background-color: white !important;
      }
    </style>
    </head>

    <body>
    <div class="container mt-5">
      <!-- Botones superiores -->
      <h1 style="text-align: center; color: aliceblue;">Reportes de Soporte y quejas</h1>
      <?php
        $employee = auth('employee')->user();
        $dashboard = $employee && $employee->hasRole('admin') ? 'admin.dashboard' : 'soporte.dashboard';
      ?>

      <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-secondary btn-sm" href="<?php echo e(route($dashboard)); ?>">
          Regresar
        </a>
      </div>


      <!-- Filtros -->
      <div class="d-flex justify-content-end mb-3">
      <form method="GET" action="<?php echo e(route('reportes.index')); ?>" class="d-flex gap-2">
        <select name="filtro" class="form-select form-select-sm">
        <option value="">-- Filtrar por --</option>
        <option value="soporte" <?php echo e(request('filtro') == 'soporte' ? 'selected' : ''); ?>>Soporte</option>
        <option value="queja" <?php echo e(request('filtro') == 'queja' ? 'selected' : ''); ?>>Queja</option>
        <option value="no_asignado" <?php echo e(request('filtro') == 'no_asignado' ? 'selected' : ''); ?>>No asignados</option>
        <option value="pendiente" <?php echo e(request('filtro') == 'pendiente' ? 'selected' : ''); ?>>Pendientes</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        <a href="<?php echo e(route('reportes.index')); ?>" class="btn btn-secondary btn-sm">Restablecer</a>
      </form>
      </div>



      <!-- Tabla de Reportes -->
      <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
          <th>Id Reporte</th>
          <th>Nombre de usuario</th>
          <th>Correo de usuario</th>
          <th>Tipo</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Empleado Asignado</th>
          <th>Creado En</th>
          <th>Actualizado En</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $reportes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reporte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($reporte->id_reporte); ?></td>
        <td><?php echo e($reporte->usuario ? $reporte->usuario->name : 'Nombre desconocido desconocido'); ?></td>
        <td><?php echo e($reporte->usuario ? $reporte->usuario->email : 'Correo electrónico desconocido'); ?></td>
        <td><?php echo e(ucfirst($reporte->tipo_reporte)); ?></td>
        <td><?php echo e($reporte->descripcion); ?></td>
        <td><?php echo e(ucfirst($reporte->estado)); ?></td>
        <td><?php echo e($reporte->empleado ? $reporte->empleado->name : 'No asignado'); ?></td>
        <td><?php echo e($reporte->creado_en->format('d-m-Y H:i')); ?></td>
        <td><?php echo e($reporte->actualizado_en->format('d-m-Y H:i')); ?></td>
        <td>
        <a href="<?php echo e(route('reportes.edit', $reporte->id_reporte)); ?>" class="btn btn-primary btn-sm">Editar</a>
        <form action="<?php echo e(route('reportes.destroy', $reporte->id_reporte)); ?>" method="post" class="d-inline">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('¿Estás seguro de eliminar este reporte?')">Eliminar</button>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/reportes/index.blade.php ENDPATH**/ ?>