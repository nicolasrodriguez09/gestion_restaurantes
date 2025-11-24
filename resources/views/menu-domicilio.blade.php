<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedir domicilio | DigiRest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="bg-gradient-to-b from-white via-slate-50 to-indigo-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-indigo-100 bg-white/90 backdrop-blur">
            <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 text-xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-white">DR</span>
                    Digi<span class="text-indigo-600">Rest</span>
                </a>
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">Ver menu</a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Acceder</a>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-6 py-12 space-y-6">
                <div class="rounded-3xl border border-indigo-100 bg-white shadow-xl p-6">
                    <div class="flex items-start justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-xs font-semibold tracking-[0.28em] text-indigo-600 uppercase">Domicilio</p>
                            <h1 class="text-3xl font-bold text-slate-900">Arma tu pedido</h1>
                            <p class="text-sm text-slate-600">Selecciona cantidades y dejanos tu direccion. El pedido va directo a cocina.</p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-sm">
                            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-indigo-700">Comidas: {{ $comidas->count() }}</span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1 text-sky-700">Bebidas: {{ $bebidas->count() }}</span>
                        </div>
                    </div>
                    @if(session('ok'))
                        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                            {{ session('ok') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('menu.pedido') }}" class="space-y-8">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-3">
                            <h3 class="text-lg font-semibold text-slate-900">Datos de entrega</h3>
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <label class="text-sm text-slate-600">Nombre</label>
                                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Telefono</label>
                                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Direccion</label>
                                    <input type="text" name="direccion" value="{{ old('direccion') }}" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Nota</label>
                                    <textarea name="nota" rows="2" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('nota') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-900">Resumen</h3>
                            <p class="text-sm text-slate-500">Selecciona cantidades y envia. Aparecera en cocina como “En espera”.</p>
                            <button type="submit" class="mt-4 w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition">Enviar pedido a domicilio</button>
                        </div>
                    </div>

                    <div class="space-y-6">
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
                                            <div class="h-36 w-full overflow-hidden rounded-xl bg-indigo-50 flex items-center justify-center">
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
                                            <div class="flex items-center gap-2 mt-auto">
                                                <input type="number" name="cantidad[{{ $prod->id }}]" value="{{ old('cantidad.'.$prod->id, 0) }}" min="0"
                                                       class="w-16 border rounded px-2 py-1 text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="text-xs text-slate-500">Unidades</span>
                                            </div>
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
                                            <div class="h-36 w-full overflow-hidden rounded-xl bg-indigo-50 flex items-center justify-center">
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
                                            <div class="flex items-center gap-2 mt-auto">
                                                <input type="number" name="cantidad[{{ $prod->id }}]" value="{{ old('cantidad.'.$prod->id, 0) }}" min="0"
                                                       class="w-16 border rounded px-2 py-1 text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="text-xs text-slate-500">Unidades</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
