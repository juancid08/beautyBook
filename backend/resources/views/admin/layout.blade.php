@extends('admin.layout')

@section('content')
  <h1 class="text-2xl font-bold mb-4">
    {{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}
  </h1>

  <form action="{{ isset($usuario)
        ? route('admin.usuarios.update', $usuario)
        : route('admin.usuarios.store') }}"
        method="POST" class="space-y-4">
    @csrf
    @if(isset($usuario))
      @method('PUT')
    @endif

    <div>
      <label class="block">Nombre</label>
      <input type="text" name="nombre"
             value="{{ old('nombre', $usuario->nombre ?? '') }}"
             class="w-full border p-2 rounded">
    </div>

    <div>
      <label class="block">Email</label>
      <input type="email" name="email"
             value="{{ old('email', $usuario->email ?? '') }}"
             class="w-full border p-2 rounded">
    </div>

    <!-- otros campos según modelo -->

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded">
      {{ isset($usuario) ? 'Actualizar' : 'Crear' }}
    </button>
  </form>
@endsection
