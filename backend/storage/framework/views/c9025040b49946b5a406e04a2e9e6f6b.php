<?php $__env->startSection('content'); ?>
  <h1 class="text-2xl font-bold mb-4">
    <?php echo e(isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario'); ?>

  </h1>

  <form action="<?php echo e(isset($usuario)
        ? route('admin.usuarios.update', $usuario)
        : route('admin.usuarios.store')); ?>"
        method="POST" class="space-y-4">
    <?php echo csrf_field(); ?>
    <?php if(isset($usuario)): ?>
      <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div>
      <label class="block">Nombre</label>
      <input type="text" name="nombre"
             value="<?php echo e(old('nombre', $usuario->nombre ?? '')); ?>"
             class="w-full border p-2 rounded">
    </div>

    <div>
      <label class="block">Email</label>
      <input type="email" name="email"
             value="<?php echo e(old('email', $usuario->email ?? '')); ?>"
             class="w-full border p-2 rounded">
    </div>

    <!-- otros campos según modelo -->

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded">
      <?php echo e(isset($usuario) ? 'Actualizar' : 'Crear'); ?>

    </button>
  </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/layout.blade.php ENDPATH**/ ?>