{{-- resources/views/admin/servicios/create.blade.php --}}
@extends('layouts.app')

@section('title', __('admin.service_form.title_create'))

@section('content')
  <div class="p-6 bg-gray-800 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold text-white">{{ __('admin.service_form.title_create') }}</h1>
      <a href="{{ route('admin.servicios.index') }}"
         class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
        {{ __('admin.service_form.back_to_list') }}
      </a>
    </div>

    <form action="{{ route('admin.servicios.store') }}"
          method="POST"
          class="space-y-6">
      @csrf

      <div>
        <label for="nombre" class="block text-gray-300 mb-1">
          {{ __('admin.service_form.name') }}
        </label>
        <input type="text" name="nombre" id="nombre"
               value="{{ old('nombre') }}"
               class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
               required>
        @error('nombre')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="descripcion" class="block text-gray-300 mb-1">
          {{ __('admin.service_form.description') }}
        </label>
        <textarea name="descripcion" id="descripcion" rows="4"
                  class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2">{{ old('descripcion') }}</textarea>
        @error('descripcion')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="precio" class="block text-gray-300 mb-1">
          {{ __('admin.service_form.price') }}
        </label>
        <input type="number" step="0.01" name="precio" id="precio"
               value="{{ old('precio') }}"
               class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
               required>
        @error('precio')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="id_salon" class="block text-gray-300 mb-1">
          {{ __('admin.service_form.salon') }}
        </label>
        <select name="id_salon" id="id_salon"
                class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
                required>
          <option value="" disabled selected>
            {{ __('admin.service_form.select_salon') }}
          </option>
          @foreach($salones as $id => $nombre)
            <option value="{{ $id }}"
                    @selected(old('id_salon') == $id)>
              {{ $nombre }}
            </option>
          @endforeach
        </select>
        @error('id_salon')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end pt-4 border-t border-gray-700">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
          {{ __('admin.service_form.save') }}
        </button>
      </div>
    </form>
  </div>
@endsection
