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
    <h2>Agregar Empleado</h2>
    <?php if(auth()->guard('employee')->check()): ?>
      <?php if(Auth::user()->rol === 'admin'): ?>
        <div class="form-group d-flex justify-content-between mb-3">
          <a class="btn btn-secondary btn-sm" href="<?php echo e(route('employees.index')); ?>">Regresar</a>
        </div>
        <form action="<?php echo e(route('employees.store')); ?>" method="post">
          <?php echo csrf_field(); ?>
          <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">
          </div>
          <div class="form-group">
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
              <option value="admin">Admin</option>
              <option value="soporte" selected>Soporte</option>
              <option value="tecnico">Técnico</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="submit-btn">Crear Empleado</button>
          </div>
        </form>
      <?php endif; ?>
    <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/employees/create.blade.php ENDPATH**/ ?>