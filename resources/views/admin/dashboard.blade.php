<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">{{ __('Panel administrativo') }}</p>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Gestión centralizada') }}
                </h2>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700">
                {{ __('Modo administrador') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 space-y-8">
            <div class="grid gap-6 md:grid-cols-2">
                <a href="{{ route('admin.mesas.index') }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="p-6 relative">
                        <div class="flex items-center gap-4">
                            <span class="p-3 rounded-2xl bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M6 6h12a1 1 0 011 1v12a1 1 0 01-1 1H6a1 1 0 01-1-1V7a1 1 0 011-1z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('Operación en sala') }}</p>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('Mesas y reservas') }}</h3>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">{{ __('Controla estados, reasigna mesas y administra reservas desde un solo lugar.') }}</p>
                        <div class="mt-6 flex items-center justify-between text-sm font-semibold text-indigo-600">
                            <span>{{ __('Ir a la gestión de mesas') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.productos.index') }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="p-6 relative">
                        <div class="flex items-center gap-4">
                            <span class="p-3 rounded-2xl bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v6h6V3m-7 8h8l1 10H7l1-10z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('Carta y costos') }}</p>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('Productos y recetas') }}</h3>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">{{ __('Define platos, controla precios y mantén actualizado el catálogo disponible para los equipos.') }}</p>
                        <div class="mt-6 flex items-center justify-between text-sm font-semibold text-emerald-600">
                            <span>{{ __('Administrar productos') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <p class="text-sm text-gray-500">Productos publicados</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalProductos }}</p>
                    <p class="mt-1 text-xs text-gray-400">Con stock: {{ $productosConStock }} ({{ $unidadesDisponibles }} unidades)</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <p class="text-sm text-gray-500">Capacidad ocupada</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $porcentajeOcupacion }}%</p>
                    <p class="mt-1 text-xs text-gray-400">{{ $mesasOcupadas }} de {{ $mesasTotales }} mesas en uso</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <p class="text-sm text-gray-500">Pedidos activos</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $pedidosActivos }}</p>
                    <p class="mt-1 text-xs text-gray-400">Estados activos / en curso / pendientes</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
