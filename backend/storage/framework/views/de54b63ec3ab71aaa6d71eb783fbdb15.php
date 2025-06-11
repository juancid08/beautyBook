<?php $__env->startSection('title', __('admin.dashboard.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
  <?php
    $locale = app()->getLocale();
    $other  = $locale === 'es' ? 'en' : 'es';
    $label  = $other === 'es' ? 'Español' : 'English';
  ?>

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold"><?php echo e(__('admin.dashboard.title')); ?></h1>

    <div class="flex space-x-2">
      
      <a href="<?php echo e(route('lang.switch', $other)); ?>"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded text-sm">
        <?php echo e($label); ?>

      </a>

      
      <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
        <?php echo csrf_field(); ?>
        <button
          type="submit"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded text-sm"
        >
          <?php echo e(__('admin.dashboard.logout')); ?>

        </button>
      </form>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2"><?php echo e(__('admin.dashboard.users.label')); ?></h2>
      <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="block mb-1 text-blue-600 hover:underline">
        <?php echo e(__('admin.dashboard.users.view_all')); ?>

      </a>
      <a href="<?php echo e(route('admin.usuarios.create')); ?>" class="block text-green-600 hover:underline">
        <?php echo e(__('admin.dashboard.users.create_new')); ?>

      </a>
    </div>

    
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2"><?php echo e(__('admin.dashboard.salons.label')); ?></h2>
      <a href="<?php echo e(route('admin.salones.index')); ?>" class="block mb-1 text-blue-600 hover:underline">
        <?php echo e(__('admin.dashboard.salons.view_all')); ?>

      </a>
      <a href="<?php echo e(route('admin.salones.create')); ?>" class="block text-green-600 hover:underline">
        <?php echo e(__('admin.dashboard.salons.create_new')); ?>

      </a>
    </div>

    
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2"><?php echo e(__('admin.dashboard.services.label')); ?></h2>
      <a href="<?php echo e(route('admin.servicios.index')); ?>" class="block mb-1 text-blue-600 hover:underline">
        <?php echo e(__('admin.dashboard.services.view_all')); ?>

      </a>
      <a href="<?php echo e(route('admin.servicios.create')); ?>" class="block text-green-600 hover:underline">
        <?php echo e(__('admin.dashboard.services.create_new')); ?>

      </a>
    </div>

    
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2"><?php echo e(__('admin.dashboard.employees.label')); ?></h2>
      <a href="<?php echo e(route('admin.empleados.index')); ?>" class="block mb-1 text-blue-600 hover:underline">
        <?php echo e(__('admin.dashboard.employees.view_all')); ?>

      </a>
      <a href="<?php echo e(route('admin.empleados.create')); ?>" class="block text-green-600 hover:underline">
        <?php echo e(__('admin.dashboard.employees.create_new')); ?>

      </a>
    </div>

    
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2"><?php echo e(__('admin.dashboard.appointments.label')); ?></h2>
      <a href="<?php echo e(route('admin.citas.index')); ?>" class="block mb-1 text-blue-600 hover:underline">
        <?php echo e(__('admin.dashboard.appointments.view_all')); ?>

      </a>
      <a href="<?php echo e(route('admin.citas.create')); ?>" class="block text-green-600 hover:underline">
        <?php echo e(__('admin.dashboard.appointments.create_new')); ?>

      </a>
    </div>

    
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2"><?php echo e(__('admin.dashboard.reviews.label')); ?></h2>
      <a href="<?php echo e(route('admin.resenas.index')); ?>" class="block mb-1 text-blue-600 hover:underline">
        <?php echo e(__('admin.dashboard.reviews.view_all')); ?>

      </a>
      <a href="<?php echo e(route('admin.resenas.create')); ?>" class="block text-green-600 hover:underline">
        <?php echo e(__('admin.dashboard.reviews.create_new')); ?>

      </a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>