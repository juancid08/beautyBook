<?php $__env->startSection('title', __('admin.salon_form.title_create')); ?>

<?php $__env->startSection('content'); ?>
  <div class="px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-100">
        <?php echo e(__('admin.salon_form.title_create')); ?>

      </h1>
      <a href="<?php echo e(route('admin.salones.index')); ?>"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
        <?php echo e(__('admin.salon_form.back_to_list')); ?>

      </a>
    </div>

    <form action="<?php echo e(route('admin.salones.store')); ?>"
          method="POST" enctype="multipart/form-data"
          class="space-y-6 bg-gray-900 p-6 rounded shadow">
      <?php echo csrf_field(); ?>

      <div>
        <label for="nombre" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.name')); ?>

        </label>
        <input id="nombre" name="nombre" type="text"
               value="<?php echo e(old('nombre')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="direccion" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.address')); ?>

        </label>
        <input id="direccion" name="direccion" type="text"
               value="<?php echo e(old('direccion')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="telefono" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.phone')); ?>

        </label>
        <input id="telefono" name="telefono" type="text"
               value="<?php echo e(old('telefono')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="horario_apertura" class="block text-gray-300 mb-1">
            <?php echo e(__('admin.salon_form.opening')); ?>

          </label>
          <input id="horario_apertura" name="horario_apertura" type="time"
                 value="<?php echo e(old('horario_apertura')); ?>"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          <?php $__errorArgs = ['horario_apertura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label for="horario_cierre" class="block text-gray-300 mb-1">
            <?php echo e(__('admin.salon_form.closing')); ?>

          </label>
          <input id="horario_cierre" name="horario_cierre" type="time"
                 value="<?php echo e(old('horario_cierre')); ?>"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          <?php $__errorArgs = ['horario_cierre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div>
        <label for="descripcion" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.description')); ?>

        </label>
        <textarea id="descripcion" name="descripcion" rows="4"
                  class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded resize-none"><?php echo e(old('descripcion')); ?></textarea>
        <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="especializacion" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.specialization')); ?>

        </label>
        <input id="especializacion" name="especializacion" type="text"
               value="<?php echo e(old('especializacion')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        <?php $__errorArgs = ['especializacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="foto" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.photo')); ?>

        </label>
        <input id="foto" name="foto" type="file"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="id_usuario" class="block text-gray-300 mb-1">
          <?php echo e(__('admin.salon_form.owner')); ?>

        </label>
        <select id="id_usuario" name="id_usuario"
                class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                required>
          <option value="" disabled selected>
            <?php echo e(__('admin.salon_form.select_owner')); ?>

          </option>
          <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($id); ?>" <?php if(old('id_usuario')==$id): echo 'selected'; endif; ?>>
              <?php echo e($nombre); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['id_usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700">
        <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
          <?php echo e(__('admin.salon_form.save')); ?>

        </button>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/salones/create.blade.php ENDPATH**/ ?>