<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Ruta domiciliario</p>
            <h2 class="font-semibold text-2xl text-gray-900">Pedidos a entregar</h2>
        </div>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-6 space-y-6">
        @if(session('ok'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                {{ session('ok') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Por entregar</h3>
                <span class="text-xs px-3 py-1 rounded-full bg-amber-100 text-amber-700">Pendientes: {{ $pendientes->count() }}</span>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($pendientes as $pedido)
                @php
                    $estado = strtolower($pedido->estado->nombreEstado ?? '');
                    $badge = str_contains($estado, 'listo') ? 'bg-emerald-100 text-emerald-700' :
                             (str_contains($estado, 'espera') ? 'bg-amber-100 text-amber-700' :
                             (str_contains($estado, 'entreg') ? 'bg-slate-200 text-slate-700' : 'bg-slate-100 text-slate-700'));
                    $ready = str_contains($estado, 'listo');
                @endphp
                <a href="{{ route('domiciliario.pedido.show', $pedido->id) }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-500">Pedido #{{ $pedido->id }}</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $pedido->cliente_nombre ?? 'Cliente' }}</p>
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <svg class="h-3 w-3 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ $pedido->cliente_direccion ?? 'Direccion N/D' }}
                            </p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                            {{ $pedido->estado->nombreEstado ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                        <span>{{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</span>
                        <span class="font-semibold text-slate-900 text-sm">${{ number_format($pedido->totalPago, 2, '.', ',') }}</span>
                    </div>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Productos {{ $pedido->detalles->count() }}</span>
                        @if($ready)
                            <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700">Listo para entregar</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700">En cocina</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full text-sm text-slate-500">No hay pedidos de domicilio.</div>
            @endforelse
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Entregados</h3>
                <span class="text-xs px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">Total: {{ $entregados->count() }}</span>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($entregados as $pedido)
                    @php
                        $estado = strtolower($pedido->estado->nombreEstado ?? '');
                        $badge = str_contains($estado, 'listo') ? 'bg-emerald-100 text-emerald-700' :
                                 (str_contains($estado, 'espera') ? 'bg-amber-100 text-amber-700' :
                                 (str_contains($estado, 'entreg') ? 'bg-slate-200 text-slate-700' : 'bg-slate-100 text-slate-700'));
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs text-slate-500">Pedido #{{ $pedido->id }}</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $pedido->cliente_nombre ?? 'Cliente' }}</p>
                                <p class="text-xs text-slate-500">{{ $pedido->cliente_direccion ?? 'Direccion N/D' }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                                {{ $pedido->estado->nombreEstado ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>{{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</span>
                            <span class="font-semibold text-slate-900 text-sm">${{ number_format($pedido->totalPago, 2, '.', ',') }}</span>
                        </div>
                        <div class="mt-2 text-xs text-slate-500">Productos: {{ $pedido->detalles->count() }}</div>
                    </div>
                @empty
                    <div class="col-span-full text-sm text-slate-500">Aun no hay entregas registradas.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
