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
<body class="bg-gradient-to-b from-orange-50 via-white to-amber-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-orange-100 bg-white/90 backdrop-blur">
            <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 text-xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-orange-500 text-white">DR</span>
                    Digi<span class="text-orange-600">Rest</span>
                </a>
                <div class="hidden md:flex items-center gap-4 text-sm font-semibold">
                    <a href="{{ route('menu') }}" class="px-3 py-1.5 rounded-full bg-orange-100 text-orange-700">Menu</a>
                    <a href="{{ route('menu.domicilio') }}" class="px-3 py-1.5 rounded-full text-slate-700 hover:bg-slate-100">Pedir domicilio</a>
                    <a href="/" class="px-3 py-1.5 rounded-full text-slate-700 hover:bg-slate-100">Inicio</a>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-6 py-14 grid lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-4">
                    <p class="text-xs font-semibold tracking-[0.28em] text-orange-600 uppercase">Carta principal</p>
                    <h1 class="text-4xl font-bold leading-tight text-slate-900">Sabores listos para la mesa</h1>
                    <p class="text-lg text-slate-700">Explora nuestras comidas y bebidas con fotos reales y disponibilidad al momento.</p>
                    <div class="flex flex-wrap gap-3 text-sm">
                        <a href="{{ route('menu.domicilio') }}" class="inline-flex items-center gap-2 rounded-full bg-orange-500 text-white px-4 py-2 shadow hover:bg-orange-600">Pedir domicilio</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-slate-700 hover:border-orange-200 hover:text-orange-700">Entrar</a>
                    </div>
                </div>
                <div class="rounded-3xl border border-orange-100 bg-white shadow-xl p-6 grid grid-cols-2 gap-4 text-sm">
                    <div class="rounded-2xl bg-orange-50 border border-orange-100 p-4">
                        <p class="text-xs text-orange-600">Total items</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $productos->count() }}</p>
                    </div>
                    <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4">
                        <p class="text-xs text-emerald-600">Comidas</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $comidas->count() }}</p>
                    </div>
                    <div class="rounded-2xl bg-indigo-50 border border-indigo-100 p-4">
                        <p class="text-xs text-indigo-600">Bebidas</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $bebidas->count() }}</p>
                    </div>
                    <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4">
                        <p class="text-xs text-amber-600">Domicilio</p>
                        <p class="text-sm font-semibold text-slate-900">Entrega a cocina</p>
                    </div>
                </div>
            </section>

            <section class="max-w-6xl mx-auto px-6 pb-14 space-y-8">
                <div class="rounded-3xl border border-orange-100 bg-white shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900">Comidas</h2>
                        <span class="text-xs rounded-full bg-orange-100 px-3 py-1 text-orange-700">{{ $comidas->count() }}</span>
                    </div>
                    @if($comidas->isEmpty())
                        <div class="text-sm text-gray-500">No hay comidas configuradas.</div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($comidas as $prod)
                                <div class="rounded-2xl border border-orange-100 p-3 hover:shadow-lg transition bg-white flex flex-col gap-2">
                                    <div class="h-40 w-full overflow-hidden rounded-xl bg-orange-50 flex items-center justify-center">
                                        @if ($prod->imagen)
                                            <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">Sin imagen</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                                        <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                                        <div class="text-sm font-bold text-orange-600">${{ number_format($prod->precio, 0, ',', '.') }}</div>
                                        <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                                    </div>
                                    <a href="{{ route('menu.domicilio') }}" class="mt-auto inline-flex items-center justify-center rounded-full bg-orange-500 px-3 py-2 text-xs font-semibold text-white hover:bg-orange-600">Agregar al pedido</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-3xl border border-orange-100 bg-white shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900">Bebidas</h2>
                        <span class="text-xs rounded-full bg-orange-100 px-3 py-1 text-orange-700">{{ $bebidas->count() }}</span>
                    </div>
                    @if($bebidas->isEmpty())
                        <div class="text-sm text-gray-500">No hay bebidas configuradas.</div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($bebidas as $prod)
                                <div class="rounded-2xl border border-orange-100 p-3 hover:shadow-lg transition bg-white flex flex-col gap-2">
                                    <div class="h-40 w-full overflow-hidden rounded-xl bg-orange-50 flex items-center justify-center">
                                        @if ($prod->imagen)
                                            <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">Sin imagen</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                                        <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                                        <div class="text-sm font-bold text-orange-600">${{ number_format($prod->precio, 0, ',', '.') }}</div>
                                        <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                                    </div>
                                    <a href="{{ route('menu.domicilio') }}" class="mt-auto inline-flex items-center justify-center rounded-full bg-orange-500 px-3 py-2 text-xs font-semibold text-white hover:bg-orange-600">Agregar al pedido</a>
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
