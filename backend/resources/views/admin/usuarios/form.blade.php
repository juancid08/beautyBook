@php $isEdit = isset($usuario); @endphp

@extends('layouts.app')

@section('title', $isEdit
    ? __('admin.form.title_edit')
    : __('admin.form.title_create')
)

@section('content')
  <div class="px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-100">
        {{ $isEdit
            ? __('admin.form.title_edit')
            : __('admin.form.title_create') }}
      </h1>
      <a href="{{ route('admin.usuarios.index') }}"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
        {{ __('admin.form.back_to_list') }}
      </a>
    </div>

    <form action="{{ $isEdit
         ? route('admin.usuarios.update', $usuario)
         : route('admin.usuarios.store') }}"
          method="POST"
          class="space-y-6 bg-gray-900 p-6 rounded shadow">
      @csrf
      @if($isEdit)
        @method('PUT')
      @endif

      <div>
        <label for="nombre"
               class="block text-gray-300 font-medium mb-1">
          {{ __('admin.form.name') }}
        </label>
        <input id="nombre" type="text" name="nombre"
               value="{{ old('nombre', $usuario->nombre ?? '') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        @error('nombre')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="apellidos"
               class="block text-gray-300 font-medium mb-1">
          {{ __('admin.form.last_name') }}
        </label>
        <input id="apellidos" type="text" name="apellidos"
               value="{{ old('apellidos', $usuario->apellidos ?? '') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        @error('apellidos')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="email"
               class="block text-gray-300 font-medium mb-1">
          {{ __('admin.form.email') }}
        </label>
        <input id="email" type="email" name="email"
               value="{{ old('email', $usuario->email ?? '') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
               required>
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="telefono"
               class="block text-gray-300 font-medium mb-1">
          {{ __('admin.form.phone') }}
        </label>
        <input id="telefono" type="text" name="telefono"
               value="{{ old('telefono', $usuario->telefono ?? '') }}"
               class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
        @error('telefono')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="rol"
               class="block text-gray-300 font-medium mb-1">
          {{ __('admin.form.role') }}
        </label>
        <select id="rol" name="rol"
                class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded">
          <option value="cliente"
            @selected(old('rol', $usuario->rol ?? '')=='cliente')>
            {{ __('admin.form.role_client') }}
          </option>
          <option value="administrador"
            @selected(old('rol', $usuario->rol ?? '')=='administrador')>
            {{ __('admin.form.role_admin') }}
          </option>
        </select>
        @error('rol')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      @unless($isEdit)
        <div>
          <label for="password"
                 class="block text-gray-300 font-medium mb-1">
            {{ __('admin.form.password') }}
          </label>
          <input id="password" type="password" name="password"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password_confirmation"
                 class="block text-gray-300 font-medium mb-1">
            {{ __('admin.form.password_confirmation') }}
          </label>
          <input id="password_confirmation" type="password" name="password_confirmation"
                 class="w-full bg-gray-800 border border-gray-700 text-gray-100 p-2 rounded"
                 required>
          @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      @endunless

      <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700">
        <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded">
          {{ $isEdit ? __('admin.form.update') : __('admin.form.save') }}
        </button>
      </div>
    </form>
  </div>
@endsection
