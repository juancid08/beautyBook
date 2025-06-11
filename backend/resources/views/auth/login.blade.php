<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrador</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">

  <div class="bg-gray-800 p-8 rounded shadow-lg w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Login Administrador</h1>

    @if(session('error'))
      <div class="bg-red-600 text-white p-2 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      <div>
        <label for="email" class="block text-sm mb-1">Email</label>
        <input type="email" name="email" id="email"
               value="{{ old('email') }}"
               required autofocus
               class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring focus:border-blue-500">
        @error('email')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm mb-1">Contraseña</label>
        <input type="password" name="password" id="password"
               required
               class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring focus:border-blue-500">
        @error('password')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
          Entrar
        </button>
      </div>
    </form>
  </div>

</body>
</html>
