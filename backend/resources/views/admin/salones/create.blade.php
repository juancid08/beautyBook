{{-- resources/views/admin/salones/create.blade.php --}}
@extends('layouts.app')

@section('title', __('admin.salon_form.title_create'))

@section('content')
  <div class="px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-100">
        {{ __('admin.salon_form.title_create') }}
      </h1>
      <a href="{{ route('admin.salones.index') }}"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
        {{ __('admin.salon_form.back_to_list') }}
      </a>
    </div>

    <form action="{{ route('admin.salones.store') }}"
          method="POST" enctype="multipart/form-data"
          class="space-y-6 bg-gray-900 p-6 rounded shadow">
      @csrf

      <div>
        <label for="nombre" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.name') }}
        </label>
        <input id="nombre" name="nombre" type="text"
               value="{{ old('nombre') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label for="direccion" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.address') }}
        </label>
        <input id="direccion" name="direccion" type="text"
               value="{{ old('direccion') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        @error('direccion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label for="telefono" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.phone') }}
        </label>
        <input id="telefono" name="telefono" type="text"
               value="{{ old('telefono') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        @error('telefono') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="horario_apertura" class="block text-gray-300 mb-1">
            {{ __('admin.salon_form.opening') }}
          </label>
          <input id="horario_apertura" name="horario_apertura" type="time"
                 value="{{ old('horario_apertura') }}"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          @error('horario_apertura') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="horario_cierre" class="block text-gray-300 mb-1">
            {{ __('admin.salon_form.closing') }}
          </label>
          <input id="horario_cierre" name="horario_cierre" type="time"
                 value="{{ old('horario_cierre') }}"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          @error('horario_cierre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <div>
        <label for="descripcion" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.description') }}
        </label>
        <textarea id="descripcion" name="descripcion" rows="4"
                  class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded resize-none">{{ old('descripcion') }}</textarea>
        @error('descripcion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label for="especializacion" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.specialization') }}
        </label>
        <input id="especializacion" name="especializacion" type="text"
               value="{{ old('especializacion') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        @error('especializacion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label for="foto" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.photo') }}
        </label>
        <input id="foto" name="foto" type="file"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        @error('foto') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label for="id_usuario" class="block text-gray-300 mb-1">
          {{ __('admin.salon_form.owner') }}
        </label>
        <select id="id_usuario" name="id_usuario"
                class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                required>
          <option value="" disabled selected>
            {{ __('admin.salon_form.select_owner') }}
          </option>
          @foreach($usuarios as $id => $nombre)
            <option value="{{ $id }}" @selected(old('id_usuario')==$id)>
              {{ $nombre }}
            </option>
          @endforeach
        </select>
        @error('id_usuario') <p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700">
        <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
          {{ __('admin.salon_form.save') }}
        </button>
      </div>
    </form>
  </div>
@endsection
