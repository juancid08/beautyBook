{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>

  {{-- Carga tu CSS de Tailwind/JS compilados por Vite --}}
  @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-100 text-gray-800">

  <main class="container mx-auto py-6">
    @yield('content')
  </main>

  @vite('resources/js/app.js')
</body>
</html>
