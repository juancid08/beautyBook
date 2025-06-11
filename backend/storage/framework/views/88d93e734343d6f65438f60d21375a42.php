<?php $isEdit = isset($usuario); ?>



<?php $__env->startSection('title', $isEdit
    ? __('admin.form.title_edit')
    : __('admin.form.title_create')
); ?>

<?php $__env->startSection('content'); ?>
  <div class="px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-100">
        <?php echo e($isEdit
            ? __('admin.form.title_edit')
            : __('admin.form.title_create')); ?>

      </h1>
      <a href="<?php echo e(route('admin.usuarios.index')); ?>"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
        <?php echo e(__('admin.form.back_to_list')); ?>

      </a>
    </div>

    <form action="<?php echo e($isEdit
         ? route('admin.usuarios.update', $usuario)
         : route('admin.usuarios.store')); ?>"
          method="POST"
          class="space-y-6 bg-gray-900 p-6 rounded shadow">
      <?php echo csrf_field(); ?>
      <?php if($isEdit): ?>
        <?php echo method_field('PUT'); ?>
      <?php endif; ?>

      <div>
        <label for="nombre"
               class="block text-gray-300 font-medium mb-1">
          <?php echo e(__('admin.form.name')); ?>

        </label>
        <input id="nombre" type="text" name="nombre"
               value="<?php echo e(old('nombre', $usuario->nombre ?? '')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="apellidos"
               class="block text-gray-300 font-medium mb-1">
          <?php echo e(__('admin.form.last_name')); ?>

        </label>
        <input id="apellidos" type="text" name="apellidos"
               value="<?php echo e(old('apellidos', $usuario->apellidos ?? '')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="email"
               class="block text-gray-300 font-medium mb-1">
          <?php echo e(__('admin.form.email')); ?>

        </label>
        <input id="email" type="email" name="email"
               value="<?php echo e(old('email', $usuario->email ?? '')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="telefono"
               class="block text-gray-300 font-medium mb-1">
          <?php echo e(__('admin.form.phone')); ?>

        </label>
        <input id="telefono" type="text" name="telefono"
               value="<?php echo e(old('telefono', $usuario->telefono ?? '')); ?>"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label for="rol"
               class="block text-gray-300 font-medium mb-1">
          <?php echo e(__('admin.form.role')); ?>

        </label>
        <select id="rol" name="rol"
                class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
          <option value="cliente"
            <?php if(old('rol', $usuario->rol ?? '')=='cliente'): echo 'selected'; endif; ?>>
            <?php echo e(__('admin.form.role_client')); ?>

          </option>
          <option value="administrador"
            <?php if(old('rol', $usuario->rol ?? '')=='administrador'): echo 'selected'; endif; ?>>
            <?php echo e(__('admin.form.role_admin')); ?>

          </option>
        </select>
        <?php $__errorArgs = ['rol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <?php if (! ($isEdit)): ?>
        <div>
          <label for="password"
                 class="block text-gray-300 font-medium mb-1">
            <?php echo e(__('admin.form.password')); ?>

          </label>
          <input id="password" type="password" name="password"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label for="password_confirmation"
                 class="block text-gray-300 font-medium mb-1">
            <?php echo e(__('admin.form.password_confirmation')); ?>

          </label>
          <input id="password_confirmation" type="password" name="password_confirmation"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      <?php endif; ?>

      <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700">
        <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded">
          <?php echo e($isEdit ? __('admin.form.update') : __('admin.form.save')); ?>

        </button>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/usuarios/form.blade.php ENDPATH**/ ?>