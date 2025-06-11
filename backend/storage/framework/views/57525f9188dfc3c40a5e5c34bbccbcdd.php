<?php $isEdit = isset($resena); ?>



<?php $__env->startSection('title', $isEdit
    ? __('admin.review_form.title_edit')
    : __('admin.review_form.title_create')
); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6 bg-gray-800 rounded-lg shadow-md">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-white">
      <?php echo e($isEdit
          ? __('admin.review_form.title_edit')
          : __('admin.review_form.title_create')); ?>

    </h1>
    <a href="<?php echo e(route('admin.resenas.index')); ?>"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
      <?php echo e(__('admin.review_form.back_to_list')); ?>

    </a>
  </div>

  <form
    action="<?php echo e($isEdit
        ? route('admin.resenas.update', $resena)
        : route('admin.resenas.store')); ?>"
    method="POST"
    class="space-y-6"
  >
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div>
      <label for="id_usuario" class="block text-gray-300 mb-1">
        <?php echo e(__('admin.review_form.user')); ?>

      </label>
      <select id="id_usuario" name="id_usuario"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>
          <?php echo e(__('admin.review_form.select_user')); ?>

        </option>
        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($id); ?>"
                  <?php if(old('id_usuario', $resena->id_usuario ?? '') == $id): echo 'selected'; endif; ?>>
            <?php echo e($nombre); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php $__errorArgs = ['id_usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="id_servicio" class="block text-gray-300 mb-1">
        <?php echo e(__('admin.review_form.service')); ?>

      </label>
      <select id="id_servicio" name="id_servicio"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>
          <?php echo e(__('admin.review_form.select_service')); ?>

        </option>
        <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($id); ?>"
                  <?php if(old('id_servicio', $resena->id_servicio ?? '') == $id): echo 'selected'; endif; ?>>
            <?php echo e($nombre); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php $__errorArgs = ['id_servicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="valoracion" class="block text-gray-300 mb-1">
        <?php echo e(__('admin.review_form.rating')); ?>

      </label>
      <input type="number" name="valoracion" id="valoracion" min="1" max="5"
             value="<?php echo e(old('valoracion', $resena->valoracion ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      <?php $__errorArgs = ['valoracion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="comentario" class="block text-gray-300 mb-1">
        <?php echo e(__('admin.review_form.comment')); ?>

      </label>
      <textarea name="comentario" id="comentario" rows="4"
                class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"><?php echo e(old('comentario', $resena->comentario ?? '')); ?></textarea>
      <?php $__errorArgs = ['comentario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-700">
      <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
        <?php echo e($isEdit ? __('admin.review_form.update') : __('admin.review_form.save')); ?>

      </button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/resenas/form.blade.php ENDPATH**/ ?>