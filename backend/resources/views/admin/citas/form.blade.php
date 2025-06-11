@php $isEdit = isset($cita); @endphp

@extends('layouts.app')

@section('title', $isEdit ? 'Editar Cita' : 'Nueva Cita')

@section('content')
<div class="p-6 bg-gray-800 rounded-lg shadow-md">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-white">
      {{ $isEdit ? 'Editar Cita' : 'Crear Cita' }}
    </h1>
    <a href="{{ route('admin.citas.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
      Volver al listado
    </a>
  </div>

  <form
    action="{{ $isEdit
        ? route('admin.citas.update', $cita)
        : route('admin.citas.store') }}"
    method="POST"
    class="space-y-6"
  >
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div>
      <label for="fecha" class="block text-gray-300 mb-1">Fecha</label>
      <input type="date" name="fecha" id="fecha"
             value="{{ old('fecha', $cita->fecha ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      @error('fecha') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="hora" class="block text-gray-300 mb-1">Hora</label>
      <input type="time" name="hora" id="hora"
             value="{{ old('hora', $cita->hora ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      @error('hora') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="id_usuario" class="block text-gray-300 mb-1">Cliente</label>
      <select name="id_usuario" id="id_usuario"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un cliente</option>
        @foreach($usuarios as $id => $nombre)
          <option value="{{ $id }}"
                  @selected(old('id_usuario', $cita->id_usuario ?? '') == $id)>
            {{ $nombre }}
          </option>
        @endforeach
      </select>
      @error('id_usuario') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="id_servicio" class="block text-gray-300 mb-1">Servicio</label>
      <select name="id_servicio" id="id_servicio"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un servicio</option>
        @foreach($servicios as $id => $nombre)
          <option value="{{ $id }}"
                  @selected(old('id_servicio', $cita->id_servicio ?? '') == $id)>
            {{ $nombre }}
          </option>
        @endforeach
      </select>
      @error('id_servicio') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="id_empleado" class="block text-gray-300 mb-1">Empleado</label>
      <select name="id_empleado" id="id_empleado"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>Selecciona un empleado</option>
        @foreach($empleados as $id => $nombre)
          <option value="{{ $id }}"
                  @selected(old('id_empleado', $cita->id_empleado ?? '') == $id)>
            {{ $nombre }}
          </option>
        @endforeach
      </select>
      @error('id_empleado') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-700">
      <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
        {{ $isEdit ? 'Actualizar' : 'Crear' }}
      </button>
    </div>
  </form>
</div>
@endsection
