<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title><?php echo e(config('app.name', 'Zarmex')); ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome (solo UNA vez) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- CSS Global -->
  <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">

  <!-- Vite (Tailwind / JS) -->
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

    
   <?php if(!request()->is('employees/*')): ?>
    
    <?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    
    <?php if(auth()->guard('employee')->check()): ?>
        <div class="admin-top-logout">
            <form method="POST" action="<?php echo e(route('employee.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="admin-logout-btn" title="Cerrar sesión">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    <?php endif; ?>
<?php endif; ?>



    
    <main>
      
      <?php echo e($slot ?? ''); ?>


      
      <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php if(!request()->is('employees/*')): ?>
       <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

  </div>
<?php if(!request()->is('employees/*')): ?>
    <a href="https://wa.me/525581366555?text=Hola,%20estoy%20interesado%20en%20los%20productos%20de%20Zarmex"
       target="_blank"
       style="position:fixed;bottom:25px;right:25px;z-index:999999;background:#25D366;color:#fff;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;font-weight:700;"
       title="Contáctanos por WhatsApp">
        WA
    </a>
<?php endif; ?>
  <!-- Bootstrap JS (bundle con Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Dhust\Desktop\AlaEstadia\Zarmex 2\Zarmex original\zarmex\resources\views/layouts/app.blade.php ENDPATH**/ ?>