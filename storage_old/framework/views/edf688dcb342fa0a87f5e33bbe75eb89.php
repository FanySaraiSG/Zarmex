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
  <title>Categorías</title>

  <style>
    :root{
      --zx: #234d50;           /* azul verdoso */
      --zx-soft: rgba(35,77,80,.10);
      --bd: rgba(0,0,0,.10);
    }

    nav{ background-color: inherit !important; }

    /* Fondo general (igual al de reseñas) */
    body{
      background: var(--zx);
      min-height: 100vh;
    }

    /* Contenedor estilo “panel” */
    .zx-wrap{
      max-width: 1200px;
      margin: 26px auto;
      padding: 0 14px;
    }

    .zx-card{
      background: #fff;
      border: 1px solid var(--bd);
      border-radius: 18px;
      box-shadow: 0 16px 35px rgba(0,0,0,.18);
      padding: 18px;
    }

    .zx-title{
      font-weight: 900;
      font-size: 26px;
      color: #234d50;
      text-align: center;
      margin: 6px 0 16px;
      letter-spacing: .4px;
    }

    /* Barra superior de botones */
    .zx-actions{
      display: flex;
      gap: 10px;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 14px;
    }

    .btn-zx{
  background: var(--zx);
  color: #fff !important;
  border: none;
  border-radius: 10px;
  font-weight: 800;
  padding: 10px 14px;
  transition: all .2s ease;
}

.btn-zx:hover,
.btn-zx:focus,
.btn-zx:active{
  background: var(--zx) !important;
  color: #fff !important;
  opacity: .85;
  box-shadow: none !important;
}

    .btn-zx-outline{
      background: rgba(35,77,80,.12);
      color: var(--zx);
      border: 1px solid rgba(35,77,80,.25);
      border-radius: 10px;
      font-weight: 800;
      padding: 10px 14px;
    }
    .btn-zx-outline{
  background: rgba(35,77,80,.12);
  color: var(--zx) !important;
  border: 1px solid rgba(35,77,80,.25);
  border-radius: 10px;
  font-weight: 800;
  padding: 10px 14px;
  transition: all .2s ease;
}

.btn-zx-outline:hover,
.btn-zx-outline:focus,
.btn-zx-outline:active{
  background: rgba(35,77,80,.12) !important;
  color: var(--zx) !important;
  opacity: .8;
  box-shadow: none !important;
}

    /* Tabla */
    .table{
      background: #fff !important;
      margin-bottom: 0;
    }
    .table thead th{
      background: #28666e !important;
      color: #fff !important;
      border-color: rgba(255,255,255,.08);
      white-space: nowrap;
    }
    .table td{ vertical-align: middle; }

    /* Botones de acciones (editar/eliminar) */
    .btn-sm{ border-radius: 10px; font-weight: 800; }

  </style>
</head>

<body>
  <div class="zx-wrap">
    <div class="zx-card">

      <div class="zx-title">Categorías</div>

      <div class="zx-actions">
        <a class="btn btn-zx" href="<?php echo e(route('admin.dashboard')); ?>">
          ← Volver al Panel
        </a>

        <a class="btn btn-zx-outline" href="<?php echo e(route('categorias.create')); ?>">
          + Añadir Categoría
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th style="width:190px;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($categoria->nombre); ?></td>
                <td><?php echo e($categoria->descripcion); ?></td>
                <td class="d-flex gap-2">
                  <a href="<?php echo e(route('categorias.edit', $categoria->id_categoria)); ?>"
                     class="btn btn-primary btn-sm">
                    Editar
                  </a>

                  <form action="<?php echo e(route('categorias.destroy', $categoria->id_categoria)); ?>"
                        method="post" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                      Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <?php if(session('success')): ?>
    <script>alert(<?php echo json_encode(session('success'), 15, 512) ?>);</script>
  <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/categorias/index.blade.php ENDPATH**/ ?>