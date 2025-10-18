<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiRest - Sistema de Gestión para Restaurantes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    {{-- @vite('resources/css/app.css') --}}
</head>
<body class="antialiased bg-slate-50 text-slate-800">

    <div class="flex flex-col min-h-screen">
        <!-- Navegación -->
        <header class="w-full bg-slate-50">
            <!-- 
            <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-slate-900">
                    🍽️ DigiRest
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">
                       Ir al Panel
                    </a>
                @endauth
            </nav>
            -->
        </header>

        <!-- HERO SECTION -->
        <div class="flex-grow md:flex">
            <!-- Columna de Contenido (Izquierda) -->
            <main class="w-full md:w-1/2 flex items-center justify-center bg-slate-50">
                <div class="max-w-xl p-8 text-center md:text-left">
                    <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">Gestión Inteligente</span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-2 mb-4 leading-tight">
                        Optimiza tu restaurante, simplifica tu día
                    </h1>
                    <p class="text-lg text-slate-600 mb-8">
                        Administra mesas, pedidos y reservas con una herramienta diseñada para la eficiencia. DigiRest te da el control total con transparencia y rapidez.
                    </p>
                    @guest
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="{{ route('register') }}" 
                           class="inline-block px-8 py-3 font-semibold text-white bg-indigo-600 rounded-lg shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">
                           Empezar Ahora
                        </a>
                        <a href="{{ route('login') }}" 
                           class="inline-block px-8 py-3 font-semibold text-slate-700 bg-slate-200 rounded-lg hover:bg-slate-300 transition">
                           Iniciar Sesión
                        </a>
                    </div>
                    @endguest
                </div>
            </main>

            <!-- Columna de Imagen (Derecha) -->
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" 
                 style="background-image: url('{{ asset('images/welcome2.jpg') }}')">
                {{-- Asegúrate de que tu imagen 'image_7d3182.png' se encuentre en la carpeta 'public/images' de tu proyecto Laravel. --}}
            </div>
        </div>
    </div>

    <!-- SECCIÓN DE CARACTERÍSTICAS -->
    <section id="features" class="bg-white py-20 md:py-24">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900">Todo lo que necesitas en un solo lugar</h2>
                <p class="mt-2 text-slate-600 max-w-2xl mx-auto">
                    Desde la reserva hasta el pago, DigiRest cubre cada paso de la experiencia de tus clientes.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Característica 1 -->
                <div class="p-8 bg-slate-50 rounded-lg text-center">
                     <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Gestión de Mesas</h3>
                    <p class="text-slate-600">Visualiza el estado de cada mesa en tiempo real. Asigna, combina y libera mesas con un solo clic.</p>
                </div>
                <!-- Característica 2 -->
                <div class="p-8 bg-slate-50 rounded-lg text-center">
                    <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Toma de Pedidos Digital</h3>
                    <p class="text-slate-600">Los camareros pueden tomar pedidos directamente desde una tablet, enviándolos al instante a la cocina.</p>
                </div>
                <!-- Característica 3 -->
                <div class="p-8 bg-slate-50 rounded-lg text-center">
                   <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                   </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Administración de Reservas</h3>
                    <p class="text-slate-600">Gestiona las reservas online y telefónicas desde un calendario intuitivo y fácil de usar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-100 border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-6 py-4 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} DigiRest. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>

