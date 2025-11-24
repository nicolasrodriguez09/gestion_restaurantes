<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiRest — Operación gastronómica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-slate-100 bg-white/90 backdrop-blur">
            <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 text-xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-white">DR</span>
                    Digi<span class="text-indigo-600">Rest</span>
                </a>
                <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                    <a href="#panorama" class="hover:text-indigo-600">Panorama</a>
                    <a href="#flujos" class="hover:text-indigo-600">Flujos</a>
                    <a href="#tecnologia" class="hover:text-indigo-600">Tecnologia</a>
                </div>
                <div class="flex items-center gap-3 text-sm font-semibold">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-full border border-slate-200 hover:border-indigo-200 hover:text-indigo-700">Entrar al panel</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-full border border-slate-200 hover:border-indigo-200 hover:text-indigo-700">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-indigo-600 text-white shadow hover:bg-indigo-700">Registrar</a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-6 py-16 grid lg:grid-cols-2 gap-12 items-center" id="panorama">
                <div class="space-y-4">
                    <p class="text-xs font-semibold tracking-[0.28em] text-indigo-600 uppercase">Operación diaria</p>
                    <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight">Una vista clara de sala, cocina y gestión.</h1>
                    <p class="text-lg text-slate-600">DigiRest centraliza pedidos, mesas y productos para que el equipo ejecute con precisión y el administrador tenga trazabilidad completa.</p>
                    <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1"><span class="h-2 w-2 rounded-full bg-emerald-500"></span>Estado de mesas</span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1"><span class="h-2 w-2 rounded-full bg-indigo-500"></span>Flujo de cocina</span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1"><span class="h-2 w-2 rounded-full bg-amber-500"></span>Inventario y precios</span>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-slate-900/5 bg-white">
                        <img src="{{ asset('images/welcome2.jpg') }}" alt="Panel DigiRest" class="w-full h-full object-cover">
                    </div>
                </div>
            </section>

            <section class="border-t border-slate-100 bg-white" id="flujos">
                <div class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-6">
                    <article class="rounded-2xl border border-slate-100 bg-slate-50/70 p-5">
                        <p class="text-sm font-semibold text-slate-700">Mesas y reservas</p>
                        <p class="mt-2 text-sm text-slate-600">Estados en vivo, reasignaciones rápidas y control de capacidad por zona.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-100 bg-slate-50/70 p-5">
                        <p class="text-sm font-semibold text-slate-700">Cocina y pases</p>
                        <p class="mt-2 text-sm text-slate-600">Pedidos por fase: espera, en proceso, listos y entregados con trazabilidad.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-100 bg-slate-50/70 p-5">
                        <p class="text-sm font-semibold text-slate-700">Carta y stock</p>
                        <p class="mt-2 text-sm text-slate-600">Productos con imágenes, disponibilidad por unidad y actualización rápida de precios.</p>
                    </article>
                </div>
            </section>

            <section class="bg-slate-950 text-slate-100 py-14" id="tecnologia">
                <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
                    <div class="space-y-3">
                        <p class="text-sm font-semibold tracking-[0.24em] text-slate-400 uppercase">Tecnologia</p>
                        <h2 class="text-3xl font-bold">Laravel + Tailwind + Panel roles</h2>
                        <p class="text-sm text-slate-300">Autenticación por rol (admin, mesero), panel de cocina con cambio de estados y control de stock al pasar a proceso.</p>
                        <p class="text-sm text-slate-300">Modulos de productos, mesas, meseros y flujo de pedidos listos/entregados.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <ul class="space-y-3 text-sm text-slate-200">
                            <li>&bull; Gestión de mesas con estados libres/ocupadas</li>
                            <li>&bull; Pedidos con imágenes de producto y stock por unidad</li>
                            <li>&bull; Cocina: espera, proceso, listos, entregados</li>
                            <li>&bull; Administración de meseros y trazabilidad de pedidos</li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-white border-t border-slate-100">
            <div class="max-w-6xl mx-auto px-6 py-6 flex flex-wrap items-center justify-between text-sm text-slate-500">
                <div class="font-semibold text-slate-700">DigiRest</div>
                <div class="flex gap-4">
                    <a href="#panorama" class="hover:text-indigo-600">Panorama</a>
                    <a href="#flujos" class="hover:text-indigo-600">Flujos</a>
                    <a href="#tecnologia" class="hover:text-indigo-600">Tecnologia</a>
                </div>
                <div class="text-xs text-slate-400">&copy; {{ date('Y') }} Operación interna</div>
            </div>
        </footer>
    </div>
</body>
</html>
