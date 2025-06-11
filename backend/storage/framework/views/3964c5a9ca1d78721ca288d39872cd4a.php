<?php $isEdit = isset($cita); ?>



<?php $__env->startSection('title', $isEdit ? 'Editar Cita' : 'Nueva Cita'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6 bg-gray-800 rounded-lg shadow-md">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-white">
      <?php echo e($isEdit ? 'Editar Cita' : 'Crear Cita'); ?>

    </h1>
    <a href="<?php echo e(route('admin.citas.index')); ?>"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
      Volver al listado
    </a>
  </div>

  <form
    action="<?php echo e($isEdit
        ? route('admin.citas.update', $cita)
        : route('admin.citas.store')); ?>"
    method="POST"
    class="space-y-6"
  >
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div>
      <label for="fecha" class="block text-gray-300 mb-1">Fecha</label>
      <input type="date" name="fecha" id="fecha"
             value="<?php echo e(old('fecha', $cita->fecha ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="hora" class="block text-gray-300 mb-1">Hora</label>
      <input type="time" name="hora" id="hora"
             value="<?php echo e(old('hora', $cita->hora ?? '')); ?>"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      <?php $__errorArgs = ['hora'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label for="id_usuario" class="block text-gray-300 mb-1">Cliente</label>
      <select name="id_usuario" id="id_usuario"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un cliente</option>
        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($id); ?>"
                  <?php if(old('id_usuario', $cita->id_usuario ?? '') == $id): echo 'selected'; endif; ?>>
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
      <label for="id_servicio" class="block text-gray-300 mb-1">Servicio</label>
      <select name="id_servicio" id="id_servicio"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un servicio</option>
        <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($id); ?>"
                  <?php if(old('id_servicio', $cita->id_servicio ?? '') == $id): echo 'selected'; endif; ?>>
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
      <label for="id_empleado" class="block text-gray-300 mb-1">Empleado</label>
      <select name="id_empleado" id="id_empleado"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un empleado</option>
        <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($id); ?>"
                  <?php if(old('id_empleado', $cita->id_empleado ?? '') == $id): echo 'selected'; endif; ?>>
            <?php echo e($nombre); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php $__errorArgs = ['id_empleado'];
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/citas/form.blade.php ENDPATH**/ ?>