<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiRest &mdash; Plataforma integral para la gestión gastronómica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(51,65,85,0.12) 1px, transparent 0);
            background-size: 22px 22px;
        }
    </style>
    {{-- @vite('resources/css/app.css') --}}
</head>
<body class="antialiased bg-slate-50 text-slate-900">
    <div class="relative min-h-screen flex flex-col">
        <div class="absolute inset-0 -z-10 opacity-40">
            <div class="w-full h-full hero-pattern"></div>
        </div>

        <!-- Navegación -->
        <header class="sticky top-0 z-30 backdrop-blur bg-white/90 border-b border-slate-100">
            <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 text-xl font-extrabold tracking-tight text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-white">DR</span>
                    Digi<span class="text-indigo-600">Rest</span>
                </a>

                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="#modulos" class="hover:text-indigo-600">Módulos</a>
                    <a href="#operacion" class="hover:text-indigo-600">Operación</a>
                    <a href="#testimonios" class="hover:text-indigo-600">Clientes</a>
                    <a href="#contacto" class="hover:text-indigo-600">Contacto</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-4 py-2 text-sm font-semibold rounded-lg border border-slate-200 hover:border-indigo-200 hover:text-indigo-700 transition">
                           Ir al panel
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden sm:inline-flex px-4 py-2 text-sm font-semibold rounded-lg border border-slate-200 hover:border-indigo-200 hover:text-indigo-700 transition">
                           Entrar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition">
                               Crear cuenta
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <!-- HERO -->
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute -top-40 -right-20 w-96 h-96 bg-indigo-200/60 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-32 -left-10 w-80 h-80 bg-orange-200/60 blur-3xl rounded-full"></div>
            </div>

            <div class="max-w-6xl mx-auto px-6 py-16 lg:py-20 grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] text-indigo-600">
                        GESTIÓN INTELIGENTE
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                        RESTAURANTES MODERNOS
                    </span>
                    <h1 class="mt-5 text-4xl lg:text-5xl font-black leading-tight text-slate-900">
                        Centraliza tu operación gastronómica en una sola pantalla
                    </h1>
                    <p class="mt-4 text-lg text-slate-600">
                        DigiRest conecta equipo de sala, cocina y gerencia con flujos claros, alertas en tiempo real y reportes que muestran exactamente cómo se mueve tu negocio.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        @guest
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 text-white font-semibold shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transition">
                           Probar sin costo
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/>
                           </svg>
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-6 py-3 rounded-2xl border border-slate-200 text-slate-800 font-semibold hover:border-indigo-200 hover:text-indigo-700 transition">
                           Ver el panel en vivo
                        </a>
                        @else
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center px-6 py-3 rounded-2xl bg-indigo-600 text-white font-semibold shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transition">
                           Abrir dashboard
                        </a>
                        @endguest
                    </div>
                    <div class="mt-8 grid grid-cols-2 gap-5 text-sm text-slate-600">
                        <div class="flex items-center gap-3 bg-white/70 rounded-xl p-4 border border-white shadow-sm">
                            <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-lg">24/7</div>
                            <p>Soporte de especialistas gastronómicos siempre disponible.</p>
                        </div>
                        <div class="flex items-center gap-3 bg-white/70 rounded-xl p-4 border border-white shadow-sm">
                            <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 font-bold text-lg">99%</div>
                            <p>Disponibilidad en la nube para no detener el servicio.</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="rounded-[32px] overflow-hidden shadow-2xl ring-1 ring-slate-900/5 bg-white">
                        <img src="{{ asset('images/welcome2.jpg') }}" alt="Panel DigiRest" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-8 -left-8 bg-white/95 border border-slate-100 rounded-3xl p-5 shadow-xl w-72">
                        <p class="text-sm font-semibold uppercase text-slate-500 tracking-wide">Servicio en vivo</p>
                        <div class="mt-3 flex items-center justify-between">
                            <div>
                                <p class="text-3xl font-bold text-slate-900">126</p>
                                <p class="text-xs text-slate-500">Comensales activos</p>
                            </div>
                            <div>
                                <p class="text-emerald-500 text-sm font-semibold">+18% Hoy</p>
                                <p class="text-xs text-slate-400">vs promedio diario</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>Mesas ocupadas</span>
                                <span>78%</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-indigo-500" style="width:78%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Barra de confianza -->
        <section class="bg-white border-y border-slate-100">
            <div class="max-w-6xl mx-auto px-6 py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-3xl font-black text-slate-900">+250</p>
                    <p class="text-sm text-slate-500">restaurantes operando</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-slate-900">45</p>
                    <p class="text-sm text-slate-500">ciudades conectadas</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-slate-900">12%</p>
                    <p class="text-sm text-slate-500">mayor rotación de mesas</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-slate-900">4.9/5</p>
                    <p class="text-sm text-slate-500">satisfacción del equipo</p>
                </div>
            </div>
        </section>

        <!-- Módulos -->
        <section id="modulos" class="py-20 bg-slate-950 text-slate-100">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto">
                    <p class="text-sm font-semibold tracking-[0.25em] text-slate-400 uppercase">Plataforma completa</p>
                    <h2 class="mt-3 text-3xl lg:text-4xl font-extrabold">Todo lo que sucede en tu restaurante, orquestado en un solo flujo</h2>
                </div>
                <div class="mt-12 grid md:grid-cols-3 gap-6">
                    <article class="rounded-3xl bg-white/5 border border-white/10 p-6">
                        <div class="inline-flex p-3 rounded-2xl bg-indigo-500/10 text-indigo-300 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16m-7 5h7"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Control de mesas</h3>
                        <p class="mt-2 text-sm text-slate-300">Mapa dinámico, bloqueo inteligente, alertas de tiempos y reasignaciones en segundos.</p>
                        <ul class="mt-4 space-y-2 text-sm text-slate-300">
                            <li>&bull; Estados visuales en vivo</li>
                            <li>&bull; Capacidad por zona y salón</li>
                            <li>&bull; Integración con reservas web</li>
                        </ul>
                    </article>
                    <article class="rounded-3xl bg-white/5 border border-white/10 p-6">
                        <div class="inline-flex p-3 rounded-2xl bg-emerald-500/10 text-emerald-300 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Pedidos & cocina</h3>
                        <p class="mt-2 text-sm text-slate-300">Tickets digitales con prioridades, pases automáticos y notificaciones a sala.</p>
                        <ul class="mt-4 space-y-2 text-sm text-slate-300">
                            <li>&bull; KDS con métricas de tiempos</li>
                            <li>&bull; Modificadores y combos guiados</li>
                            <li>&bull; Transferencia de cuentas segura</li>
                        </ul>
                    </article>
                    <article class="rounded-3xl bg-white/5 border border-white/10 p-6">
                        <div class="inline-flex p-3 rounded-2xl bg-orange-500/10 text-orange-200 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM4 20l4-8 4 3 4-6 4 11H4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Inteligencia del negocio</h3>
                        <p class="mt-2 text-sm text-slate-300">Reportes diarios y proyecciones con margen, merma y rotación de menú.</p>
                        <ul class="mt-4 space-y-2 text-sm text-slate-300">
                            <li>&bull; KPIs personalizables</li>
                            <li>&bull; Exportación contable</li>
                            <li>&bull; Alertas de inventario crítico</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- Operación -->
        <section id="operacion" class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <p class="text-sm font-semibold tracking-[0.25em] text-indigo-600 uppercase">Metodología</p>
                        <h2 class="mt-3 text-3xl font-bold text-slate-900">Una jornada completa alineada en 3 pasos</h2>
                        <p class="mt-3 text-slate-600">Implementamos flujos probados en restaurantes de servicio rápido y fine dining para reducir tiempos muertos.</p>
                        <div class="mt-8 space-y-6">
                            <div class="flex gap-5">
                                <div class="h-10 w-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold">1</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">Briefing y apertura</h3>
                                    <p class="text-sm text-slate-600">Checklist digital, dotación por sector y metas de ticket promedio visibles para todo el equipo.</p>
                                </div>
                            </div>
                            <div class="flex gap-5">
                                <div class="h-10 w-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold">2</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">Servicio sincronizado</h3>
                                    <p class="text-sm text-slate-600">Alertas automáticas según SLA de platos, comunicación sala-cocina y seguimiento al comensal.</p>
                                </div>
                            </div>
                            <div class="flex gap-5">
                                <div class="h-10 w-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold">3</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">Cierre con insights</h3>
                                    <p class="text-sm text-slate-600">Conciliación de ventas, costos por receta y plan de acción automático para el siguiente servicio.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-[32px] p-10 shadow-xl">
                        <h3 class="text-2xl font-semibold text-slate-900">Indicadores críticos a la vista</h3>
                        <p class="mt-2 text-slate-500">Comparte la misma información con sala, cocina y gerencia.</p>
                        <dl class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="p-5 rounded-2xl bg-white shadow-sm border border-slate-100">
                                <dt class="text-sm text-slate-500">Ticket promedio</dt>
                                <dd class="text-3xl font-extrabold text-slate-900">$18.40</dd>
                                <p class="text-xs text-emerald-500 mt-2">+6% vs semana pasada</p>
                            </div>
                            <div class="p-5 rounded-2xl bg-white shadow-sm border border-slate-100">
                                <dt class="text-sm text-slate-500">Tiempo mesa</dt>
                                <dd class="text-3xl font-extrabold text-slate-900">48 min</dd>
                                <p class="text-xs text-orange-500 mt-2">Objetivo: 45 min</p>
                            </div>
                            <div class="p-5 rounded-2xl bg-white shadow-sm border border-slate-100">
                                <dt class="text-sm text-slate-500">Rotación menú</dt>
                                <dd class="text-3xl font-extrabold text-slate-900">Top 5</dd>
                                <p class="text-xs text-slate-500 mt-2">Detecta platos lentos y promociones</p>
                            </div>
                            <div class="p-5 rounded-2xl bg-white shadow-sm border border-slate-100">
                                <dt class="text-sm text-slate-500">Alertas activas</dt>
                                <dd class="text-3xl font-extrabold text-slate-900">03</dd>
                                <p class="text-xs text-rose-500 mt-2">Inventario bajo y SLA roto</p>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonios -->
        <section id="testimonios" class="py-20 bg-slate-50">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto">
                    <p class="text-sm font-semibold tracking-[0.25em] text-indigo-600 uppercase">Historias reales</p>
                    <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-slate-900">Equipos que ya operan con DigiRest</h2>
                </div>
                <div class="mt-12 grid lg:grid-cols-3 gap-6">
                    <article class="rounded-3xl bg-white border border-slate-100 p-6 shadow-sm">
                        <p class="text-lg text-slate-700 italic">&ldquo;Reducimos 20 minutos el ciclo completo de la mesa. Los camareros saben exactamente qué hacer.&rdquo;</p>
                        <div class="mt-6 flex items-center gap-4">
                            <img src="{{ asset('images/welcome.jpg') }}" alt="Cliente" class="h-12 w-12 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-slate-900">Laura R.</p>
                                <p class="text-sm text-slate-500">Gerente &mdash; Brasa Norte</p>
                            </div>
                        </div>
                    </article>
                    <article class="rounded-3xl bg-white border border-slate-100 p-6 shadow-sm">
                        <p class="text-lg text-slate-700 italic">&ldquo;Los reportes al cierre cambiaron nuestra toma de decisiones. Ahora invertimos donde hay retorno.&rdquo;</p>
                        <div class="mt-6 flex items-center gap-4">
                            <img src="{{ asset('images/welcome2.jpg') }}" alt="Cliente" class="h-12 w-12 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-slate-900">Diego M.</p>
                                <p class="text-sm text-slate-500">Director &mdash; Grupo Piadina</p>
                            </div>
                        </div>
                    </article>
                    <article class="rounded-3xl bg-white border border-slate-100 p-6 shadow-sm">
                        <p class="text-lg text-slate-700 italic">&ldquo;La cocina recibe menos llamadas, todo llega directo al pas. El servicio se volvió silencioso y preciso.&rdquo;</p>
                        <div class="mt-6 flex items-center gap-4">
                            <img src="{{ asset('images/welcome.jpg') }}" alt="Cliente" class="h-12 w-12 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-slate-900">Marcela V.</p>
                                <p class="text-sm text-slate-500">Chef Ejecutiva &mdash; Casa Oriente</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section id="contacto" class="relative overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset('images/welcome2.jpg') }}" alt="" class="w-full h-full object-cover opacity-10">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-800/90 via-slate-900/90 to-slate-900/90"></div>
            </div>
            <div class="max-w-4xl mx-auto px-6 py-20 text-center text-white">
                <p class="text-sm font-semibold tracking-[0.3em] uppercase text-indigo-200">Hablemos hoy</p>
                <h2 class="mt-3 text-3xl lg:text-4xl font-black">Convierte tu operación gastronómica en una experiencia impecable</h2>
                <p class="mt-4 text-lg text-indigo-100">
                    Configuramos DigiRest en menos de 5 días hábiles, incluyendo tu carta, dispositivos y capacitación del equipo.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-6 py-3 rounded-2xl bg-white text-slate-900 font-semibold shadow-lg hover:bg-indigo-50 transition">
                       Solicitar demo guiada
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-6 py-3 rounded-2xl border border-white/30 text-white font-semibold hover:border-white transition">
                       Revisar documentación
                    </a>
                </div>
                <p class="mt-4 text-sm text-indigo-200">Sin tarjeta de crédito &bull; Cancelación cuando quieras</p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-950 text-slate-400">
            <div class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10 text-sm">
                <div>
                    <a href="/" class="text-xl font-extrabold text-white">Digi<span class="text-indigo-500">Rest</span></a>
                    <p class="mt-3 text-slate-400">Software para restaurantes, dark kitchens y grupos gastronómicos que buscan eficiencia radical.</p>
                </div>
                <div>
                    <p class="text-slate-200 font-semibold">Recursos</p>
                    <ul class="mt-3 space-y-2">
                        <li><a href="#modulos" class="hover:text-white">Módulos</a></li>
                        <li><a href="#operacion" class="hover:text-white">Operación</a></li>
                        <li><a href="#testimonios" class="hover:text-white">Historias</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-slate-200 font-semibold">Soporte</p>
                    <ul class="mt-3 space-y-2">
                        <li><a href="mailto:soporte@digirest.com" class="hover:text-white">soporte@digirest.com</a></li>
                        <li><span>+51 999 000 000</span></li>
                        <li><span>Av. Innovación 123, Lima</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 text-center text-xs text-slate-500 py-6">
                &copy; {{ date('Y') }} DigiRest. Construido con Laravel v{{ Illuminate\Foundation\Application::VERSION }} &mdash; PHP v{{ PHP_VERSION }}
            </div>
        </footer>
    </div>
</body>
</html>
