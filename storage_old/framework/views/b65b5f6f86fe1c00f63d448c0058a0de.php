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
                <h2>Editar Imagen de <br><?php echo e($imagen->producto->nombre); ?></h2>
                <div class="form-group d-flex justify-content-between mb-3">
                    <a class="btn btn-secondary btn-sm" href="<?php echo e(route('productos.imagenes.show', $imagen->producto_id)); ?>">Regresar</a>
                </div>
                <form action="<?php echo e(route('productos.imagenes.update', $imagen->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
        
                    <div class="form-group">
                        <label for="id">ID de Imagen:</label>
                        <input type="text" id="id" name="id" value="<?php echo e($imagen->id); ?>" readonly>
                    </div>
        
                    <div class="form-group">
                        <label>Imagen Actual:</label>
                        <img src="<?php echo e(asset($imagen->ruta)); ?>" alt="Imagen <?php echo e($imagen->producto->nombre); ?>" width="100">
                    </div>
        
                    <div class="form-group">
                        <label for="imagen">Seleccionar Nueva Imagen:</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*" onchange="mostrarNombre(this)">
                        <small id="nombreImagenDisplay" class="form-text text-muted">Nombre de la nueva imagen: <span style="color: black;"></span></small>
                    </div>
        
                    <script>
                    function mostrarNombre(input) {
                        const nombreImagen = input.files[0] ? input.files[0].name : '';
                        document.getElementById('nombreImagenDisplay').getElementsByTagName('span')[0].innerText = nombreImagen;
                    }
                    </script>
        
                    <div class="form-group">
                        <button type="submit" class="submit-btn">Actualizar Imagen</button>
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
        <?php endif; ?>
    <?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/productos/imagen/edit.blade.php ENDPATH**/ ?>