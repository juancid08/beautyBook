<?php $__env->startSection('title', __('admin.service_form.title_create')); ?>

<?php $__env->startSection('content'); ?>
  <div class="p-6 bg-gray-800 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold text-white"><?php echo e(__('admin.service_form.title_create')); ?></h1>
      <a href="<?php echo e(route('admin.servicios.index')); ?>"
         class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
        <?php echo e(__('admin.service_form.back_to_list')); ?>

      </a>
    </div>

    <form action="<?php echo e(route('admin.servicios.store')); ?>"
          method="POST"
          class="space-y-6">
      <?php echo csrf_field(); ?>

      <div>
        <label for="nombre" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.service_form.name')); ?>

        </label>
        <input type="text" name="nombre" id="nombre"
               value="<?php echo e(old('nombre')); ?>"
               class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
               required>
        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="descripcion" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.service_form.description')); ?>

        </label>
        <textarea name="descripcion" id="descripcion" rows="4"
                  class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"><?php echo e(old('descripcion')); ?></textarea>
        <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="precio" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.service_form.price')); ?>

        </label>
        <input type="number" step="0.01" name="precio" id="precio"
               value="<?php echo e(old('precio')); ?>"
               class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
               required>
        <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="id_salon" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.service_form.salon')); ?>

        </label>
        <select name="id_salon" id="id_salon"
                class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
                required>
          <option value="" disabled selected>
            <?php echo e(__('admin.service_form.select_salon')); ?>

          </option>
          <?php $__currentLoopData = $salones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($id); ?>"
                    <?php if(old('id_salon') == $id): echo 'selected'; endif; ?>>
              <?php echo e($nombre); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['id_salon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="flex justify-end pt-4 border-t border-gray-700">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
          <?php echo e(__('admin.service_form.save')); ?>

        </button>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/servicios/create.blade.php ENDPATH**/ ?>