
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $__env->yieldContent('title'); ?></title>

  
  <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="antialiased bg-gray-100 text-gray-800">

  <main class="container mx-auto py-6">
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>