<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu | DigiRest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="bg-gradient-to-b from-slate-50 via-white to-indigo-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-indigo-100 bg-white/90 backdrop-blur">
            <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 text-xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-white">DR</span>
                    Digi<span class="text-indigo-600">Rest</span>
                </a>
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('menu.domicilio') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Pedir domicilio</a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">Acceder</a>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-6 py-14 grid lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-4">
                    <p class="text-xs font-semibold tracking-[0.28em] text-indigo-600 uppercase">Carta principal</p>
                    <h1 class="text-4xl font-bold leading-tight text-slate-900">Sabores listos para la mesa</h1>
                    <p class="text-lg text-slate-700">Explora nuestras comidas y bebidas con fotos reales y disponibilidad al momento.</p>
                    <div class="flex flex-wrap gap-3 text-sm">
                        <a href="{{ route('menu.domicilio') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 text-white px-4 py-2 shadow hover:bg-indigo-700">Pedir domicilio</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-slate-700 hover:border-indigo-200 hover:text-indigo-700">Entrar</a>
                    </div>
                </div>
                <div class="rounded-3xl border border-indigo-100 bg-white shadow-xl p-6 space-y-3">
                    <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-sky-500 text-white p-5 shadow">
                        <p class="text-xs uppercase tracking-[0.2em] opacity-90">Destacado</p>
                        <h3 class="text-2xl font-bold mt-1">Menú creativo y fresco</h3>
                        <p class="text-sm opacity-90 mt-2">Sabores de temporada, ingredientes frescos y preparaciones al momento.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-xl bg-slate-50 border border-indigo-50 p-4">
                            <p class="text-xs text-indigo-600 uppercase tracking-[0.2em]">Para compartir</p>
                            <p class="mt-2 text-slate-900 font-semibold">Combos y tablas</p>
                        </div>
                        <div class="rounded-xl bg-sky-50 border border-sky-100 p-4">
                            <p class="text-xs text-sky-700 uppercase tracking-[0.2em]">Bebidas</p>
                            <p class="mt-2 text-slate-900 font-semibold">Mocktails y cafés</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="max-w-6xl mx-auto px-6 pb-10">
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-3xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-sky-500 text-white p-6 shadow-xl">
                        <p class="text-xs uppercase tracking-[0.2em] opacity-80">Promo del dia</p>
                        <h3 class="mt-2 text-2xl font-bold">2x1 en bebidas artesanales</h3>
                        <p class="mt-2 text-sm opacity-90">Elige cualquier bebida y la segunda es gratis. Solo hoy hasta agotar existencia.</p>
                        <a href="{{ route('menu.domicilio') }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-white/90 px-4 py-2 text-sm font-semibold text-indigo-800 hover:bg-white">Pedir ahora</a>
                    </div>
                    <div class="rounded-3xl bg-white border border-indigo-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-indigo-600 uppercase tracking-[0.2em]">Combo casa</p>
                                <h3 class="text-xl font-bold text-slate-900">Plato fuerte + bebida</h3>
                                <p class="text-sm text-slate-600 mt-1">Ahorra 15% combinando tus favoritos.</p>
                            </div>
                            <div class="h-14 w-14 rounded-full bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-lg">-15%</div>
                        </div>
                        <a href="{{ route('menu.domicilio') }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Armar combo</a>
                    </div>
                </div>
            </section>

            <section class="max-w-6xl mx-auto px-6 pb-14 space-y-8">
                <div class="rounded-3xl border border-indigo-100 bg-white shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900">Comidas</h2>
                        <span class="text-xs rounded-full bg-indigo-100 px-3 py-1 text-indigo-700">{{ $comidas->count() }}</span>
                    </div>
                    @if($comidas->isEmpty())
                        <div class="text-sm text-gray-500">No hay comidas configuradas.</div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($comidas as $prod)
                                <div class="rounded-2xl border border-indigo-100 p-3 hover:shadow-lg transition bg-white flex flex-col gap-2">
                                    <div class="h-40 w-full overflow-hidden rounded-xl bg-indigo-50 flex items-center justify-center">
                                        @if ($prod->imagen)
                                            <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">Sin imagen</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                                        <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                                        <div class="text-sm font-bold text-indigo-600">${{ number_format($prod->precio, 0, ',', '.') }}</div>
                                        <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                                    </div>
                                    <a href="{{ route('menu.domicilio') }}" class="mt-auto inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">Agregar al pedido</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-3xl border border-indigo-100 bg-white shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900">Bebidas</h2>
                        <span class="text-xs rounded-full bg-indigo-100 px-3 py-1 text-indigo-700">{{ $bebidas->count() }}</span>
                    </div>
                    @if($bebidas->isEmpty())
                        <div class="text-sm text-gray-500">No hay bebidas configuradas.</div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($bebidas as $prod)
                                <div class="rounded-2xl border border-indigo-100 p-3 hover:shadow-lg transition bg-white flex flex-col gap-2">
                                    <div class="h-40 w-full overflow-hidden rounded-xl bg-indigo-50 flex items-center justify-center">
                                        @if ($prod->imagen)
                                            <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">Sin imagen</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                                        <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                                        <div class="text-sm font-bold text-indigo-600">${{ number_format($prod->precio, 0, ',', '.') }}</div>
                                        <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                                    </div>
                                    <a href="{{ route('menu.domicilio') }}" class="mt-auto inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">Agregar al pedido</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>
</body>
</html>
