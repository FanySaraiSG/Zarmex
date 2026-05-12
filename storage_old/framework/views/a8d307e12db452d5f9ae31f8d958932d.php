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
    
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('css/formularios.css')); ?>">
    <?php if(auth()->guard('employee')->check()): ?>
    <?php if(Auth::user()->rol === 'admin'): ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
    </head>
    <body>
    <section class="container mt-5">
        <div class="form-container">
                <div class="form-container">
                    <h2>Añadir Imagen a <br><?php echo e($producto->nombre); ?></h2>
                    <div class="form-group d-flex justify-content-between mb-3">
                        <a class="btn btn-secondary btn-sm" href="<?php echo e(route('productos.imagenes.show', $producto->id)); ?>">Regresar</a>
                    </div>
                    <form action="<?php echo e(route('productos.imagenes.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
    
                        <!-- ID del Producto (Oculto) -->
                        <input type="hidden" name="producto_id" value="<?php echo e($producto->id); ?>">
    
                        <div class="form-group">
                            <label for="imagen">Seleccionar Imagen:</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" required onchange="mostrarNombre(this)">
                            <small id="nombreImagenDisplay" class="form-text text-muted">Nombre de la imagen: <span></span></small>
                        </div>
    
                        <script>
                        function mostrarNombre(input) {
                            const nombreImagen = input.files[0] ? input.files[0].name : '';
                            document.getElementById('nombreImagenDisplay').getElementsByTagName('span')[0].innerText = nombreImagen;
                        }
                        </script>
    
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Subir Imagen</button>
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
<?php endif; ?>
      <?php /**PATH C:\xampp\htdocs\zarmex\resources\views/productos/imagen/create.blade.php ENDPATH**/ ?>