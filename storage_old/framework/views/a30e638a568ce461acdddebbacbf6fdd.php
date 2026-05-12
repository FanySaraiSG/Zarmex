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
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e(config('app.name', 'Zarmex')); ?></title>   
    <link rel="stylesheet" href="<?php echo e(asset('css/formularios.css')); ?>">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

<section class="cardform">
  <div class="form-container">
    <h2>Actualizar Empleado</h2>
    <form action="<?php echo e(route('employees.update', $employee->id_empleado)); ?>" method="post">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="form-group d-flex justify-content-between mb-3">
          <a class="btn btn-secondary btn-sm" href="<?php echo e(route('employees.index')); ?>">Regresar</a>
        </div>
      <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?php echo e($employee->name); ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo e($employee->email); ?>" required>
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo e($employee->telefono); ?>">
      </div>
      <div class="form-group">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
          <option value="admin" <?php echo e($employee->rol == 'admin' ? 'selected' : ''); ?>>Admin</option>
          <option value="soporte" <?php echo e($employee->rol == 'soporte' ? 'selected' : ''); ?>>Soporte</option>
          <option value="tecnico" <?php echo e($employee->rol == 'tecnico' ? 'selected' : ''); ?>>Técnico</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="submit-btn">Actualizar Empleado</button>
      </div>
    </form>
  </div>
</section>


  <?php else: ?>
  <div class="container mt-5">
  <div class="alert alert-danger text-center">
    <h4>Access Denied</h4>
    <p>You do not have permission to view this page.</p>
    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">Go Back</a>
  </div>
  </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/employees/edit.blade.php ENDPATH**/ ?>