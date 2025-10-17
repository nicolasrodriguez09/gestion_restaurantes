<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiRest - Bienvenido</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-100">

    <div class="flex flex-col items-center justify-center min-h-screen text-center px-6">
        <!-- Logo o nombre -->
        <h1 class="text-4xl font-bold text-gray-800 mb-3">🍽️ DigiRest</h1>
        <p class="text-gray-600 mb-8 max-w-md">
            Sistema de gestión de restaurante — administra mesas, pedidos y reservas con transparencia y rapidez.
        </p>

        <div class="space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" 
                   class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                   Ir al Panel
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                   Iniciar Sesión
                </a>

                <a href="{{ route('register') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition">
                   Registrarse
                </a>
            @endauth
        </div>

        <footer class="mt-12 text-sm text-gray-500">
            &copy; {{ date('Y') }} DigiRest. Todos los derechos reservados.
        </footer>
    </div>

</body>
</html>
