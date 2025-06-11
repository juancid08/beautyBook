{{-- resources/views/admin/empleados/index.blade.php --}}
@extends('layouts.app')

@section('title', __('admin.employees.title'))

@section('content')
  <div class="px-4 sm:px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row items-start sm:items-center
                justify-between mb-4 space-y-2 sm:space-y-0">
      <h1 class="text-2xl font-semibold text-gray-100">
        {{ __('admin.employees.header') }}
      </h1>
      <div class="flex space-x-2">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700
                  text-white font-medium rounded text-sm">
          {{ __('admin.employees.back_dashboard') }}
        </a>
        <a href="{{ route('admin.empleados.create') }}"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700
                  text-white font-medium rounded text-sm">
          {{ __('admin.employees.create') }}
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
              {{ __('admin.employees.name') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.employees.phone') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.employees.email') }}
            </th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">
              {{ __('admin.employees.salon') }}
            </th>
            <th class="px-4 py-2 text-center text-gray-300 uppercase text-sm">
              {{ __('admin.employees.actions') }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-gray-800 divide-y divide-gray-700">
          @forelse($empleados as $empleado)
            <tr class="@if($loop->even) bg-gray-700 @endif">
              <td class="px-4 py-3 text-gray-200">
                {{ $empleado->nombre }} {{ $empleado->apellidos }}
              </td>
              <td class="px-4 py-3 text-gray-200">
                {{ $empleado->telefono ?? '—' }}
              </td>
              <td class="px-4 py-3 text-gray-200">
                {{ $empleado->email ?? '—' }}
              </td>
              <td class="px-4 py-3 text-gray-200">
                {{ optional($empleado->salon)->nombre ?? '—' }}
              </td>
              <td class="px-4 py-3 text-center space-x-2">
                <a href="{{ route('admin.empleados.edit', $empleado) }}"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700
                          text-white rounded text-sm">
                  {{ __('admin.employees.edit') }}
                </a>
                <form action="{{ route('admin.empleados.destroy', $empleado) }}"
                      method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('{{ __('admin.employees.confirm_delete') }}')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    {{ __('admin.employees.delete') }}
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                {{ __('admin.employees.no_records') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{-- Mobile cards --}}
      <div class="space-y-4 md:hidden">
        @forelse($empleados as $empleado)
          <div class="bg-gray-900 p-4 rounded shadow">
            <div class="space-y-2">
              <p class="text-gray-200 font-medium">
                {{ $empleado->nombre }} {{ $empleado->apellidos }}
              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.employees.phone') }}:</span>
                {{ $empleado->telefono ?? '—' }}
              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.employees.email') }}:</span>
                {{ $empleado->email ?? '—' }}
              </p>
              <p class="text-gray-300 text-sm">
                <span class="font-semibold">{{ __('admin.employees.salon') }}:</span>
                {{ optional($empleado->salon)->nombre ?? '—' }}
              </p>
              <div class="flex space-x-2 pt-2">
                <a href="{{ route('admin.empleados.edit', $empleado) }}"
                   class="flex-1 text-center px-3 py-1 bg-blue-600 hover:bg-blue-700
                          text-white rounded text-xs">
                  {{ __('admin.employees.edit') }}
                </a>
                <form action="{{ route('admin.empleados.destroy', $empleado) }}"
                      method="POST" class="flex-1">
                  @csrf @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('{{ __('admin.employees.confirm_delete') }}')"
                          class="w-full px-3 py-1 bg-red-600 hover:bg-red-700
                                 text-white rounded text-xs">
                    {{ __('admin.employees.delete') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-400">
            {{ __('admin.employees.no_records') }}
          </p>
        @endforelse
      </div>
    </div>
  </div>
@endsection
