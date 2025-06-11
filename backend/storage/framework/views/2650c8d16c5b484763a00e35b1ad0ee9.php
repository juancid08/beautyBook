<?php $__env->startSection('title', __('admin.salons.title')); ?>

<?php $__env->startSection('content'); ?>
  <div class="px-4 sm:px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row items-start sm:items-center 
                justify-between mb-4 space-y-2 sm:space-y-0">
      <h1 class="text-2xl font-semibold text-gray-100">
        <?php echo e(__('admin.salons.header')); ?>

      </h1>
      <div class="flex space-x-2">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 
                  text-white font-medium rounded text-sm">
          <?php echo e(__('admin.salons.back_dashboard')); ?>

        </a>
        <a href="<?php echo e(route('admin.salones.create')); ?>"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 
                  text-white font-medium rounded text-sm">
          <?php echo e(__('admin.salons.create')); ?>

        </a>
      </div>
    </div>

    <?php if(session('success')): ?>
      <div class="mb-4 p-3 bg-green-700 text-green-100 rounded">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
      
      <table class="min-w-full divide-y divide-gray-700 hidden md:table">
        <thead class="bg-gray-900">
          <tr>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              <?php echo e(__('admin.salons.id')); ?>

            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              <?php echo e(__('admin.salons.name')); ?>

            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              <?php echo e(__('admin.salons.address')); ?>

            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              <?php echo e(__('admin.salons.phone')); ?>

            </th>
            <th class="px-4 py-2 text-center text-gray-300 uppercase text-sm">
              <?php echo e(__('admin.salons.actions')); ?>

            </th>
          </tr>
        </thead>
        <tbody class="bg-gray-800 divide-y divide-gray-700">
          <?php $__empty_1 = true; $__currentLoopData = $salones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="<?php if($loop->even): ?> bg-gray-700 <?php endif; ?>">
              <td class="px-4 py-3 text-gray-200"><?php echo e($salon->id_salon); ?></td>
              <td class="px-4 py-3 text-gray-200"><?php echo e($salon->nombre); ?></td>
              <td class="px-4 py-3 text-gray-200"><?php echo e($salon->direccion); ?></td>
              <td class="px-4 py-3 text-gray-200"><?php echo e($salon->telefono ?? '—'); ?></td>
              <td class="px-4 py-3 text-center space-x-2">
                <a href="<?php echo e(route('admin.salones.edit', $salon)); ?>"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white 
                          rounded text-sm">
                  <?php echo e(__('admin.salons.edit')); ?>

                </a>
                <form action="<?php echo e(route('admin.salones.destroy', $salon)); ?>"
                      method="POST" class="inline">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit"
                          onclick="return confirm('<?php echo e(__('admin.salons.confirm_delete')); ?>')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    <?php echo e(__('admin.salons.delete')); ?>

                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                <?php echo e(__('admin.salons.no_records')); ?>

              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      
      <div class="space-y-4 md:hidden">
        <?php $__empty_1 = true; $__currentLoopData = $salones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="bg-gray-900 p-4 rounded shadow">
            <div class="flex justify-between items-start">
              <div class="space-y-1">
                <p class="text-gray-300 text-sm">
                  <span class="font-semibold"><?php echo e(__('admin.salons.id')); ?>:</span>
                  <?php echo e($salon->id_salon); ?>

                </p>
                <p class="text-gray-200 font-medium"><?php echo e($salon->nombre); ?></p>
                <p class="text-gray-300 text-sm">
                  <span class="font-semibold"><?php echo e(__('admin.salons.address')); ?>:</span>
                  <?php echo e($salon->direccion); ?>

                </p>
                <p class="text-gray-300 text-sm">
                  <span class="font-semibold"><?php echo e(__('admin.salons.phone')); ?>:</span>
                  <?php echo e($salon->telefono ?? '—'); ?>

                </p>
              </div>
              <div class="flex flex-col space-y-2 ml-4">
                <a href="<?php echo e(route('admin.salones.edit', $salon)); ?>"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs text-center">
                  <?php echo e(__('admin.salons.edit')); ?>

                </a>
                <form action="<?php echo e(route('admin.salones.destroy', $salon)); ?>"
                      method="POST">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit"
                          onclick="return confirm('<?php echo e(__('admin.salons.confirm_delete')); ?>')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs w-full">
                    <?php echo e(__('admin.salons.delete')); ?>

                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-center text-gray-400"><?php echo e(__('admin.salons.no_records')); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/salones/index.blade.php ENDPATH**/ ?>