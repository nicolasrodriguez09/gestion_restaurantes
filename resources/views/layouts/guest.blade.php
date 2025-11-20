<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100">
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950"></div>
                <div class="absolute -left-20 -top-24 h-64 w-64 rounded-full bg-indigo-500/30 blur-3xl"></div>
                <div class="absolute -right-24 top-10 h-80 w-80 rounded-full bg-blue-400/25 blur-3xl"></div>
                <div class="absolute bottom-10 left-10 h-72 w-72 rounded-full bg-cyan-400/15 blur-3xl"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.08)_1px,transparent_0)] bg-[length:24px_24px]"></div>
            </div>

            <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
                <div class="grid w-full max-w-5xl grid-cols-1 overflow-hidden rounded-3xl bg-white/95 text-slate-900 shadow-2xl ring-1 ring-white/30 backdrop-blur lg:grid-cols-[1.05fr_1fr]">
                    <div class="relative hidden bg-gradient-to-br from-slate-950 via-indigo-800 to-indigo-600 p-10 text-white lg:flex lg:flex-col">
                        <div class="flex items-center gap-3 text-lg font-semibold">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/15">
                                <x-application-logo class="h-8 w-8 fill-current text-white" />
                            </div>
                            <span>DigiRest</span>
                        </div>

                        <div class="mt-8 space-y-3">
                            <p class="text-3xl font-bold leading-tight">Operacion gastronomica sin friccion.</p>
                            <p class="text-sm text-indigo-100/90 leading-relaxed">Monitorea mesas, pedidos y productos en un entorno rapido pensado para el equipo de sala y cocina.</p>
                        </div>

                        <div class="mt-auto pt-8 text-sm text-indigo-100/90">
                            <div class="flex flex-wrap gap-2 uppercase tracking-[0.18em] text-[0.72rem] font-semibold">
                                <span class="rounded-full bg-white/10 px-3 py-1">Dashboard vivo</span>
                                <span class="rounded-full bg-white/10 px-3 py-1">Alertas SLA</span>
                                <span class="rounded-full bg-white/10 px-3 py-1">Control de cocina</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 bg-white/98 px-6 py-8 backdrop-blur sm:px-8 md:px-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
