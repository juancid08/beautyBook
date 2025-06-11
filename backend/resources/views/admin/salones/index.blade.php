{{-- resources/views/admin/salones/index.blade.php --}}
@extends('layouts.app')

@section('title', __('admin.salons.title'))

@section('content')
  <div class="px-4 sm:px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row items-start sm:items-center 
                justify-between mb-4 space-y-2 sm:space-y-0">
      <h1 class="text-2xl font-semibold text-gray-100">
        {{ __('admin.salons.header') }}
      </h1>
      <div class="flex space-x-2">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 
                  text-white font-medium rounded text-sm">
          {{ __('admin.salons.back_dashboard') }}
        </a>
        <a href="{{ route('admin.salones.create') }}"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 
                  text-white font-medium rounded text-sm">
          {{ __('admin.salons.create') }}
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-700 text-green-100 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto">
      {{-- Desktop table --}}
      <table class="min-w-full divide-y divide-gray-700 hidden md:table">
        <thead class="bg-gray-900">
          <tr>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.salons.id') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.salons.name') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.salons.address') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.salons.phone') }}
            </th>
            <th class="px-4 py-2 text-center text-gray-300 uppercase text-sm">
              {{ __('admin.salons.actions') }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-gray-800 divide-y divide-gray-700">
          @forelse($salones as $salon)
            <tr class="@if($loop->even) bg-gray-700 @endif">
              <td class="px-4 py-3 text-gray-200">{{ $salon->id_salon }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $salon->nombre }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $salon->direccion }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $salon->telefono ?? '—' }}</td>
              <td class="px-4 py-3 text-center space-x-2">
                <a href="{{ route('admin.salones.edit', $salon) }}"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white 
                          rounded text-sm">
                  {{ __('admin.salons.edit') }}
                </a>
                <form action="{{ route('admin.salones.destroy', $salon) }}"
                      method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('{{ __('admin.salons.confirm_delete') }}')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    {{ __('admin.salons.delete') }}
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                {{ __('admin.salons.no_records') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{-- Mobile cards --}}
      <div class="space-y-4 md:hidden">
        @forelse($salones as $salon)
          <div class="bg-gray-900 p-4 rounded shadow">
            <div class="flex justify-between items-start">
              <div class="space-y-1">
                <p class="text-gray-300 text-sm">
                  <span class="font-semibold">{{ __('admin.salons.id') }}:</span>
                  {{ $salon->id_salon }}
                </p>
                <p class="text-gray-200 font-medium">{{ $salon->nombre }}</p>
                <p class="text-gray-300 text-sm">
                  <span class="font-semibold">{{ __('admin.salons.address') }}:</span>
                  {{ $salon->direccion }}
                </p>
                <p class="text-gray-300 text-sm">
                  <span class="font-semibold">{{ __('admin.salons.phone') }}:</span>
                  {{ $salon->telefono ?? '—' }}
                </p>
              </div>
              <div class="flex flex-col space-y-2 ml-4">
                <a href="{{ route('admin.salones.edit', $salon) }}"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs text-center">
                  {{ __('admin.salons.edit') }}
                </a>
                <form action="{{ route('admin.salones.destroy', $salon) }}"
                      method="POST">
                  @csrf @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('{{ __('admin.salons.confirm_delete') }}')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs w-full">
                    {{ __('admin.salons.delete') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-400">{{ __('admin.salons.no_records') }}</p>
        @endforelse
      </div>
    </div>
  </div>
@endsection
