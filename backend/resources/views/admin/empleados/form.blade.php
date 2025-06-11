{{-- resources/views/admin/empleados/form.blade.php --}}
@php $isEdit = isset($empleado); @endphp

@extends('layouts.app')

@section('title', $isEdit
    ? __('admin.employee_form.title_edit')
    : __('admin.employee_form.title_create')
)

@section('content')
<div class="p-6 bg-gray-800 rounded-lg shadow-md">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-white">
      {{ $isEdit
          ? __('admin.employee_form.title_edit')
          : __('admin.employee_form.title_create') }}
    </h1>
    <a href="{{ route('admin.empleados.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
      {{ __('admin.employee_form.back_to_list') }}
    </a>
  </div>

  <form
    action="{{ $isEdit
        ? route('admin.empleados.update', $empleado)
        : route('admin.empleados.store') }}"
    method="POST"
    class="space-y-6"
  >
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div>
      <label for="nombre" class="block text-gray-300 mb-1">
        {{ __('admin.employee_form.name') }}
      </label>
      <input type="text" name="nombre" id="nombre"
             value="{{ old('nombre', $empleado->nombre ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      @error('nombre') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="apellidos" class="block text-gray-300 mb-1">
        {{ __('admin.employee_form.last_name') }}
      </label>
      <input type="text" name="apellidos" id="apellidos"
             value="{{ old('apellidos', $empleado->apellidos ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      @error('apellidos') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="telefono" class="block text-gray-300 mb-1">
        {{ __('admin.employee_form.phone') }}
      </label>
      <input type="text" name="telefono" id="telefono"
             value="{{ old('telefono', $empleado->telefono ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2">
      @error('telefono') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="email" class="block text-gray-300 mb-1">
        {{ __('admin.employee_form.email') }}
      </label>
      <input type="email" name="email" id="email"
             value="{{ old('email', $empleado->email ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2">
      @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="id_salon" class="block text-gray-300 mb-1">
        {{ __('admin.employee_form.salon') }}
      </label>
      <select name="id_salon" id="id_salon"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>
          {{ __('admin.employee_form.select_salon') }}
        </option>
        @foreach($salones as $id => $nombre)
          <option value="{{ $id }}"
                  @selected(old('id_salon', $empleado->id_salon ?? '') == $id)>
            {{ $nombre }}
          </option>
        @endforeach
      </select>
      @error('id_salon') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-700">
      <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
        {{ $isEdit
            ? __('admin.employee_form.update')
            : __('admin.employee_form.save') }}
      </button>
    </div>
  </form>
</div>
@endsection
