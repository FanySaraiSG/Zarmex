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
  <title>Añadir Imagen</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background: #f6f7fb; }
    .wrap { max-width: 860px; margin: 40px auto; padding: 0 14px; }
    .cardbox{
      background:#fff;
      border-radius:18px;
      border:1px solid rgba(0,0,0,.08);
      box-shadow:0 18px 45px rgba(0,0,0,.08);
      padding:28px;
    }
    .title{
      text-align:center;
      font-weight:900;
      letter-spacing:2px;
      color:#234d50;
      margin-bottom:10px;
      text-transform:uppercase;
    }
    .sub{
      text-align:center;
      color:#6b7280;
      margin-bottom:22px;
    }
    .btn-zx{
      background:#234d50;
      border:0;
      color:#fff;
      font-weight:800;
      border-radius:12px;
      padding:12px 16px;
    }
    .btn-zx:hover{ background:#1d3f42; }
    .btn-soft{
      background:rgba(35,77,80,.10);
      color:#234d50;
      border:1px solid rgba(35,77,80,.18);
      font-weight:800;
      border-radius:12px;
      padding:10px 14px;
      text-decoration:none;
      display:inline-block;
    }
    .btn-soft:hover{ background:rgba(35,77,80,.14); }
    .hint{ font-size:12px; color:#6b7280; margin-top:6px; }
    .preview{
      margin-top:10px;
      border-radius:14px;
      border:1px solid rgba(0,0,0,.10);
      width:100%;
      max-height:260px;
      object-fit:cover;
      display:none;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="cardbox">
      <h1 class="title">AÑADIR IMAGEN</h1>
      <p class="sub">Selecciona la sección y sube la imagen.</p>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?php echo e(route('imagenes.index')); ?>" class="btn-soft">Regresar</a>
      </div>

      
      <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
      <?php endif; ?>

      <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
      <?php endif; ?>

      <?php if($errors->any()): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      
      <form action="<?php echo e(route('imagenes.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <div class="mb-3">
          <label class="form-label fw-bold">Nombre:</label>
          <input
            id="nombre"
            type="text"
            name="nombre"
            class="form-control"
            placeholder="Ej: Banner principal 1"
            value="<?php echo e(old('nombre')); ?>"
            required
          >
          <div class="hint">Tip: se autollenará con el nombre del archivo (puedes editarlo).</div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Sección de la Imagen:</label>

          
          <select name="seccion" class="form-select" required>
            <option value="banner" <?php echo e(old('seccion')==='banner' ? 'selected' : ''); ?>>Banner</option>
            <option value="nosotros_banner" <?php echo e(old('seccion')==='nosotros_banner' ? 'selected' : ''); ?>>Nosotros Banner</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Subir Imagen:</label>
          <input id="imagen" type="file" name="imagen" class="form-control" accept="image/*" required>
          <div class="hint">Formatos: JPG, PNG, WEBP, GIF.</div>

          
          <img id="preview" class="preview" alt="Vista previa">
        </div>

        <button type="submit" class="btn btn-zx w-100">
          Subir Imagen
        </button>
      </form>
    </div>
  </div>

  <script>
    const inputFile = document.getElementById('imagen');
    const inputNombre = document.getElementById('nombre');
    const preview = document.getElementById('preview');

    inputFile.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if(!file) return;

      // Autollenar nombre si está vacío o si es el default
      if(!inputNombre.value.trim()){
        inputNombre.value = file.name.replace(/\.[^/.]+$/, ""); // sin extensión
      }

      // Preview
      const url = URL.createObjectURL(file);
      preview.src = url;
      preview.style.display = 'block';
    });
  </script>
</body>
</html>

<?php else: ?>
  <div class="container mt-5">
    <div class="alert alert-danger text-center">
      <h4>Access Denied</h4>
      <p>No tienes permisos para ver esta página.</p>
      <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary">Regresar</a>
    </div>
  </div>
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
<?php endif; ?><?php /**PATH C:\Users\Dhust\Desktop\AlaEstadia\Zarmex 2\Zarmex original\zarmex\resources\views/imagenes/create.blade.php ENDPATH**/ ?>