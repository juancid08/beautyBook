@extends('layouts.app')

@section('title', 'Listado de Citas')

@section('content')
  <div class="px-4 sm:px-6 py-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 space-y-2 sm:space-y-0">
      <h1 class="text-2xl font-semibold text-gray-100">Citas</h1>
      <div class="flex space-x-2">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded text-sm">
          Volver al Dashboard
        </a>
        <a href="{{ route('admin.citas.create') }}"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded text-sm">
          Crear cita
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-700 text-green-100 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto">
      {{-- Vista de tabla para pantallas medianas en adelante --}}
      <table class="min-w-full divide-y divide-gray-700 hidden md:table">
        <thead class="bg-gray-900">
          <tr>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">ID</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Fecha</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Hora</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Usuario</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Servicio</th>
            <th class="px-4 py-2 text-left text-gray-300 uppercase text-sm">Empleado</th>
            <th class="px-4 py-2 text-center text-gray-300 uppercase text-sm">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-gray-800 divide-y divide-gray-700">
          @forelse($citas as $cita)
            <tr class="@if($loop->even) bg-gray-700 @endif">
              <td class="px-4 py-3 text-gray-200">{{ $cita->id }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $cita->fecha }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $cita->hora }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $cita->usuario->nombre ?? '—' }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $cita->servicio->nombre ?? '—' }}</td>
              <td class="px-4 py-3 text-gray-200">{{ $cita->empleado->nombre ?? '—' }}</td>
              <td class="px-4 py-3 text-center space-x-2">
                <a href="{{ route('admin.citas.edit', $cita) }}"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                  Editar
                </a>
                <form action="{{ route('admin.citas.destroy', $cita) }}"
                      method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('¿Seguro que deseas eliminar esta cita?')"
                          class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    Eliminar
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-4 py-4 text-center text-gray-400">
                No hay citas registradas.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{-- Vista en tarjetas para móviles --}}
      <div class="space-y-4 md:hidden">
        @forelse($citas as $cita)
          <div class="bg-gray-900 p-4 rounded shadow">
            <div class="space-y-2">
              <p class="text-gray-300 text-sm"><span class="font-semibold">ID:</span> {{ $cita->id }}</p>
              <p class="text-gray-200 font-medium">{{ $cita->fecha }} a las {{ $cita->hora }}</p>
              <p class="text-gray-300 text-sm"><span class="font-semibold">Usuario:</span> {{ $cita->usuario->nombre ?? '—' }}</p>
              <p class="text-gray-300 text-sm"><span class="font-semibold">Servicio:</span> {{ $cita->servicio->nombre ?? '—' }}</p>
              <p class="text-gray-300 text-sm"><span class="font-semibold">Empleado:</span> {{ $cita->empleado->nombre ?? '—' }}</p>
            </div>
            <div class="flex justify-end mt-3 space-x-2">
              <a href="{{ route('admin.citas.edit', $cita) }}"
                 class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs text-center">
                Editar
              </a>
              <form action="{{ route('admin.citas.destroy', $cita) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Seguro que deseas eliminar esta cita?')"
                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                  Eliminar
                </button>
              </form>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-400">No hay citas registradas.</p>
        @endforelse
      </div>
    </div>
  </div>
@endsection
