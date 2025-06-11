@extends('layouts.app')

@section('title', __('admin.dashboard.title'))

@section('content')
<div class="container mx-auto p-4">
  @php
    $locale = app()->getLocale();
    $other  = $locale === 'es' ? 'en' : 'es';
    $label  = $other === 'es' ? 'Español' : 'English';
  @endphp

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">{{ __('admin.dashboard.title') }}</h1>

    <div class="flex space-x-2">
      {{-- Botón Cambiar Idioma --}}
      <a href="{{ route('lang.switch', $other) }}"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded text-sm">
        {{ $label }}
      </a>

      {{-- Botón Cerrar Sesión --}}
      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button
          type="submit"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded text-sm"
        >
          {{ __('admin.dashboard.logout') }}
        </button>
      </form>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    {{-- Usuarios --}}
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2">{{ __('admin.dashboard.users.label') }}</h2>
      <a href="{{ route('admin.usuarios.index') }}" class="block mb-1 text-blue-600 hover:underline">
        {{ __('admin.dashboard.users.view_all') }}
      </a>
      <a href="{{ route('admin.usuarios.create') }}" class="block text-green-600 hover:underline">
        {{ __('admin.dashboard.users.create_new') }}
      </a>
    </div>

    {{-- Salones --}}
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2">{{ __('admin.dashboard.salons.label') }}</h2>
      <a href="{{ route('admin.salones.index') }}" class="block mb-1 text-blue-600 hover:underline">
        {{ __('admin.dashboard.salons.view_all') }}
      </a>
      <a href="{{ route('admin.salones.create') }}" class="block text-green-600 hover:underline">
        {{ __('admin.dashboard.salons.create_new') }}
      </a>
    </div>

    {{-- Servicios --}}
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2">{{ __('admin.dashboard.services.label') }}</h2>
      <a href="{{ route('admin.servicios.index') }}" class="block mb-1 text-blue-600 hover:underline">
        {{ __('admin.dashboard.services.view_all') }}
      </a>
      <a href="{{ route('admin.servicios.create') }}" class="block text-green-600 hover:underline">
        {{ __('admin.dashboard.services.create_new') }}
      </a>
    </div>

    {{-- Empleados --}}
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2">{{ __('admin.dashboard.employees.label') }}</h2>
      <a href="{{ route('admin.empleados.index') }}" class="block mb-1 text-blue-600 hover:underline">
        {{ __('admin.dashboard.employees.view_all') }}
      </a>
      <a href="{{ route('admin.empleados.create') }}" class="block text-green-600 hover:underline">
        {{ __('admin.dashboard.employees.create_new') }}
      </a>
    </div>

    {{-- Citas --}}
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2">{{ __('admin.dashboard.appointments.label') }}</h2>
      <a href="{{ route('admin.citas.index') }}" class="block mb-1 text-blue-600 hover:underline">
        {{ __('admin.dashboard.appointments.view_all') }}
      </a>
      <a href="{{ route('admin.citas.create') }}" class="block text-green-600 hover:underline">
        {{ __('admin.dashboard.appointments.create_new') }}
      </a>
    </div>

    {{-- Reseñas --}}
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-2">{{ __('admin.dashboard.reviews.label') }}</h2>
      <a href="{{ route('admin.resenas.index') }}" class="block mb-1 text-blue-600 hover:underline">
        {{ __('admin.dashboard.reviews.view_all') }}
      </a>
      <a href="{{ route('admin.resenas.create') }}" class="block text-green-600 hover:underline">
        {{ __('admin.dashboard.reviews.create_new') }}
      </a>
    </div>
  </div>
</div>
@endsection
