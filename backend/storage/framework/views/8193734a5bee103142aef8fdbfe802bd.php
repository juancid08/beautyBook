<?php $isEdit = isset($empleado); ?>



<?php $__env->startSection('title', $isEdit ? 'Editar Empleado' : 'Nuevo Empleado'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6 bg-gray-800 rounded-lg shadow-md">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-white">
      <?php echo e($isEdit ? 'Editar Empleado' : 'Crear Empleado'); ?>

    </h1>
    <a href="<?php echo e(route('admin.empleados.index')); ?>"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
      Volver al listado
    </a>
  </div>

  <form
    action="<?php echo e($isEdit
        ? route('admin.empleados.update', $empleado)
        : route('admin.empleados.store')); ?>"
    method="POST"
    class="space-y-6"
  >
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div>
      <label for="nombre" class="block text-gray-300 mb-1">Nombre</label>
      <input type="text" name="nombre" id="nombre"
             value="<?php echo e(old('nombre', $empleado->nombre ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="apellidos" class="block text-gray-300 mb-1">Apellidos</label>
      <input type="text" name="apellidos" id="apellidos"
             value="<?php echo e(old('apellidos', $empleado->apellidos ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="telefono" class="block text-gray-300 mb-1">Teléfono</label>
      <input type="text" name="telefono" id="telefono"
             value="<?php echo e(old('telefono', $empleado->telefono ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2">
      <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="email" class="block text-gray-300 mb-1">Email</label>
      <input type="email" name="email" id="email"
             value="<?php echo e(old('email', $empleado->email ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2">
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="id_salon" class="block text-gray-300 mb-1">Salón</label>
      <select name="id_salon" id="id_salon"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un salón</option>
        <?php $__currentLoopData = $salones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($id); ?>"
                  <?php if(old('id_salon', $empleado->id_salon ?? '') == $id): echo 'selected'; endif; ?>>
            <?php echo e($nombre); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php $__errorArgs = ['id_salon'];
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
        <?php echo e($isEdit ? 'Actualizar' : 'Crear'); ?>

      </button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/empleados/form.blade.php ENDPATH**/ ?>