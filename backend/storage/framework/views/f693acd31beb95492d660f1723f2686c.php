<?php $__env->startSection('title', 'Empleados'); ?>

<?php $__env->startSection('content'); ?>
  <div class="px-4 sm:px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 space-y-2 sm:space-y-0">
      <h1 class="text-2xl font-semibold text-gray-100">Empleados</h1>
      <div class="flex space-x-2">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded text-sm">
          Volver al Dashboard
        </a>
        <a href="<?php echo e(route('admin.empleados.create')); ?>"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded text-sm">
          Nuevo Empleado
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
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Nombre</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Teléfono</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Email</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Salón</th>
            <th class="px-4 py-2 text-center text-gray-300 uppercase text-sm">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-gray-800 divide-y divide-gray-700">
          <?php $__empty_1 = true; $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="<?php if($loop->even): ?> bg-gray-700 <?php endif; ?>">
              <td class="px-4 py-3 text-gray-200"><?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellidos); ?></td>
              <td class="px-4 py-3 text-gray-200"><?php echo e($empleado->telefono ?? '—'); ?></td>
              <td class="px-4 py-3 text-gray-200"><?php echo e($empleado->email ?? '—'); ?></td>
              <td class="px-4 py-3 text-gray-200"><?php echo e(optional($empleado->salon)->nombre ?? '—'); ?></td>
              <td class="px-4 py-3 text-center space-x-2">
                <a href="<?php echo e(route('admin.empleados.edit', $empleado)); ?>"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                  Editar
                </a>
                <form action="<?php echo e(route('admin.empleados.destroy', $empleado)); ?>"
                      method="POST" class="inline">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit"
                          onclick="return confirm('¿Eliminar este empleado?')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    Eliminar
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                No hay empleados registrados.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      
      <div class="space-y-4 md:hidden">
        <?php $__empty_1 = true; $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="bg-gray-900 p-4 rounded shadow">
            <div class="space-y-2">
              <p class="text-gray-200 font-medium"><?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellidos); ?></p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">Teléfono:</span> <?php echo e($empleado->telefono ?? '—'); ?>

              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">Email:</span> <?php echo e($empleado->email ?? '—'); ?>

              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">Salón:</span> <?php echo e(optional($empleado->salon)->nombre ?? '—'); ?>

              </p>
              <div class="flex space-x-2 pt-2">
                <a href="<?php echo e(route('admin.empleados.edit', $empleado)); ?>"
                   class="flex-1 text-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">
                  Editar
                </a>
                <form action="<?php echo e(route('admin.empleados.destroy', $empleado)); ?>"
                      method="POST" class="flex-1">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit"
                          onclick="return confirm('¿Eliminar este empleado?')"
                          class="w-full px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                    Eliminar
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-center text-gray-400">No hay empleados registrados.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/empleados/index.blade.php ENDPATH**/ ?>