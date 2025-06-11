@php $isEdit = isset($resena); @endphp

@extends('layouts.app')

@section('title', $isEdit
    ? __('admin.review_form.title_edit')
    : __('admin.review_form.title_create')
)

@section('content')
<div class="p-6 bg-gray-800 rounded-lg shadow-md">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-white">
      {{ $isEdit
          ? __('admin.review_form.title_edit')
          : __('admin.review_form.title_create') }}
    </h1>
    <a href="{{ route('admin.resenas.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
      {{ __('admin.review_form.back_to_list') }}
    </a>
  </div>

  <form
    action="{{ $isEdit
        ? route('admin.resenas.update', $resena)
        : route('admin.resenas.store') }}"
    method="POST"
    class="space-y-6"
  >
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div>
      <label for="id_usuario" class="block text-gray-300 mb-1">
        {{ __('admin.review_form.user') }}
      </label>
      <select id="id_usuario" name="id_usuario"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>
          {{ __('admin.review_form.select_user') }}
        </option>
        @foreach($usuarios as $id => $nombre)
          <option value="{{ $id }}"
                  @selected(old('id_usuario', $resena->id_usuario ?? '') == $id)>
            {{ $nombre }}
          </option>
        @endforeach
      </select>
      @error('id_usuario') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="id_servicio" class="block text-gray-300 mb-1">
        {{ __('admin.review_form.service') }}
      </label>
      <select id="id_servicio" name="id_servicio"
              class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
              required>
        <option value="" disabled>
          {{ __('admin.review_form.select_service') }}
        </option>
        @foreach($servicios as $id => $nombre)
          <option value="{{ $id }}"
                  @selected(old('id_servicio', $resena->id_servicio ?? '') == $id)>
            {{ $nombre }}
          </option>
        @endforeach
      </select>
      @error('id_servicio') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="valoracion" class="block text-gray-300 mb-1">
        {{ __('admin.review_form.rating') }}
      </label>
      <input type="number" name="valoracion" id="valoracion" min="1" max="5"
             value="{{ old('valoracion', $resena->valoracion ?? '') }}"
             class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2"
             required>
      @error('valoracion') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="comentario" class="block text-gray-300 mb-1">
        {{ __('admin.review_form.comment') }}
      </label>
      <textarea name="comentario" id="comentario" rows="4"
                class="w-full bg-gray-900 text-white border border-gray-700 rounded px-3 py-2">{{ old('comentario', $resena->comentario ?? '') }}</textarea>
      @error('comentario') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-700">
      <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
        {{ $isEdit ? __('admin.review_form.update') : __('admin.review_form.save') }}
      </button>
    </div>
  </form>
</div>
@endsection
