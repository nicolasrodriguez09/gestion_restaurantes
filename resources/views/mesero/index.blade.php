<x-app-layout>
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Operacion en sala</p>
            <h1 class="text-3xl font-bold text-slate-900">Panel de mesero</h1>
        </div>
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">
            Turno activo
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Tarjeta: Mesas -->
        <div class="col-span-2 rounded-3xl border border-slate-200 bg-white/90 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Mesas</h2>
                <span class="text-xs rounded-full bg-slate-100 px-3 py-1 text-slate-600">Total: {{ $mesas->count() }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($mesas as $mesa)
                    @php
                        $estado = strtolower($mesa->estado->nombreEstado ?? 'libre');
                        $color = str_contains($estado, 'ocup') ? 'border-rose-200 bg-rose-50' : 'border-emerald-200 bg-emerald-50';
                    @endphp

                    <a href="{{ route('mesero.mesa.show', $mesa->id) }}" class="block rounded-2xl border {{ $color }} p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Mesa</p>
                                <p class="text-2xl font-bold text-slate-900">#{{ $mesa->numeroMesa }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500">Capacidad</p>
                                <p class="font-semibold text-slate-900">{{ $mesa->capacidad }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 bg-white/70 text-slate-700">
                                <span class="h-2 w-2 rounded-full {{ str_contains($estado, 'ocup') ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                                {{ ucfirst($estado) }}
                            </span>
                            <span class="text-xs text-slate-500">Pedidos: {{ $mesa->pedidos->count() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Panel de Pedidos pendientes -->
        <div class="rounded-3xl border border-slate-200 bg-white/90 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-semibold text-slate-900">Pedidos en cocina</h2>
                <span class="text-xs rounded-full bg-slate-100 px-3 py-1 text-slate-600">{{ $pedidosPendientes->count() }}</span>
            </div>

            @if($pedidosPendientes->isEmpty())
                <div class="text-sm text-slate-500">No hay pedidos pendientes.</div>
            @else
                <ul class="space-y-3">
                    @foreach($pedidosPendientes as $pedido)
                        <li class="rounded-2xl border border-slate-100 bg-slate-50 p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xs text-slate-500">Mesa #{{ $pedido->id_mesa }}</div>
                                    <div class="font-semibold text-slate-900">Pedido #{{ $pedido->id }}</div>
                                    <div class="text-xs text-slate-500">Solicitado: {{ $pedido->fechaPedido }}</div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('mesero.mesa.show', $pedido->id_mesa) }}" class="inline-block rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-700">Ver mesa</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
