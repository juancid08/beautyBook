{{-- resources/views/admin/resenas/index.blade.php --}}
@extends('layouts.app')

@section('title', __('admin.reviews.title'))

@section('content')
  <div class="px-4 sm:px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row items-start sm:items-center 
                justify-between mb-4 space-y-2 sm:space-y-0">
      <h1 class="text-2xl font-semibold text-gray-100">
        {{ __('admin.reviews.header') }}
      </h1>
      <div class="flex space-x-2">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 
                  text-white font-medium rounded text-sm">
          {{ __('admin.reviews.back_dashboard') }}
        </a>
        <a href="{{ route('admin.resenas.create') }}"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 
                  text-white font-medium rounded text-sm">
          {{ __('admin.reviews.create') }}
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-700 text-green-100 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto">
      {{-- Tabla para md+ --}}
      <table class="min-w-full divide-y divide-gray-700 hidden md:table">
        <thead class="bg-gray-900">
          <tr>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.reviews.user') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.reviews.service') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.reviews.rating') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.reviews.comment') }}
            </th>
            <th class="px-4 py-2 text-center text-gray-300 uppercase text-sm">
              {{ __('admin.reviews.actions') }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-gray-800 divide-y divide-gray-700">
          @forelse($resenas as $resena)
            <tr class="@if($loop->even) bg-gray-700 @endif">
              <td class="px-4 py-3 text-gray-200">
                {{ optional($resena->usuario)->nombre ?? '—' }}
              </td>
              <td class="px-4 py-3 text-gray-200">
                {{ optional($resena->servicio)->nombre ?? '—' }}
              </td>
              <td class="px-4 py-3 text-gray-200">
                {{ $resena->calificacion }}/5
              </td>
              <td class="px-4 py-3 text-gray-200">
                {{ \Illuminate\Support\Str::limit($resena->comentario, 50) }}
              </td>
              <td class="px-4 py-3 text-center space-x-2">
                <a href="{{ route('admin.resenas.edit', $resena) }}"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                  {{ __('admin.reviews.edit') }}
                </a>
                <form action="{{ route('admin.resenas.destroy', $resena) }}"
                      method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('{{ __('admin.reviews.confirm_delete') }}')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    {{ __('admin.reviews.delete') }}
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                {{ __('admin.reviews.no_records') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{-- Tarjetas para móvil --}}
      <div class="space-y-4 md:hidden">
        @forelse($resenas as $resena)
          <div class="bg-gray-900 p-4 rounded shadow">
            <div class="space-y-2">
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.reviews.user') }}:</span>
                {{ optional($resena->usuario)->nombre ?? '—' }}
              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.reviews.service') }}:</span>
                {{ optional($resena->servicio)->nombre ?? '—' }}
              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.reviews.rating') }}:</span>
                {{ $resena->calificacion }}/5
              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.reviews.comment') }}:</span>
                {{ \Illuminate\Support\Str::limit($resena->comentario, 100) }}
              </p>
              <div class="flex space-x-2 pt-2">
                <a href="{{ route('admin.resenas.edit', $resena) }}"
                   class="flex-1 text-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">
                  {{ __('admin.reviews.edit') }}
                </a>
                <form action="{{ route('admin.resenas.destroy', $resena) }}"
                      method="POST" class="flex-1">
                  @csrf @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('{{ __('admin.reviews.confirm_delete') }}')"
                          class="w-full px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                    {{ __('admin.reviews.delete') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-400">
            {{ __('admin.reviews.no_records') }}
          </p>
        @endforelse
      </div>
    </div>
  </div>
@endsection
