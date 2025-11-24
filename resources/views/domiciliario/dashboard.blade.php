<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Ruta domiciliario</p>
            <h2 class="font-semibold text-2xl text-gray-900">Pedidos a entregar</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-6 space-y-4">
        @if(session('ok'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                {{ session('ok') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($pedidos as $pedido)
                @php
                    $estado = strtolower($pedido->estado->nombreEstado ?? '');
                    $badge = str_contains($estado, 'listo') ? 'bg-emerald-100 text-emerald-700' :
                             (str_contains($estado, 'espera') ? 'bg-amber-100 text-amber-700' :
                             (str_contains($estado, 'entreg') ? 'bg-slate-200 text-slate-700' : 'bg-slate-100 text-slate-700'));
                @endphp
                <a href="{{ route('domiciliario.pedido.show', $pedido->id) }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-500">Pedido #{{ $pedido->id }}</p>
                            <p class="text-sm text-slate-700">{{ $pedido->cliente_nombre ?? 'Cliente' }}</p>
                            <p class="text-xs text-slate-500">{{ $pedido->cliente_direccion ?? 'Direccion N/D' }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                            {{ $pedido->estado->nombreEstado ?? 'N/A' }}
                        </span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">{{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">${{ number_format($pedido->totalPago, 2, '.', ',') }}</p>
                    <p class="mt-2 text-xs text-slate-500">Productos: {{ $pedido->detalles->count() }}</p>
                </a>
            @empty
                <div class="col-span-full text-sm text-slate-500">No hay pedidos de domicilio.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
